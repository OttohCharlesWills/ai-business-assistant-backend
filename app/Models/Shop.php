<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'description',
        'is_active',
    ];

    // BELONGS TO USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}