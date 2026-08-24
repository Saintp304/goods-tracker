<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'whatsapp_number',
        'phone',
        'email',
        'address',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
