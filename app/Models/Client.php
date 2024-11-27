<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

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