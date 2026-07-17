<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeImage extends Model
{
    use HasFactory;

    protected $table = 'home_images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'created_at',
        'updated_at'
    ];
}
