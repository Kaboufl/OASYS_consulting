<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Intervenant extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id');
    }

    public function getPrestataire(): HasOne
    {
        return $this->HasOne(Prestataire::class, 'id_intervenant');
    }

    public function chefDe(): HasMany
    {
        return $this->hasMany(Projet::class, 'id_chef_projet', 'id');
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class, 'id_intervenant', 'id');
    }
}
