<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeDePlat;
use Illuminate\Support\Facades\Validator;


class TypeDePlatController extends Controller
{
    public function creerTypeDePlat(Request $request)
    {
        // Validation des données pour TypeDePlat
        $validationDesDonnees = $request->validate([
            'libelle' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Récupération des données validées
    $input = $request->all();

    $input['createdBy'] = 1;
    $input['updatedBy'] = 1;

        // Création du type de plat avec les données validées
        $typeDePlat = TypeDePlat::create($input);

        return response()->json(['typeDePlat créé' => $typeDePlat, 'code' => 201]);
    }


    public function listerTypeDePlats()
    {
        // Récupération de tous les types de plats
        $typesDePlats = TypeDePlat::all();

        // Retourne les types de plats en format JSON
        return response()->json(['liste des types de plats' => $typesDePlats, 'code' => 200]);
    }

    public function modifierTypeDePlat(Request $request, $id)
    {
        // Validation des données pour TypeDePlat
        $validationDesDonnees = $request->validate([
            'libelle' => 'required|string',
            'description' => 'nullable|string'
        ]);

        // Trouver le type de plat par ID
        $typeDePlat = TypeDePlat::find($id);
        if (!$typeDePlat) {
            return response()->json(['message' => 'Type de plat non trouvé'], 404);
        }

        // Mise à jour des données validées
        $input = $request->all();
        $input['updatedBy'] = 1; // Remplacer 1 par l'ID de l'utilisateur actuel

        $typeDePlat->update($input);

        return response()->json(['typeDePlat modifié' => $typeDePlat, 'code' => 200]);
    }


    public function changerActivation($id)
    {
        // Trouver le type de plat par ID
        $typeDePlat = TypeDePlat::find($id);

        // Changer l'état d'activation
        $message = "";
        if ($typeDePlat->active == 1) {
            $typeDePlat->active = 0;  
            $message = "Type de plat désactivé";
        } else {
            $typeDePlat->active = 1; 
            $message = "Type de plat activé";
        }

        // Enregistrer les modifications
        $typeDePlat->save();

        return response()->json([$message => $typeDePlat, 'code' => 200]);
    }

    public function changerSuppression($id)
    {
        // Trouver le type de plat par ID
        $typeDePlat = TypeDePlat::find($id);

        // Changer l'état de suppression
        $message = "";
        if ($typeDePlat->deleted == 1) {
            $typeDePlat->deleted = 0;  
            $message = "Type de plat restauré";
        } else {
            $typeDePlat->deleted = 1; 
            $message = "Type de plat supprimé";
        }

        // Enregistrer les modifications
        $typeDePlat->save();

        return response()->json([$message => $typeDePlat, 'code' => 200]);
    }

}
