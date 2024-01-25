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

        if ($this->expired != null) {
            $exp = Carbon::now() > Carbon::parse($this->expired) ? true : false;
        } else {
            $exp = null;
        }

        if ($this->status ==  'selesai' && Carbon::parse($this->ticket->keberangkatan) <= Carbon::now()) {
            $status = 'berangkat';
        } else {
            $status = $this->status;
        }

        return [
            'id' => $this->id,
            'ticket' => new TicketResource($this->ticket),
            'transaction_id' => $this->transaction_id,
            'nama_kapal' => $this->ticket->ship->nama_kapal,
            'tujuan' => $this->ticket->tujuan,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
            'tanggal' => Carbon::parse($this->created_at)->format('d M Y'),
            'status' => $status,
            'metode_pembayaran' => $this->metode_pembayaran,
            'qr_url' => $this->qr_url,
            'expired' => $exp,
        ];
    }
}
