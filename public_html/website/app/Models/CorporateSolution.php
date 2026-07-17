<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateSolution extends Model
{
    use HasFactory;

    protected $table = 'corporate_solutions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'created_at',
        'updated_at'
    ];
}
