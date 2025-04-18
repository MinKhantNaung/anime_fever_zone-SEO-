<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['email_verify_status'];
}
