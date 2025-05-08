<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    // Disable timestamps completely
    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'name',
        'address',
        'food_name',
        'food_type',
        'discount_percentage',
        'discount_duration_hours',
        'discount',
        'photo_url',
        'opening_hours',
        'created_at',  // Add created_at to fillable
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

            // Set created_at manually since timestamps are disabled
            $model->created_at = now();
        });
    }

    // Relationship with Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}