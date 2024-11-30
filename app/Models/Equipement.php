<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ApiPlatform\Metadata\ApiResource;

/**
 * @ApiResource
 */
// #[ApiResource(
//     paginationItemsPerPage: 20,
//     formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json'], 'form' => ['multipart/form-data']]

// )]
class Equipement extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'etat', 'quantite_disponible', 'client_id', 'image_path',];

    /**
     * Relation : Un équipement appartient à un client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation : Un équipement possède plusieurs entrées d'historique.
     */
    public function historique()
    {
        return $this->hasMany(HistoriqueEquipement::class);
    }
    public $timestamps = true;
}
