<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ApiPlatform\Metadata\ApiResource;

/**
 * @ApiResource
 */
#[ApiResource(
    paginationItemsPerPage: 10,
)]
class HistoriqueEquipement extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'equipement_id', 'quantite', 'type'];

    /**
     * Relation : Une entrée d'historique appartient à un client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation : Une entrée d'historique appartient à un équipement.
     */
    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }
}
