<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeGenerate extends Model
{
    use HasFactory;

    protected $table = 'resume_generate';
    protected $primaryKey = 'id';
    protected $fillable = [
        'resume_id',
        'ip_address',
        'lat',
        'long',
        'created_at',
        'updated_at'
    ];
}
