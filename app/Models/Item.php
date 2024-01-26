<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'license',
        'wlStatus',
        'aliases',
        'link',
        'thumbnails',
        'attributes',
    ];

    protected function aliases(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value = null) => json_decode($value, true, 512, JSON_THROW_ON_ERROR),
        );
    }

    protected function attributes(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value = null) => json_decode($value, true, 512, JSON_THROW_ON_ERROR),
        );
    }
}
