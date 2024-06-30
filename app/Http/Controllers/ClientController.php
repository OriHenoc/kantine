<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    public function listeClient()
    {
        $clients = Client::all();
        return response()->json(['liste des clients'=>$clients, 'code' => 200]);
    }

    public function creerClient(Request $request)
    {
        // Validation des données pour Client
        $validationDesDonnees = $request->validate([
            'code' => 'required|string',
            'nomComplet' => 'required|string',
            'image' => 'nullable|image|max:10240', // facultatif
            'numero1' => 'required|string|unique:clients',
            'numero2' => 'nullable|string|unique:clients',
            'genre' => 'required|in:M,F',
            'email' => 'nullable|string|email|unique:clients',
            'groupeDeClientID' => 'required|exists:groupe_de_clients,id',
            'entreprise' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Gestion du fichier photo
        if ($request->hasFile('image')) {
            $cheminImage = $request->file('image')->store('', 'image_clients');
        } else {
            $cheminImage = null;
        }

        // Récupération des données validées
        $input = $request->all();
        $input['image'] = $cheminImage;

        // Ajout des champs 'createdBy' et 'updatedBy'
        $input['createdBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible
        $input['updatedBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible

        // Création du client avec les données validées
        $client = Client::create($input);

        return response()->json(['client créé' => $client, 'code' => 201]);
    }

    public function voirClient($id)
    {
        $client = Client::find($id);
        return response()->json(['voir client'=>$client, 'code' => 200]);
    }


    public function modifierInfo(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['Erreur' => 'Client non trouvé !', 'code' => 404]);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required|string',
            'nomComplet' => 'sometimes|required|string',
            'numero1' => 'sometimes|required|string|unique:clients,numero1,' . $id,
            'numero2' => 'sometimes|nullable|string|unique:clients,numero2,' . $id,
            'genre' => 'sometimes|required|in:M,F',
            'email' => 'sometimes|required|string|email|unique:clients,email,' . $id,
            'groupeDeClientID' => 'sometimes|required|exists:groupe_de_clients,id',
            'entreprise' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        // Mise à jour des informations du client avec les données validées
        $donneesValidees = $validator->validated();
        $client->fill($donneesValidees);

        // Mise à jour des autres champs non validés explicitement
        $donneesNonValidees = $request->except(array_keys($donneesValidees));
        $client->fill($donneesNonValidees);

        // Sauvegarde des informations du client
        $client->save();

        return response()->json(['message' => 'Informations du client modifiées', 'client' => $client, 'code' => 200]);
    }

    
    public function modifierPhoto(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['Erreur' => 'Client non trouvé !', 'code' => 404]);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        if ($request->hasFile('image')) {
            $nouveauCheminImage = $request->file('image')->store('', 'image_clients');

            // Supprimer l'ancienne image si nécessaire
            if ($client->image) {
                $ancienCheminDeImage = storage_path('app/public/image_clients/') . $client->image;

                if (File::exists($ancienCheminDeImage)) {
                    File::delete($ancienCheminDeImage);
                }
            }

            $client->image = $nouveauCheminImage;
            $client->save();

            return response()->json(['message' => 'image du client modifiée', 'client' => $client, 'code' => 200]);
        } else {
            return response()->json(['Erreur' => 'Fichier image non trouvé dans la requête !', 'code' => 400]);
        }
    }


    public function changerSuppression($id)
    {
       
        $client = Client::find($id);
        $message = "";
        if($client->deleted == 1){
            $client->deleted = 0;  
            $message = "Client restauré ";
        }else {
            $client->deleted = 1; 
            $message = "Client supprimé";
        }
        $client->update();
        return response()->json([$message=>$client, 'code' => 200]);

    }

    public function changerActivation($id)
    {
        // Trouver le client par ID
        $client = Client::find($id);

        // Changer l'état d'activation
        $message = "";
        if ($client->active == 1) {
            $client->active = 0;  
            $message = "Client désactivé";
        } else {
            $client->active = 1; 
            $message = "Client activé";
        }

        // Enregistrer les modifications
        $client->save();

        return response()->json([$message => $client, 'code' => 200]);
    }

}
