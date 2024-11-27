<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Http\Resources\EquipementResource;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index()
    {
        $equipements = Equipement::paginate(10); // Pagination
        return EquipementResource::collection($equipements);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite_disponible' => 'required|integer|min:1',
        ]);

        $equipement = Equipement::create($validated);
        return new EquipementResource($equipement);
    }

    public function show(Equipement $equipement)
    {
        return new EquipementResource($equipement);
    }

    public function update(Request $request, Equipement $equipement)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite_disponible' => 'required|integer|min:1',
        ]);

        $equipement->update($validated);
        return new EquipementResource($equipement);
    }

    public function destroy(Equipement $equipement)
    {
        $equipement->delete();
        return response()->json(['message' => 'Équipement supprimé avec succès']);
    }
}
