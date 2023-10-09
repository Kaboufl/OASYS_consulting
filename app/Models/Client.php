<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'raison_sociale',
        'siret',
        'ville'
    ];

    public function projets(): hasMany
    {
        return $this->hasMany(Projet::class);
    }
}
