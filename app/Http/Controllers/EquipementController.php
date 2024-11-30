<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Http\Resources\EquipementResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipementController extends Controller
{
    public function index()
    {
        $equipements = Equipement::paginate(10); // Pagination
        return EquipementResource::collection($equipements);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite_disponible' => 'required|integer',
            'etat' => 'required|in:attribué,en attente de récupération,récupéré',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $validatedData['image_path'] = $validatedData['image_path'] ?? null;
        // if ($request->hasFile('image_path')) {
        //     $imagePath = $request->file('image_path')->store('images', 'public');
        //     $validatedData['image_path'] = $imagePath;
        // }


        $equipement = Equipement::create($validatedData);
        // $imageUrl = $equipement->image_path ? Storage::url($equipement->image_path) : null;

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

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'image_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            // Sauvegarde du fichier dans le dossier 'images'
            $filePath = $request->file('image_path')->store('images', 'public');

            return response()->json([
                'image_path' => $filePath, // Chemin public
                'url' => Storage::url($filePath), // URL complète
            ], 201);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
