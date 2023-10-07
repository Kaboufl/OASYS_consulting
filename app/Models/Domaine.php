<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domaine extends Model
{
    use HasFactory;

    public function projets(): HasMany
    {
        return $this->hasMany(Projet::class, 'domaine');
    }
}
