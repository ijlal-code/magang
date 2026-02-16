<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    // ==========================================
    // BAGIAN PUBLIK (LANDING PAGE)
    // ==========================================

    /**
     * Menampilkan halaman utama dengan data yang sudah diapprove.
     */
    public function index()
    {
        // Hanya ambil data dengan status 'approved'
        // Diurutkan dari yang terbaru (latest)
        $docs = Documentation::where('status', 'approved')->latest()->get();
        $projects = Project::where('status', 'approved')->latest()->get();
        
        return view('welcome', compact('docs', 'projects'));
    }

    // ==========================================
    // BAGIAN USER (UPLOAD & DELETE)
    // ==========================================

    /**
     * Menyimpan Dokumentasi baru dari User yang login.
     */
    public function storeDocumentation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048', // Maksimal 2MB
        ]);

        // Upload Gambar
        $path = $request->file('image')->store('public/uploads/docs');

        // Simpan ke Database
        Documentation::create([
            'user_id'     => Auth::id(),             // ID User yang sedang login
            'title'       => $request->title,
            'description' => $request->description,
            'author_name' => Auth::user()->name,     // Nama User otomatis
            'image_path'  => str_replace('public/', 'storage/', $path),
            'status'      => 'pending'               // Default pending (menunggu admin)
        ]);

        return back()->with('success_popup', 'Dokumentasi berhasil dikirim! Menunggu persetujuan Admin.');
    }

    /**
     * Menyimpan Project baru dari User yang login.
     */
    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_url' => 'required|url',
            'thumbnail' => 'required|image|max:2048', // Maksimal 2MB
        ]);

        // Upload Thumbnail
        $path = $request->file('thumbnail')->store('public/uploads/projects');

        // Simpan ke Database
        Project::create([
            'user_id'        => Auth::id(),
            'title'          => $request->title,
            'description'    => $request->description,
            'project_url'    => $request->project_url,
            'author_name'    => Auth::user()->name,
            'thumbnail_path' => str_replace('public/', 'storage/', $path),
            'status'         => 'pending'
        ]);

        return back()->with('success_popup', 'Projek berhasil dikirim! Menunggu persetujuan Admin.');
    }

    /**
     * Menghapus Dokumentasi (Hanya pemilik yang bisa).
     */
    public function deleteDocumentation($id)
    {
        $doc = Documentation::findOrFail($id);

        // Cek apakah yang menghapus adalah pemilik asli
        if ($doc->user_id != Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus item ini.');
        }

        // Hapus file gambar dari storage (opsional, agar hemat penyimpanan)
        $filePath = str_replace('storage/', 'public/', $doc->image_path);
        if(Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $doc->delete();

        return back()->with('success', 'Dokumentasi berhasil dihapus.');
    }

    /**
     * Menghapus Projek (Hanya pemilik yang bisa).
     */
    public function deleteProject($id)
    {
        $proj = Project::findOrFail($id);

        // Cek kepemilikan
        if ($proj->user_id != Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus item ini.');
        }

        // Hapus file thumbnail
        $filePath = str_replace('storage/', 'public/', $proj->thumbnail_path);
        if(Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $proj->delete();

        return back()->with('success', 'Projek berhasil dihapus.');
    }

    // ==========================================
    // BAGIAN ADMIN (APPROVAL)
    // ==========================================
    
    /**
     * Menampilkan halaman login khusus Admin.
     */
    public function adminLoginView() {
        return view('admin.login');
    }

    /**
     * Proses Login Admin (Hardcoded sesuai request).
     */
    public function adminLogin(Request $request) {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cek kredensial
        if($request->username == 'admin_tonasa' && $request->password == 'rahasia123') {
            session(['is_admin' => true]); // Set session admin
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    /**
     * Dashboard Admin untuk melihat data Pending.
     */
    public function dashboard() {
        // Cek session manual (middleware sederhana di controller)
        if(!session('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'Silahkan login admin terlebih dahulu.');
        }

        $pendingDocs = Documentation::where('status', 'pending')->latest()->get();
        $pendingProjects = Project::where('status', 'pending')->latest()->get();

        return view('admin.dashboard', compact('pendingDocs', 'pendingProjects'));
    }

    /**
     * Menyetujui (Approve) data masuk.
     */
    public function approve($type, $id) {
        if(!session('is_admin')) return abort(403);

        if($type == 'doc') {
            $data = Documentation::find($id);
            if($data) $data->update(['status' => 'approved']);
        }
        
        if($type == 'project') {
            $data = Project::find($id);
            if($data) $data->update(['status' => 'approved']);
        }

        return back()->with('success', 'Item berhasil disetujui dan kini tampil di publik.');
    }
}