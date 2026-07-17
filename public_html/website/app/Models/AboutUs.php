<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';
    protected $primaryKey = 'id';
    protected $fillable = [
        'description',
        'image',
        'created_at',
        'updated_at'
    ];

    public function aboutService()
    {
        return $this->hasMany(AboutService::class);
    }
}
