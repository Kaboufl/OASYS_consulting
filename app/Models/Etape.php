<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etape extends Model
{
    use HasFactory;

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }
}
