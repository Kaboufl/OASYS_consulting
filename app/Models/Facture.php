<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'montant',
        'date_facture',
    ];

    public function etape() {
        return $this->belongsTo(Etape::class, 'id_facture');
    }
}
