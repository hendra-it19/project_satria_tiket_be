<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'nama_kapal' => $this->ticket->ship->nama_kapal,
            'tujuan' => $this->ticket->tujuan,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
            'tanggal' => Carbon::parse($this->created_at)->format('d M Y'),
            'status' => $this->status,
        ];
    }
}
