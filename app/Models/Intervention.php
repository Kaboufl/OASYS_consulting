<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'date_debut_intervention',
        'date_fin_intervention',
        'commentaire'
    ];

    public function intervenant(): BelongsTo
    {
        return $this->belongsTo(Intervenant::class, 'id_intervenant');
    }

    public function etape(): BelongsTo
    {
        return $this->belongsTo(Etape::class, 'id_etape');
    }
}
