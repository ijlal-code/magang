<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Project;
use App\Models\User;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    // ================== PUBLIC & VIEW ==================
    public function index()
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        if ($isAdmin) {
            $docs = Documentation::latest()->take(6)->get();
            $projects = Project::latest()->take(6)->get();
        } else {
            $docs = Documentation::where('status', 'approved')->latest()->take(6)->get();
            $projects = Project::where('status', 'approved')->latest()->take(6)->get();
        }

        return view('welcome', compact('docs', 'projects', 'isAdmin'));
    }

    public function allDocumentation(Request $request) {
        $query = Documentation::where('status', 'approved');
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        $docs = $query->latest()->paginate(9)->withQueryString();
        return view('lengkap.documentation', compact('docs'));
    }

    public function allProjects(Request $request) {
        $query = Project::where('status', 'approved');
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        $projects = $query->latest()->paginate(9)->withQueryString();
        return view('lengkap.projects', compact('projects'));
    }

    // ================== AUTHENTICATION ==================
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:users,name',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $setting = SystemSetting::where('key', 'new_user_needs_approval')->first();
        $needsApproval = $setting ? ($setting->value == '1') : false;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'can_post_directly' => !$needsApproval
        ]);

        Auth::login($user);
        
        $msg = $needsApproval 
            ? 'Akun dibuat! Namun postingan Anda nanti perlu persetujuan Admin (Sesuai pengaturan saat ini).' 
            : 'Akun berhasil dibuat! Anda bisa langsung upload karya.';

        return redirect()->route('home')->with('success', $msg);
    }

    public function login(Request $request) {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role === 'admin') {
                return redirect()->route('home')->with('success', 'Selamat datang Admin!');
            }
            return redirect()->route('home')->with('success', 'Selamat datang!');
        }
        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }

    // ================== CRUD UTAMA (Upload) ==================

    private function prepareUploadData(Request $request) {
        if (Auth::check()) {
            $user = Auth::user();
            $status = ($user->role === 'admin' || $user->can_post_directly) ? 'approved' : 'pending';
            
            return [
                'user_id' => $user->id,
                'author_name' => $user->name,
                'status' => $status,
                'msg' => ($status == 'approved') ? 'Berhasil upload dan tayang!' : 'Menunggu persetujuan Admin.'
            ];
        } else {
            $anonName = $request->filled('author_name_anon') ? $request->author_name_anon : 'Anonim';
            $setting = SystemSetting::where('key', 'anon_needs_approval')->first();
            $needsApproval = $setting ? ($setting->value == '1') : false;

            $status = $needsApproval ? 'pending' : 'approved';
            $msg = $needsApproval ? 'Upload berhasil! Menunggu persetujuan Admin.' : 'Upload berhasil dan langsung tayang!';

            return [
                'user_id' => null,
                'author_name' => $anonName,
                'status' => $status,
                'msg' => $msg
            ];
        }
    }

    private function storeImage($file, $folder) {
        $path = $file->store("uploads/{$folder}", 'public');
        return 'storage/' . $path;
    }

    public function storeDoc(Request $request) {
        // PERUBAHAN DISINI: max:5120 (5MB)
        $request->validate(['title'=>'required', 'image'=>'required|image|max:5120', 'description'=>'required']);
        $data = $this->prepareUploadData($request);
        $imagePath = $this->storeImage($request->file('image'), 'docs');

        Documentation::create([
            'user_id' => $data['user_id'],
            'author_name' => $data['author_name'],
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $data['status']
        ]);
        return back()->with('success', $data['msg']);
    }

    public function storeProject(Request $request) {
        // PERUBAHAN DISINI: max:5120 (5MB)
        $request->validate(['title'=>'required', 'project_url'=>'required', 'thumbnail'=>'required|image|max:5120']);
        $data = $this->prepareUploadData($request);
        $thumbPath = $this->storeImage($request->file('thumbnail'), 'projects');

        Project::create([
            'user_id' => $data['user_id'],
            'author_name' => $data['author_name'],
            'title' => $request->title,
            'description' => $request->description,
            'project_url' => $request->project_url,
            'thumbnail_path' => $thumbPath,
            'status' => $data['status']
        ]);
        return back()->with('success', $data['msg']);
    }

    // ================== EDIT & DELETE ==================

    public function updateDoc(Request $request, $id) {
        $doc = Documentation::findOrFail($id);
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $doc->user_id)) abort(403);
        
        // Validasi max 5MB jika ada gambar baru
        $request->validate([
            'image' => 'nullable|image|max:5120' 
        ]);

        $doc->title = $request->title;
        $doc->description = $request->description;
        if ($request->hasFile('image')) $doc->image_path = $this->storeImage($request->file('image'), 'docs');
        $doc->save();
        return back()->with('success', 'Update berhasil.');
    }

    public function deleteDoc($id) {
        $doc = Documentation::findOrFail($id);
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $doc->user_id)) abort(403);
        $doc->delete();
        return back()->with('success', 'Dihapus.');
    }

    public function updateProject(Request $request, $id) { 
        $proj = Project::findOrFail($id);
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $proj->user_id)) abort(403);
        
        // Validasi max 5MB jika ada gambar baru
        $request->validate([
            'thumbnail' => 'nullable|image|max:5120'
        ]);

        $proj->title = $request->title;
        $proj->project_url = $request->project_url;
        $proj->description = $request->description;
        if ($request->hasFile('thumbnail')) $proj->thumbnail_path = $this->storeImage($request->file('thumbnail'), 'projects');
        $proj->save();
        return back()->with('success', 'Updated.');
    }

    public function deleteProject($id) {
        $proj = Project::findOrFail($id);
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $proj->user_id)) abort(403);
        $proj->delete();
        return back()->with('success', 'Dihapus.');
    }

    // ================== ADMIN SETTINGS (Sama seperti sebelumnya) ==================
    public function adminDashboard() {
        if (Auth::user()->role !== 'admin') abort(403);
        $anonSetting = SystemSetting::where('key', 'anon_needs_approval')->first();
        $userSetting = SystemSetting::where('key', 'new_user_needs_approval')->first();
        $pendingAnonDocs = Documentation::whereNull('user_id')->where('status', 'pending')->count();
        $pendingAnonProjs = Project::whereNull('user_id')->where('status', 'pending')->count();
        $totalPendingAnon = $pendingAnonDocs + $pendingAnonProjs;
        return view('admin.dashboard', compact('anonSetting', 'userSetting', 'totalPendingAnon'));
    }

    public function updateSettings(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);
        SystemSetting::updateOrCreate(['key' => 'anon_needs_approval'], ['value' => $request->has('anon_needs_approval') ? '1' : '0']);
        SystemSetting::updateOrCreate(['key' => 'new_user_needs_approval'], ['value' => $request->has('new_user_needs_approval') ? '1' : '0']);
        return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }

    public function adminAnonPending() {
        if (Auth::user()->role !== 'admin') abort(403);
        $pendingDocs = Documentation::whereNull('user_id')->where('status', 'pending')->latest()->get();
        $pendingProjs = Project::whereNull('user_id')->where('status', 'pending')->latest()->get();
        return view('admin.anon-pending', compact('pendingDocs', 'pendingProjs'));
    }

    public function adminUsers(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);
        $query = User::where('role', '!=', 'admin');
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function bulkUserAction(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);
        $ids = $request->ids;
        $action = $request->action;
        if (empty($ids)) return back()->with('error', 'Pilih user dulu.');
        if ($action == 'restrict') { User::whereIn('id', $ids)->update(['can_post_directly' => false]); return back()->with('success', 'User dibatasi.'); }
        if ($action == 'allow') { User::whereIn('id', $ids)->update(['can_post_directly' => true]); return back()->with('success', 'User dibebaskan.'); }
        if ($action == 'delete') { User::destroy($ids); return back()->with('success', 'User dihapus.'); }
        return back();
    }

    public function approveItem($type, $id) {
        if (Auth::user()->role !== 'admin') abort(403);
        if($type == 'doc') Documentation::find($id)->update(['status' => 'approved']);
        if($type == 'project') Project::find($id)->update(['status' => 'approved']);
        return back()->with('success', 'Item disetujui.');
    }

    public function deleteUser($id) {
        if (Auth::user()->role !== 'admin') abort(403);
        User::destroy($id);
        return back()->with('success', 'User dihapus.');
    }
}