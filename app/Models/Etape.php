<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Etape extends Model
{
    use HasFactory;

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class, 'id_etape');
    }

    public function facture(): HasOne
    {
        return $this->hasOne(Facture::class, 'id', 'id_facture');
    }
}
