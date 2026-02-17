<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value'); // '1' = Butuh Approval, '0' = Langsung Tayang
            $table->timestamps();
        });

        // Insert Default Settings (Langsung Tayang / Tidak Butuh Approval)
        DB::table('system_settings')->insert([
            ['key' => 'anon_needs_approval', 'value' => '0'], // Default: Anonim Langsung Tayang
            ['key' => 'new_user_needs_approval', 'value' => '0'], // Default: User Baru Langsung Tayang
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
};