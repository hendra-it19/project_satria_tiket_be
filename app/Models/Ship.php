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

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'ship_id', 'id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'ship_id', 'id');
    }
}
