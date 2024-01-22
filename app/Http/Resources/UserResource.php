<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nama' => $this->nama,
            'email' => $this->email,
            'hp' => $this->hp,
            'alamat' => $this->alamat,
            'title' => $this->title,
        ];
    }
}
