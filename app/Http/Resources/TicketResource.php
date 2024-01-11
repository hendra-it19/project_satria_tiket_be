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
        if ($cekMenit <= 0) {
            $jam = $jam - 1;
            $menit = $cekMenit + 60;
        } else {
            if ($cekMenit < 10) {
                $menit = '0' . $cekMenit;
            } else {
                $menit = $cekMenit;
            }
        }
        $end = Carbon::parse($this->keberangkatan)->format('d M Y, H:i');
        $start = Carbon::parse($this->created_at)->format('d M Y, H:i');
        return [
            'id' => $this->id,
            'nama_kapal' => $this->ship->nama_kapal,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'sisa_stok' => $this->sisa_stok,
            'tujuan' => $this->tujuan,
            'arahan' => $jam . ':' . $menit,
            'waktu_berangkat' => $this->keberangkatan,
            'waktu_rilis_tiket' => $this->created_at,
            'keterangan' => Carbon::parse($this->keberangkatan)->diffForHumans(),
            'status' => (Carbon::now()->between($start, $end, true)) ? true : false,
        ];
    }
}
