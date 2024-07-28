<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LigneDeCommande;
use Illuminate\Support\Facades\Validator;



class LigneDeCommandeController extends Controller
{
     // Lister les lignes de commande
     public function listeLigneCommandes()
     {
         $lignesDeCommande = LigneDeCommande::all();
         return response()->json(['liste des lignes de commande' => $lignesDeCommande, 'code' => 200]);
     }


     // Créer une ligne de commande
    public function creerLigneDeCommande(Request $request)
    {
        // Validation des données pour LigneDeCommande
        $validationDesDonnees = $request->validate([
            'statut' => 'required|string',
            'commandeID' => 'required|exists:commandes,id',
            'utilisateurID' => 'required|exists:utilisateurs,id',
        ]);

        // Récupération des données validées
        $input = $request->all();

        // Ajout des champs 'createdBy' et 'updatedBy'
        $input['createdBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible
        $input['updatedBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible

        // Création de la ligne de commande avec les données validées
        $ligneDeCommande = LigneDeCommande::create($input);

        return response()->json(['ligne de commande créée' => $ligneDeCommande, 'code' => 201]);
    }


    // Voir une ligne de commande
    public function voirLigneDeCommande($id)
    {
        $ligneDeCommande = LigneDeCommande::find($id);

        if (!$ligneDeCommande) {
            return response()->json(['message' => 'Ligne de commande non trouvée', 'code' => 404]);
        }

        return response()->json(['ligne de commande' => $ligneDeCommande, 'code' => 200]);
    }


    // Modifier les informations d'une ligne de commande
    public function modifierInfoLigneDeCommande(Request $request, $id)
    {
        $ligneDeCommande = LigneDeCommande::find($id);
        if (!$ligneDeCommande) {
            return response()->json(['message' => 'Ligne de commande non trouvée', 'code' => 404]);
        }

        // Validation des données pour LigneDeCommande
        $validator = Validator::make($request->all(), [
            'statut' => 'sometimes|required|string',
            'commandeID' => 'sometimes|required|exists:commandes,id',
            'utilisateurID' => 'sometimes|required|exists:utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        // Mise à jour des informations de la ligne de commande avec les données validées
        $donneesValidees = $validator->validated();
        $ligneDeCommande->fill($donneesValidees);

        // Mise à jour des autres champs non validés explicitement
        $donneesNonValidees = $request->except(array_keys($donneesValidees));
        $ligneDeCommande->fill($donneesNonValidees);

        // Sauvegarde des informations de la ligne de commande
        $ligneDeCommande->save();

        return response()->json(['ligne de commande modifiée' => $ligneDeCommande, 'code' => 200]);
    }


    // Changer l'activation d'une ligne de commande
    public function changerActivation($id)
    {
        $ligneDeCommande = LigneDeCommande::find($id);

        if (!$ligneDeCommande) {
            return response()->json(['message' => 'Ligne de commande non trouvée', 'code' => 404]);
        }

        $message = "";
        if ($ligneDeCommande->active == 1) {
            $ligneDeCommande->active = 0;  
            $message = "Ligne de commande désactivée";
        } else {
            $ligneDeCommande->active = 1; 
            $message = "Ligne de commande activée";
        }

        $ligneDeCommande->save();

        return response()->json([$message => $ligneDeCommande, 'code' => 200]);
    }

    // Changer la suppression d'une ligne de commande
    public function changerSuppression($id)
    {
        $ligneDeCommande = LigneDeCommande::find($id);

        if (!$ligneDeCommande) {
            return response()->json(['message' => 'Ligne de commande non trouvée', 'code' => 404]);
        }

        $message = "";
        if ($ligneDeCommande->deleted == 1) {
            $ligneDeCommande->deleted = 0;  
            $message = "Ligne de commande restaurée";
        } else {
            $ligneDeCommande->deleted = 1; 
            $message = "Ligne de commande supprimée";
        }

        $ligneDeCommande->save();

        return response()->json([$message => $ligneDeCommande, 'code' => 200]);
    }

}
