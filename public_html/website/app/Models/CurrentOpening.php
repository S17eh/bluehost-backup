<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentOpening extends Model
{
    use HasFactory;

    protected $table = 'current_openings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
