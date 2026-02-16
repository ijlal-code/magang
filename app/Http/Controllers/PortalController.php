<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    // Halaman Utama (Landing Page)
    public function index()
    {
        // Hanya ambil yang sudah diapprove
        $docs = Documentation::where('status', 'approved')->latest()->get();
        $projects = Project::where('status', 'approved')->latest()->get();
        
        return view('welcome', compact('docs', 'projects'));
    }

    // Simpan Dokumentasi dari User
    public function storeDocumentation(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'author_name' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('public/uploads/docs');

        Documentation::create([
            'title' => $request->title,
            'description' => $request->description,
            'author_name' => $request->author_name,
            'image_path' => str_replace('public/', 'storage/', $path),
            'status' => 'pending' // Default pending
        ]);

        return back()->with('success', 'Dokumentasi berhasil dikirim! Menunggu persetujuan Admin.');
    }

    // Simpan Projek dari User
    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'project_url' => 'required|url',
            'author_name' => 'required',
            'thumbnail' => 'required|image|max:2048',
        ]);

        $path = $request->file('thumbnail')->store('public/uploads/projects');

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_url' => $request->project_url,
            'author_name' => $request->author_name,
            'thumbnail_path' => str_replace('public/', 'storage/', $path),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Projek berhasil dikirim! Menunggu persetujuan Admin.');
    }

    // --- BAGIAN ADMIN ---
    
    // Halaman Login Rahasia
    public function adminLoginView() {
        return view('admin.login');
    }

    public function adminLogin(Request $request) {
        // Hardcode sederhana sesuai request (Nama & Password khusus)
        if($request->username == 'admin_tonasa' && $request->password == 'rahasia123') {
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error', 'Akses Ditolak');
    }

    public function dashboard() {
        if(!session('is_admin')) return redirect()->route('admin.login');

        $pendingDocs = Documentation::where('status', 'pending')->get();
        $pendingProjects = Project::where('status', 'pending')->get();

        return view('admin.dashboard', compact('pendingDocs', 'pendingProjects'));
    }

    public function approve($type, $id) {
        if(!session('is_admin')) return abort(403);

        if($type == 'doc') Documentation::find($id)->update(['status' => 'approved']);
        if($type == 'project') Project::find($id)->update(['status' => 'approved']);

        return back()->with('success', 'Berhasil disetujui');
    }
}