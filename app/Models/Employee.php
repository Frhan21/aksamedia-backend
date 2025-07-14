<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'image', 'phone', 'email', 'position', 'division_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = \Illuminate\Support\Str::uuid();
        });
    }

    public function divisions()
    {
        return $this->belongsTo(Division::class);
    }
}
