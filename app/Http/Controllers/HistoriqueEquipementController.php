<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Equipement;
use App\Models\HistoriqueEquipement;
use App\Http\Resources\HistoriqueEquipementResource;
use Illuminate\Http\Request;

class HistoriqueEquipementController extends Controller
{
    public function index(Request $request)
    {
        $historique = HistoriqueEquipement::with(['client', 'equipement'])
            ->paginate(10);

        return HistoriqueEquipementResource::collection($historique);
    }

    public function assign(Request $request, Client $client)
    {
        $validated = $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $equipement = Equipement::findOrFail($validated['equipement_id']);

        if ($equipement->quantite_disponible < $validated['quantite']) {
            return response()->json(['message' => 'Quantité insuffisante'], 400);
        }

        $equipement->quantite_disponible -= $validated['quantite'];
        $equipement->save();

        HistoriqueEquipement::create([
            'client_id' => $client->id,
            'equipement_id' => $equipement->id,
            'quantite' => $validated['quantite'],
            'type' => 'attribution',
        ]);

        return response()->json(['message' => 'Équipement attribué avec succès']);
    }

    public function recover(Request $request, Client $client)
    {
        $validated = $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $equipement = Equipement::findOrFail($validated['equipement_id']);

        $equipement->quantite_disponible += $validated['quantite'];
        $equipement->save();

        HistoriqueEquipement::create([
            'client_id' => $client->id,
            'equipement_id' => $equipement->id,
            'quantite' => $validated['quantite'],
            'type' => 'récupération',
        ]);

        return response()->json(['message' => 'Équipement récupéré avec succès']);
    }
}
