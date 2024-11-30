<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Resources\ClientResource;
use App\Models\Equipement;
use App\Models\HistoriqueEquipement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['historique.equipement'])->paginate(10); // Charge l'historique et les équipements associés
        return ClientResource::collection($clients);
    }

    public function store(Request $request)
    {
        // Valider les données du client et des équipements
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->whereNull('deleted_at')
            ],
            'telephone' => 'nullable|string|max:15',
            'equipements' => 'nullable|array',
            'equipements.*.id' => 'required|exists:equipements,id', // Vérifie que chaque équipement existe
            'equipements.*.quantite' => 'required|integer|min:1', // Vérifie la quantité pour chaque équipement
        ]);
        Log::info('Données validées', $validated);

        $client = Client::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
        ]);

        Log::info('Client créé', $client->toArray());

        // Attribuer les équipements si fournis
        if (!empty($validated['equipements'])) {
            foreach ($validated['equipements'] as $equipementData) {
                $equipement = Equipement::findOrFail($equipementData['id']);

                if ($equipement->quantite_disponible < $equipementData['quantite']) {
                    return response()->json([
                        'message' => "Quantité insuffisante pour l'équipement {$equipement->nom}",
                    ], 400);
                }

                // Décrémenter la quantité disponible
                $equipement->quantite_disponible -= $equipementData['quantite'];
                $equipement->save();

                // Ajouter une entrée dans l'historique
                HistoriqueEquipement::create([
                    'client_id' => $client->id,
                    'equipement_id' => $equipement->id,
                    'quantite' => $equipementData['quantite'],
                    'type' => 'attribution',
                ]);
            }
        }

        // Retourner un ClientResource
        $client->load('historique.equipement');
        // Retourner les données du client et de ses équipements
        return response()->json([
            'client' => new ClientResource($client),
            'equipements' => $client->equipements
        ], 201);
    }

    public function show(Client $client)
    {
        return new ClientResource($client->load('equipements'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'telephone' => 'nullable|string|max:15',
        ]);

        $client->update($validated);
        return new ClientResource($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client supprimé avec succès']);
    }
}
