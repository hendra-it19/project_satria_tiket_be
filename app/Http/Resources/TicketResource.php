<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tetapan = 30;
        $waktu = Carbon::parse($this->keberangkatan);
        $jam = $waktu->hour;
        $menit = $waktu->minute;
        $cekMenit = $menit - $tetapan;
        if ($menit - $tetapan <= 0) {
            $jam = $jam - 1;
            $menit = $cekMenit + 60;
        } else {
            $menit = $cekMenit;
        }
        return [
            'id' => $this->id,
            'nama_kapal' => $this->ship->nama_kapal,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'sisa_stok' => $this->sisa_stok,
            'tujuan' => $this->tujuan,
            'arahan' => 'Masuk pebuhan (check-in) sebelum ' . $jam . ':' . $menit,
            'waktu_berangkat' => $end = Carbon::parse($this->keberangkatan)->format('d M Y, H:i'),
            'waktu_rilis_tiket' => $start = Carbon::parse($this->created_at)->format('d M Y, H:i'),
            'keterangan' => Carbon::parse($this->keberangkatan)->diffForHumans(),
            'status' => (Carbon::now()->between($start, $end, true)) ? true : false,
        ];
    }
}
