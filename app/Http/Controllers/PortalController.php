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

        if ($isAdmin) {
            // Admin melihat semua data (termasuk pending)
            $docs = Documentation::latest()->get();
            $projects = Project::latest()->get();
        } else {
            // User/Guest hanya melihat yang approved
            $docs = Documentation::where('status', 'approved')->latest()->get();
            $projects = Project::where('status', 'approved')->latest()->get();
        }

        // Variable 'users' tidak lagi dikirim ke 'welcome', 
        // karena manajemen user sudah punya halaman sendiri.
        return view('welcome', compact('docs', 'projects', 'isAdmin'));
    }

    // ================== AUTHENTICATION ==================
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:users,name',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'can_post_directly' => true // DEFAULT: User baru BEBAS UPLOAD langsung
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Anda bisa langsung upload karya.');
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
    
    // Helper: Menentukan status approved/pending berdasarkan hak akses user
    private function prepareUploadData(Request $request) {
        if (Auth::check()) {
            $user = Auth::user();
            // Jika Admin ATAU User yang punya hak post langsung -> Approved
            $status = ($user->role === 'admin' || $user->can_post_directly) ? 'approved' : 'pending';
            
            return [
                'user_id' => $user->id,
                'author_name' => $user->name,
                'status' => $status,
                'msg' => ($status == 'approved') ? 'Berhasil diupload dan langsung tayang!' : 'Berhasil dikirim! Menunggu persetujuan Admin.'
            ];
        } else {
            // Jika GUEST/ANONIM
            if (!$request->has('is_anonymous')) {
                abort(403, 'Anda harus login atau centang opsi Anonim.');
            }
            return [
                'user_id' => null,
                'author_name' => $request->author_name_anon ?? 'Anonim',
                'status' => 'pending', // Anonim selalu pending
                'msg' => 'Upload Anonim berhasil! Menunggu persetujuan Admin.'
            ];
        }
    }

    public function storeDoc(Request $request) {
        if (!Auth::check() && !$request->has('is_anonymous')) {
            return back()->with('error', 'Silahkan Login atau centang "Posting sebagai Anonim" untuk melanjutkan.');
        }

        $request->validate(['title'=>'required', 'image'=>'required|image', 'description'=>'required']);
        $path = $request->file('image')->store('public/uploads/docs');
        $data = $this->prepareUploadData($request);

        Documentation::create([
            'user_id' => $data['user_id'],
            'author_name' => $data['author_name'],
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => str_replace('public/', 'storage/', $path),
            'status' => $data['status']
        ]);

        return back()->with('success', $data['msg']);
    }

    public function storeProject(Request $request) {
        if (!Auth::check() && !$request->has('is_anonymous')) {
            return back()->with('error', 'Silahkan Login atau centang "Posting sebagai Anonim" untuk melanjutkan.');
        }

        $request->validate(['title'=>'required', 'project_url'=>'required', 'thumbnail'=>'required|image']);
        $path = $request->file('thumbnail')->store('public/uploads/projects');
        $data = $this->prepareUploadData($request);

        Project::create([
            'user_id' => $data['user_id'],
            'author_name' => $data['author_name'],
            'title' => $request->title,
            'description' => $request->description,
            'project_url' => $request->project_url,
            'thumbnail_path' => str_replace('public/', 'storage/', $path),
            'status' => $data['status']
        ]);

        return back()->with('success', $data['msg']);
    }

    public function updateDoc(Request $request, $id) {
        $doc = Documentation::findOrFail($id);
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() != $doc->user_id)) abort(403);

        $doc->title = $request->title;
        $doc->description = $request->description;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/uploads/docs');
            $doc->image_path = str_replace('public/', 'storage/', $path);
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
            $path = $request->file('thumbnail')->store('public/uploads/projects');
            $proj->thumbnail_path = str_replace('public/', 'storage/', $path);
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

    // ================== ADMIN USER MANAGEMENT (HALAMAN BARU) ==================

    public function adminUsers(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);

        $query = User::where('role', '!=', 'admin'); // Hanya tampilkan user biasa

        // Logika Pencarian (Search)
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

    // Aksi Massal (Bulk Action) dari Checkbox
    public function bulkUserAction(Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);
        
        $ids = $request->ids;
        $action = $request->action;

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada user yang dipilih.');
        }

        // Batasi Upload (can_post_directly = false)
        if ($action == 'restrict') {
            User::whereIn('id', $ids)->update(['can_post_directly' => false]);
            return back()->with('success', count($ids) . ' user berhasil DIBATASI uploadnya.');
        }

        // Bebaskan Upload (can_post_directly = true)
        if ($action == 'allow') {
            User::whereIn('id', $ids)->update(['can_post_directly' => true]);
            return back()->with('success', count($ids) . ' user berhasil DIBEBASKAN uploadnya.');
        }

        // Hapus User
        if ($action == 'delete') {
            User::destroy($ids);
            return back()->with('success', count($ids) . ' user berhasil DIHAPUS.');
        }

        return back();
    }

    // ================== ADMIN APPROVAL & UTILITIES ==================
    public function approveItem($type, $id) {
        if (Auth::user()->role !== 'admin') abort(403);
        
        if($type == 'doc') Documentation::find($id)->update(['status' => 'approved']);
        if($type == 'project') Project::find($id)->update(['status' => 'approved']);
        
        return back()->with('success', 'Item disetujui.');
    }

    // Fungsi delete single user (jika tombol hapus satuan ditekan)
    public function deleteUser($id) {
        if (Auth::user()->role !== 'admin') abort(403);
        User::destroy($id);
        return back()->with('success', 'User dihapus.');
    }
    
    // Toggle manual single user (opsional, jika masih dipakai)
    public function toggleUserStatus($id) {
        if (Auth::user()->role !== 'admin') abort(403);
        $user = User::findOrFail($id);
        $user->can_post_directly = !$user->can_post_directly;
        $user->save();
        return back()->with('success', 'Status user diubah.');
    }
}