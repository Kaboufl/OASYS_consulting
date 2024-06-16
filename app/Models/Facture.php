<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'montant',
        'date_facture',
    ];

    public function etape(): HasOne
    {
        return $this->hasOne(Etape::class, 'id', 'id_facture');
    }
}
