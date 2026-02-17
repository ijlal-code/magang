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
        // 1. Buat User Admin (Bisa posting langsung)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@tonasa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',           // Role Admin
            'can_post_directly' => true, // Admin bebas upload
        ]);

        // 2. Buat User Biasa (Disimpan ke variabel $user untuk relasi dokumentasi)
        $user = User::create([
            'name' => 'Peserta Magang',
            'email' => 'user@tonasa.com',
            'password' => Hash::make('password'),
            'role' => 'user',             // Role User
            'can_post_directly' => false, // Harus diapprove dulu
        ]);

        // 3. Buat User Lain (Disimpan ke variabel $otherUser untuk relasi projek)
        $otherUser = User::create([
            'name' => 'Andi Magang',
            'email' => 'andi@tonasa.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'can_post_directly' => false,
        ]);

        // // 4. Buat 5 Dokumentasi Dummy (Milik 'Peserta Magang')
        // for ($i = 1; $i <= 5; $i++) {
        //     Documentation::create([
        //         'user_id' => $user->id, // Mengambil ID dari variabel $user di atas
        //         'title' => 'Kegiatan Magang Hari ke-' . $i,
        //         'description' => 'Ini adalah deskripsi kegiatan dokumentasi simulasi nomor ' . $i . '. Sangat seru dan edukatif.',
        //         'image_path' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', // Gambar placeholder
        //         'author_name' => $user->name,
        //         'status' => 'approved'
        //     ]);
        // }

        // // 5. Buat 5 Projek Dummy (Milik 'Andi Magang')
        // for ($i = 1; $i <= 5; $i++) {
        //     Project::create([
        //         'user_id' => $otherUser->id, // Mengambil ID dari variabel $otherUser
        //         'title' => 'Sistem Informasi ' . $i,
        //         'description' => 'Aplikasi berbasis web untuk manajemen data ke-' . $i,
        //         'project_url' => 'https://google.com',
        //         'thumbnail_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        //         'author_name' => $otherUser->name,
        //         'status' => 'approved'
        //     ]);
        // }
    }
}