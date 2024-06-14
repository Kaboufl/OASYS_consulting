<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestataire extends Model
{
    use HasFactory;

    public function intervenant(): BelongsTo
    {
        return $this->belongsTo(Intervenant::class, 'id_intervenant');
    }
}
