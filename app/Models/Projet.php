<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'statut', 'taux_horaire', 'id_domaine', 'id_chef_projet', 'id_client'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function domaine(): BelongsTo
    {
        return $this->belongsTo(Domaine::class, 'id_domaine');
    }

    public function chefProj(): HasOne
    {
        return $this->hasOne(Intervenant::class, 'id_chef');
    }

    public function etapes(): HasMany
    {
        return $this->hasMany(Etape::class, 'id_projet');
    }
}
