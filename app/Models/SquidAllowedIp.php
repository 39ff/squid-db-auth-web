<?php

namespace App\Models;

use App\Models\Scopes\SquidUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SquidAllowedIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new SquidUserScope());
    }
}
