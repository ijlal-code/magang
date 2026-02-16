<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model // Ganti 'Project' untuk file Project.php
{
    use HasFactory;
    protected $guarded = ['id'];
}
