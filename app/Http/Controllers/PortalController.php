<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Project;
use App\Models\User;
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

        // Tampilkan hanya 6 item terbaru di Homepage agar ringan
        if ($isAdmin) {
            $docs = Documentation::latest()->take(6)->get();
            $projects = Project::latest()->take(6)->get();
        } else {
            $docs = Documentation::where('status', 'approved')->latest()->take(6)->get();
            $projects = Project::where('status', 'approved')->latest()->take(6)->get();
        }

        return view('welcome', compact('docs', 'projects', 'isAdmin'));
    }

    // [BARU] Halaman Semua Dokumentasi (Search + Pagination)
    public function allDocumentation(Request $request) {
        $query = Documentation::where('status', 'approved');

        // Logic Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Tampilkan 9 item per halaman
        $docs = $query->latest()->paginate(9)->withQueryString();
        return view('lengkap.documentation', compact('docs'));
    }

    // [BARU] Halaman Semua Projek (Search + Pagination)
    public function allProjects(Request $request) {
        $query = Project::where('status', 'approved');

        // Logic Pencarian
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
        ], [
            'name.unique' => 'Nama ini sudah digunakan.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'can_post_directly' => true
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
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

    // Helper: Menentukan Data Upload (User Login vs Guest)
    private function prepareUploadData(Request $request) {
        if (Auth::check()) {
            // Jika User Login
            $user = Auth::user();
            $status = ($user->role === 'admin' || $user->can_post_directly) ? 'approved' : 'pending';
            
            return [
                'user_id' => $user->id,
                'author_name' => $user->name,
                'status' => $status,
                'msg' => ($status == 'approved') ? 'Berhasil diupload dan langsung tayang!' : 'Berhasil dikirim! Menunggu persetujuan Admin.'
            ];
        } else {
            // Jika Guest / Belum Login
            // Ambil nama dari input samaran, atau default 'Anonim'
            $anonName = $request->filled('author_name_anon') ? $request->author_name_anon : 'Anonim';

            return [
                'user_id' => null,
                'author_name' => $anonName,
                'status' => 'pending', // Guest selalu butuh approval
                'msg' => 'Upload berhasil! Menunggu persetujuan Admin.'
            ];
        }
    }

    // Helper: Simpan Gambar ke Storage Public
    private function storeImage($file, $folder) {
        // PERBAIKAN: Gunakan disk 'public' agar bisa diakses browser
        $path = $file->store("uploads/{$folder}", 'public');
        return 'storage/' . $path;
    }

    public function storeDoc(Request $request) {
        // Validasi input
        $request->validate(['title'=>'required', 'image'=>'required|image', 'description'=>'required']);
        
        $imagePath = $this->storeImage($request->file('image'), 'docs');
        $data = $this->prepareUploadData($request);

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
        $request->validate(['title'=>'required', 'project_url'=>'required', 'thumbnail'=>'required|image']);
        
        $thumbPath = $this->storeImage($request->file('thumbnail'), 'projects');
        $data = $this->prepareUploadData($request);

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

    // ================== PROTECTED ACTIONS (Edit/Delete) ==================

    public function updateDoc(Request $request, $id) {
        $doc = Documentation::findOrFail($id);
        // Cek permission: Harus Admin atau Pemilik Asli
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $doc->user_id)) abort(403);

        $doc->title = $request->title;
        $doc->description = $request->description;
        
        if ($request->hasFile('image')) {
            $doc->image_path = $this->storeImage($request->file('image'), 'docs');
        }
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
        
        $proj->title = $request->title;
        $proj->project_url = $request->project_url;
        $proj->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            $proj->thumbnail_path = $this->storeImage($request->file('thumbnail'), 'projects');
        }

        $proj->save();
        return back()->with('success', 'Project Updated');
    }

    public function deleteProject($id) {
        $proj = Project::findOrFail($id);
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $proj->user_id)) abort(403);
        $proj->delete();
        return back()->with('success', 'Dihapus.');
    }

    // ================== ADMIN USER MANAGEMENT ==================

    public function adminUsers(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);

        $query = User::where('role', '!=', 'admin');

        // Search User
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function bulkUserAction(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);
        
        $ids = $request->ids;
        $action = $request->action;

        if (empty($ids)) return back()->with('error', 'Tidak ada user yang dipilih.');

        if ($action == 'restrict') {
            User::whereIn('id', $ids)->update(['can_post_directly' => false]);
            return back()->with('success', count($ids) . ' user DIBATASI uploadnya.');
        }

        if ($action == 'allow') {
            User::whereIn('id', $ids)->update(['can_post_directly' => true]);
            return back()->with('success', count($ids) . ' user DIBEBASKAN uploadnya.');
        }

        if ($action == 'delete') {
            User::destroy($ids);
            return back()->with('success', count($ids) . ' user DIHAPUS.');
        }

        return back();
    }

    // ================== ADMIN APPROVAL ==================
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