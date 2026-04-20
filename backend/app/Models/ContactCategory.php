<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}

