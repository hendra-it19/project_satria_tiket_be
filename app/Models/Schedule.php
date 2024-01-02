<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function ship(): BelongsTo
    {
        return $this->belongsTo(Ship::class, 'ship_id', 'id');
    }
}
