<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'username', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}



