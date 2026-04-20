<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'number',
        'title',
        'description',
        'type',
        'file_url',
        'is_public',
        'created_by',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // Si quieres seguir usando "url" en el API, que apunte al enlace directo
    public function getUrlAttribute()
    {
        return $this->file_url;
    }
}

