<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Intervention extends Model
{
    use HasFactory;

    public function intervenant(): HasOne
    {
        return $this->hasOne(Intervenant::class, 'id', 'id_intervenant');
    }
}
