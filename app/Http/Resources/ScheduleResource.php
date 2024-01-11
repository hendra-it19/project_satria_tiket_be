<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'hari_keberangkatan' => $this->hari_keberangkatan,
            'waktu_keberangkatan' => $this->jam_keberangkatan,
            'tujuan' => $this->tujuan,
            'terakhir_update' => Carbon::parse($this->updated_at)->format('d M Y'),
        ];
    }
}
