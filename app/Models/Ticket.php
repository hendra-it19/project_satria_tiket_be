<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function ship(): BelongsTo
    {
        return $this->belongsTo(Ship::class, 'ship_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'ticket_id', 'id');
    }

    public function kursi(): HasMany
    {
        return $this->hasMany(KursiPenumpang::class, 'ticket_id', 'id');
    }
}
