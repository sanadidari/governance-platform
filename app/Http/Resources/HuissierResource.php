<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HuissierResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'nom'         => $this->nom,
            'prenom'      => $this->prenom,
            'email'       => $this->email,
            'telephone'   => $this->telephone,
            'status'      => $this->status,
            'tribunal'    => $this->whenLoaded('tribunal', fn() => [
                'id'  => $this->tribunal->id,
                'nom' => $this->tribunal->nom,
            ]),
        ];
    }
}
