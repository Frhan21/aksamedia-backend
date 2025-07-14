<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = \Illuminate\Support\Str::uuid();
        });
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
