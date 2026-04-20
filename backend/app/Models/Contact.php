<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_category_id',
        'name',
        'description',
        'phone',
        'map_url',
        'lat',
        'lng',
        'logo_path',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(ContactCategory::class, 'contact_category_id');
    }
}

