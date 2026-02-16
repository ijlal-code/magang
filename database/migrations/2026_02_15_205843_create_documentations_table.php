<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('documentations', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description'); // Deskripsi detail
        $table->string('image_path');
        $table->string('author_name'); // Nama pemagang
        $table->enum('status', ['pending', 'approved'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};
