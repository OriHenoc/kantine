<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;



class PlatController extends Controller
{
    public function creerPlat(Request $request)
    {
        // Validation des données pour Plat
        $validationDesDonnees = $request->validate([
            'libelle' => 'required|string',
            'description' => 'nullable|string',
            'typeDePlatsID' => 'required|exists:type_de_plats,id',
            'image' => 'nullable|image|max:10240',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'statut' => 'required|string'
        ]);

        // Gestion du fichier image
        if ($request->hasFile('image')) {
            $cheminImage = $request->file('image')->store('', 'images_plats');
        } else {
            $cheminImage = null;
        }

        // Récupération des données validées
        $input = $request->all();
        $input['image'] = $cheminImage;
        $input['createdBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible
        $input['updatedBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible

        // Création du plat avec les données validées
        $plat = Plat::create($input);

        return response()->json(['plat créé' => $plat, 'code' => 201]);
    }


    public function listerPlats()
    {
        // Récupération de tous les plats
        $plats = Plat::all();

        // Retourne les plats en format JSON
        return response()->json(['liste des plats' => $plats, 'code' => 200]);
    }

    public function modifierInfoPlat(Request $request, $id)
    {
        $plat = Plat::find($id);

        if (!$plat) {
            return response()->json(['Erreur' => 'Plat non trouvé !', 'code' => 404]);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'libelle' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'typeDePlatsID' => 'sometimes|required|exists:type_de_plats,id',
            'prix' => 'sometimes|required|numeric',
            'quantite' => 'sometimes|required|integer',
            'statut' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        // Mise à jour des informations du plat avec les données validées
        $donneesValidees = $validator->validated();
        $plat->fill($donneesValidees);

        // Mise à jour des autres champs non validés explicitement
        $donneesNonValidees = $request->except(array_keys($donneesValidees));
        $plat->fill($donneesNonValidees);

        // Sauvegarde des informations du plat
        $plat->save();

        return response()->json(['message' => 'Informations du plat modifiées', 'plat' => $plat, 'code' => 200]);
    }


    public function modifierPhoto(Request $request, $id)
    {
        $plat = Plat::find($id);

        if (!$plat) {
            return response()->json(['Erreur' => 'Plat non trouvé !', 'code' => 404]);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        if ($request->hasFile('image')) {
            $nouveauCheminImage = $request->file('image')->store('', 'images_plats');

            // Supprimer l'ancienne image si nécessaire
            if ($plat->image) {
                $ancienCheminDeImage = storage_path('app/public/images_plats/') . $plat->image;

                if (File::exists($ancienCheminDeImage)) {
                    File::delete($ancienCheminDeImage);
                }
            }

            $plat->image = $nouveauCheminImage;
            $plat->save();

            return response()->json(['message' => 'Image du plat modifiée', 'plat' => $plat, 'code' => 200]);
        } else {
            return response()->json(['Erreur' => 'Fichier image non trouvé dans la requête !', 'code' => 400]);
        }
    }



}
