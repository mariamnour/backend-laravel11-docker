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
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->whereNull('deleted_at')
            ],
            'telephone' => 'nullable|string|max:15',
            'equipements' => 'required|array', // Les équipements sont obligatoires
            'equipements.*.nom' => 'required|string|max:255',
            'equipements.*.description' => 'nullable|string',
            'equipements.*.quantite' => 'required|integer|min:1',
            'equipements.*.etat' => 'required|in:attribué,en attente de récupération,récupéré,en stock,en attente',
        ]);

        // Création du client
        $client = Client::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
        ]);

        // Création des équipements associés au client
        foreach ($validated['equipements'] as $equipementData) {
            $equipement = Equipement::create([
                'nom' => $equipementData['nom'],
                'description' => $equipementData['description'],
                'quantite_disponible' => $equipementData['quantite'],
                'etat' => $equipementData['etat'],
                'client_id' => $client->id,
            ]);

            HistoriqueEquipement::create([
                'client_id' => $client->id,
                'equipement_id' => $equipement->id,
                'quantite' => $equipementData['quantite'],
                'type' => 'attribution',
            ]);
        }
        $client->load('historique.equipement');

        return response()->json([
            'message' => 'Client et équipements créés avec succès',
            'client' => new ClientResource($client->load('equipements')),
        ], 201);
    }
    public function show(Client $client)
    {
        return new ClientResource($client->load(['historique.equipement']));
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
