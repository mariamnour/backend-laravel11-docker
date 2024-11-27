<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'etat', 'quantite_disponible', 'client_id'];

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
}
