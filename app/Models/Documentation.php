<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    
    // Semua kolom selain ID boleh diisi (mass-assignable)
    protected $guarded = ['id'];

    // Memastikan tipe data is_pinned dibaca sebagai boolean
    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    // Relasi ke tabel User
    public function user() {
        return $this->belongsTo(User::class);
    }
}