<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $hidden = ['password', 'remember_token'];
    protected $fillable = ['name', 'username', 'email', 'password', 'phone'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = \Illuminate\Support\Str::uuid();
        });
    }
}
