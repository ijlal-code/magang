<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PortalController extends Controller
{
    // ================== PUBLIC & VIEW ==================
    public function index()
    {
        // Jika Admin: Tampilkan SEMUA (untuk dikelola)
        // Jika User/Guest: Tampilkan HANYA yang APPROVED
        
        $isAdmin = Auth::check() && Auth::user()->is_admin;

        if ($isAdmin) {
            $docs = Documentation::latest()->get();
            $projects = Project::latest()->get();
            $users = User::where('is_admin', false)->latest()->get(); // List user untuk admin
        } else {
            $docs = Documentation::where('status', 'approved')->latest()->get();
            $projects = Project::where('status', 'approved')->latest()->get();
            $users = [];
        }

        return view('welcome', compact('docs', 'projects', 'users', 'isAdmin'));
    }

    // ================== AUTH (LOGIN/REGISTER/LOGOUT) ==================
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->is_admin ? 'Admin' : 'User';
            return redirect()->route('home')->with('success', "Selamat datang kembali, $role!");
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Silahkan upload karyamu.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }

    // ================== CRUD DOKUMENTASI ==================
    public function storeDoc(Request $request) {
        $request->validate(['title'=>'required', 'image'=>'required|image', 'description'=>'required']);
        
        $path = $request->file('image')->store('public/uploads/docs');
        
        // Auto approve jika Admin yang upload
        $status = Auth::user()->is_admin ? 'approved' : 'pending';

        Documentation::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()->name,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => str_replace('public/', 'storage/', $path),
            'status' => $status
        ]);

        return back()->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    public function updateDoc(Request $request, $id) {
        $doc = Documentation::findOrFail($id);
        
        // Cek Izin: Admin BOLEH, Pemilik BOLEH
        if (!Auth::user()->is_admin && Auth::id() != $doc->user_id) abort(403);

        $doc->title = $request->title;
        $doc->description = $request->description;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/uploads/docs');
            $doc->image_path = str_replace('public/', 'storage/', $path);
        }
        
        $doc->save();
        return back()->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function deleteDoc($id) {
        $doc = Documentation::findOrFail($id);
        if (!Auth::user()->is_admin && Auth::id() != $doc->user_id) abort(403);
        
        $doc->delete();
        return back()->with('success', 'Dokumentasi dihapus.');
    }

    // ================== CRUD PROJEK ==================
    public function storeProject(Request $request) {
        $request->validate(['title'=>'required', 'project_url'=>'required', 'thumbnail'=>'required|image']);
        
        $path = $request->file('thumbnail')->store('public/uploads/projects');
        $status = Auth::user()->is_admin ? 'approved' : 'pending';

        Project::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()->name,
            'title' => $request->title,
            'description' => $request->description,
            'project_url' => $request->project_url,
            'thumbnail_path' => str_replace('public/', 'storage/', $path),
            'status' => $status
        ]);

        return back()->with('success', 'Projek berhasil ditambahkan!');
    }

    public function updateProject(Request $request, $id) {
        $proj = Project::findOrFail($id);
        if (!Auth::user()->is_admin && Auth::id() != $proj->user_id) abort(403);

        $proj->title = $request->title;
        $proj->project_url = $request->project_url;
        $proj->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('public/uploads/projects');
            $proj->thumbnail_path = str_replace('public/', 'storage/', $path);
        }

        $proj->save();
        return back()->with('success', 'Projek berhasil diperbarui.');
    }

    public function deleteProject($id) {
        $proj = Project::findOrFail($id);
        if (!Auth::user()->is_admin && Auth::id() != $proj->user_id) abort(403);
        $proj->delete();
        return back()->with('success', 'Projek dihapus.');
    }

    // ================== ADMIN ACTIONS ==================
    public function approveItem($type, $id) {
        if (!Auth::user()->is_admin) abort(403);
        
        if($type == 'doc') Documentation::find($id)->update(['status' => 'approved']);
        if($type == 'project') Project::find($id)->update(['status' => 'approved']);
        
        return back()->with('success', 'Item berhasil disetujui (Approved).');
    }

    public function deleteUser($id) {
        if (!Auth::user()->is_admin) abort(403);
        User::destroy($id); // Cascading delete doc & project handled by migration
        return back()->with('success', 'User berhasil dihapus.');
    }
}