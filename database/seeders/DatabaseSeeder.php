<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Documentation;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

    // 1. Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@tonasa.com',
            'password' => Hash::make('password'), // Password admin
            'is_admin' => true,
        ]);

        // 1. Buat User Admin/Utama (Agar kamu bisa login)
        $user = User::create([
            'name' => 'Magang User',
            'email' => 'user@tonasa.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Buat User Lain (Untuk simulasi orang lain)
        $otherUser = User::create([
            'name' => 'Andi Magang',
            'email' => 'andi@tonasa.com',
            'password' => Hash::make('password'),
        ]);

        // 3. Buat 5 Dokumentasi Dummy
        for ($i = 1; $i <= 5; $i++) {
            Documentation::create([
                'user_id' => $user->id,
                'title' => 'Kegiatan Magang Hari ke-' . $i,
                'description' => 'Ini adalah deskripsi kegiatan dokumentasi simulasi nomor ' . $i . '. Sangat seru dan edukatif.',
                'image_path' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', // Gambar placeholder
                'author_name' => $user->name,
                'status' => 'approved'
            ]);
        }

        // 4. Buat 5 Projek Dummy
        for ($i = 1; $i <= 5; $i++) {
            Project::create([
                'user_id' => $otherUser->id, // Milik user lain (untuk tes tombol delete tidak muncul)
                'title' => 'Sistem Informasi ' . $i,
                'description' => 'Aplikasi berbasis web untuk manajemen data ke-' . $i,
                'project_url' => 'https://google.com',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'author_name' => $otherUser->name,
                'status' => 'approved'
            ]);
        }
    }
}