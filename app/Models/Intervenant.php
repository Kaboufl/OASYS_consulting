<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intervenant extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id');
    }
}
