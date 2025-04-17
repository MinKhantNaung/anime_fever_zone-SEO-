<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'status'
    ];

    protected $hidden = ['token'];
}
