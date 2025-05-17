<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    protected $table = 'coments';
    protected $fillable = ['name', 'rating', 'coments'];
    public $timestamps = false; // jika tabel tidak ada kolom created_at/updated_at
}