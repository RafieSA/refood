<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    protected $table = 'coments';
    protected $fillable = ['name', 'rating', 'coments', 'restaurant_id'];
    public $timestamps = true; // Menggunakan created_at
    const UPDATED_AT = null; // Hanya gunakan created_at, tidak ada updated_at
    
    // Relasi ke Restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}