<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupeDeClient;

class GroupeDeClientController extends Controller
{
    public function creerGroupesDeClients(Request $request)
{
    // Validation des données pour GroupeDeClient
    $validationDesDonnees = $request->validate([
        'code' => 'required|string',
        'libelle' => 'required|string',
        'description' => 'nullable|string'
    ]);

    // Récupération des données validées
    $input = $request->all();

    $input['createdBy'] = 1;
    $input['updatedBy'] = 1;

    // Création du groupe de clients avec les données validées
    $groupeDeClient = GroupeDeClient::create($input);

    return response()->json(['groupeDeClient créé' => $groupeDeClient, 'code' => 201]);
}


public function listerGroupesDeClients()
{
    // Récupération de tous les groupes de clients
    $groupesDeClients = GroupeDeClient::all();

    // Retourne les groupes de clients en format JSON
    return response()->json(['liste des groupes de clients' => $groupesDeClients, 'code' => 200]);
}


public function modifierGroupeDeClient(Request $request, $id)
{
    // Validation des données pour GroupeDeClient
    $validationDesDonnees = $request->validate([
        'code' => 'required|string',
        'libelle' => 'required|string',
        'description' => 'nullable|string'
    ]);

    // Trouver le groupe de clients par ID
    $groupeDeClient = GroupeDeClient::find($id);
    if (!$groupeDeClient) {
        return response()->json(['message' => 'Groupe de clients non trouvé'], 404);
    }

    // Mise à jour des données validées
    $input = $request->all();
    $input['updatedBy'] = 1; // Remplacer 1 par l'ID de l'utilisateur actuel

    $groupeDeClient->update($input);

    return response()->json(['groupeDeClient modifié' => $groupeDeClient, 'code' => 200]);
}

public function changerActivation($id)
{
    // Trouver le groupe de clients par ID
    $groupeDeClient = GroupeDeClient::find($id);

    // Changer l'état d'activation
    $message = "";
    if ($groupeDeClient->active == 1) {
        $groupeDeClient->active = 0;  
        $message = "Groupe de clients désactivé";
    } else {
        $groupeDeClient->active = 1; 
        $message = "Groupe de clients activé";
    }

    // Enregistrer les modifications

    $groupeDeClient->update();
    return response()->json([$message => $groupeDeClient, 'code' => 200]);
}

public function changerSuppression($id)
{
    // Trouver le groupe de clients par ID
    $groupeDeClient = GroupeDeClient::find($id);

    // Changer l'état de suppression
    $message = "";
    if ($groupeDeClient->deleted == 1) {
        $groupeDeClient->deleted = 0;  
        $message = "Groupe de clients restauré";
    } else {
        $groupeDeClient->deleted = 1; 
        $message = "Groupe de clients supprimé";
    }

    // Enregistrer les modifications
    $groupeDeClient->update();
    return response()->json([$message => $groupeDeClient, 'code' => 200]);
}

}
