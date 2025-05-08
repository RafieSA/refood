<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Nonaktifkan timestamps
    public $timestamps = false;

    protected $fillable = [
        'Restaurant_Name',
        'Restaurant_Photo',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 👇 Tambahan untuk UUID
    public $incrementing = false;
    protected $keyType = 'string';

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'admin_id');
    }
}
