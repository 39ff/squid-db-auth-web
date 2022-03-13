<?php

namespace App\Models;

use App\Models\Scopes\SquidUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SquidUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'password',
        'enabled',
        'fullname',
        'comment'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new SquidUserScope());
    }
}
