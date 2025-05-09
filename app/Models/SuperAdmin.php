<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class SuperAdmin extends Authenticatable
{
    use Notifiable;

    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // UUID is a string

    protected $fillable = [
        'id', // Pastikan UUID disertakan
        'name',
        'email',
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate UUID saat model dibuat
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
