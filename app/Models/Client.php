<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @ApiResource
 */
// #[ApiResource(
//     paginationItemsPerPage: 10,
//     formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json'], 'form' => ['multipart/form-data']]
// )]
class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nom', 'email', 'telephone'];

    /**
     * Relation : Un client possède plusieurs équipements.
     */
    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }

    /**
     * Relation : Un client possède plusieurs entrées d'historique.
     */
    public function historique()
    {
        return $this->hasMany(HistoriqueEquipement::class);
    }
}
