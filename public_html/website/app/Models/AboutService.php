<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutService extends Model
{
    use HasFactory;

    protected $table = 'about_service';
    protected $primaryKey = 'id';
    protected $fillable = [
        'about_us_id',
        'service',
        'created_at',
        'updated_at'
    ];

    public function aboutUs()
    {
        return $this->belongsTo(AboutUs::class);
    }
}
