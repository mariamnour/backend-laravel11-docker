<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoriqueEquipementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client' => new ClientResource($this->whenLoaded('client')),
            'equipement' => new EquipementResource($this->whenLoaded('equipement')),
            'quantite' => $this->quantite,
            'type' => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
