<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'reference'           => $this->reference,
            'type'                => $this->type,
            'statut'              => $this->statut,
            'proof_url'           => $this->proof_url,
            'latitude'            => $this->latitude,
            'longitude'           => $this->longitude,
            'destinataire_nom'    => $this->destinataire_nom,
            'destinataire_adresse'=> $this->destinataire_adresse,
            'date_signification'  => $this->date_signification?->toDateString(),
            'created_at'          => $this->created_at->toDateTimeString(),
            'huissier'            => $this->whenLoaded('huissier', fn() => [
                'id'     => $this->huissier->id,
                'nom'    => $this->huissier->nom,
                'prenom' => $this->huissier->prenom,
            ]),
        ];
    }
}
