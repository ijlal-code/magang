<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Tabel Users
        Schema::table('users', function (Blueprint $table) {
            // Ubah is_admin jadi role (jika belum ada, sesuaikan)
            // Kita drop is_admin lama dan ganti dengan role string agar fleksibel
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
            $table->string('role')->default('user'); // 'admin' atau 'user'
            
            // Nama harus unik
            $table->string('name')->unique()->change();
            
            // Kolom izin posting langsung (tanpa approval admin)
            $table->boolean('can_post_directly')->default(true); 
        });

        // 2. Update Tabel Documentations (Agar bisa Null User ID untuk Anonim)
        Schema::table('documentations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        // 3. Update Tabel Projects (Agar bisa Null User ID untuk Anonim)
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Rollback logic (opsional, disederhanakan)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'can_post_directly']);
            $table->boolean('is_admin')->default(false);
            $table->dropUnique(['name']);
        });
    }
};