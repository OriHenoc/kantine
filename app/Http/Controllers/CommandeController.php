<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use Illuminate\Support\Facades\Validator;


class CommandeController extends Controller
{
    public function listeCommandes()
    {
        $commandes = Commande::all();
        return response()->json(['liste des commandes' => $commandes, 'code' => 200]);
    }


    public function creerCommande(Request $request)
    {
        // Validation des données pour Commande
        $validationDesDonnees = $request->validate([
            'quantite' => 'required|integer|min:1',
            'platID' => 'required|exists:plats,id',
        ]);

        // Récupération des données validées
        $input = $request->all();
        $input['createdBy'] = 1; // Remplacer par l'ID de l'utilisateur actuel
        $input['updatedBy'] = 1; // Remplacer par l'ID de l'utilisateur actuel

        // Création de la commande avec les données validées
        $commande = Commande::create($input);

        return response()->json(['commande créée' => $commande, 'code' => 201]);
    }

    public function voirCommande($id)
    {
        $commande = Commande::find($id);
        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée', 'code' => 404]);
        }
        return response()->json(['commande' => $commande, 'code' => 200]);
    }


    public function modifierInfoCommande(Request $request, $id)
    {
        $commande = Commande::find($id);
        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée', 'code' => 404]);
        }

        // Validation des données pour Commande
        $validator = Validator::make($request->all(), [
            'quantite' => 'sometimes|required|integer|min:1',
            'platID' => 'sometimes|required|exists:plats,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        // Mise à jour des informations de la commande avec les données validées
        $donneesValidees = $validator->validated();
        $commande->fill($donneesValidees);

        // Mise à jour des autres champs non validés explicitement
        $donneesNonValidees = $request->except(array_keys($donneesValidees));
        $commande->fill($donneesNonValidees);

        // Sauvegarde des informations de la commande
        $commande->save();

        return response()->json(['commande modifiée' => $commande, 'code' => 200]);
    }
}
