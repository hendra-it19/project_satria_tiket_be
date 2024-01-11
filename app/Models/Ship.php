<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ship extends Model
{
    use HasFactory;

    protected $table = 'ships';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'ship_id', 'id');
    }
}
