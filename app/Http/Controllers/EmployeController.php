<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EmployeController extends Controller
{
       // Lister les employés
       public function listeEmploye()
       {
           $employes = Employe::all();
           return response()->json(['liste des employés' => $employes, 'code' => 200]);
       }


       public function creerEmploye(Request $request)
       {
           // Validation des données pour Employe
           $validationDesDonnees = $request->validate([
               'nomComplet' => 'required|string',
               'photo' => 'required|image|max:10240',
               'numero1' => 'required|string|unique:employes',
               'numero2' => 'nullable|string|unique:employes',
               'genre' => 'required|in:M,F',
               'posteEmployeID' => 'required|exists:poste_employes,id',
               'email' => 'required|string|email|unique:employes',
           ]);
   
            // Gestion du fichier photo
        if ($request->hasFile('photo')) {
            $cheminPhoto = $request->file('photo')->store('', 'photos_employes');
        } else {
            $cheminPhoto = null;
        }
   
          // Récupération des données validées
        $input = $request->all();
        $input['photo'] = $cheminPhoto;

        // Ajout des champs 'createdBy' et 'updatedBy'
        $input['createdBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible
        $input['updatedBy'] = 1; // Remplacez 1 par l'ID de l'utilisateur authentifié, si disponible
   
           // Création de l'employé avec les données validées
           $employe = Employe::create($input);
   
           return response()->json(['employé créé' => $employe, 'code' => 201]);
           
       }



           // Voir un employé
    public function voirEmploye($id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employé non trouvé', 'code' => 404]);
        }

        return response()->json(['employe' => $employe, 'code' => 200]);
    }


    public function modifierInfoEmploye(Request $request, $id)
    {
        $employe = Employe::find($id);
        if (!$employe) {
            return response()->json(['message' => 'Employé non trouvé', 'code' => 404]);
        }

        // Validation des données pour Employe
        $validator = Validator::make($request->all(), [
            'nomComplet' => 'sometimes|required|string',
            'numero1' => 'sometimes|required|string|unique:employes,numero1,' . $id,
            'numero2' => 'sometimes|nullable|string|unique:employes,numero2,' . $id,
            'genre' => 'sometimes|required|in:M,F',
            'posteEmployeID' => 'sometimes|required|exists:poste_employes,id',
            'email' => 'sometimes|required|string|email|unique:employes,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        // Mise à jour des informations de l'employé avec les données validées
        $donneesValidees = $validator->validated();
        $employe->fill($donneesValidees);

        // Mise à jour des autres champs non validés explicitement
        $donneesNonValidees = $request->except(array_keys($donneesValidees));
        $employe->fill($donneesNonValidees);

        // Sauvegarde des informations de l'employé
        $employe->save();

        return response()->json(['employé modifié' => $employe, 'code' => 200]);
    }


    public function changerActivation($id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employé non trouvé', 'code' => 404]);
        }

        $message = "";
        if ($employe->active == 1) {
            $employe->active = 0;  
            $message = "Employé désactivé";
        } else {
            $employe->active = 1; 
            $message = "Employé activé";
        }

        $employe->save();

        return response()->json([$message => $employe, 'code' => 200]);
    }

    public function changerSuppression($id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employé non trouvé', 'code' => 404]);
        }

        $message = "";
        if ($employe->deleted == 1) {
            $employe->deleted = 0;  
            $message = "Employé restauré";
        } else {
            $employe->deleted = 1; 
            $message = "Employé supprimé";
        }

        $employe->save();

        return response()->json([$message => $employe, 'code' => 200]);
    }


    public function modifierPhoto(Request $request, $id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['Erreur' => 'Employé non trouvé !', 'code' => 404]);
        }

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        if ($request->hasFile('photo')) {
            $nouveauCheminPhoto = $request->file('photo')->store('', 'photos_employes');

            if ($employe->photo) {
                $ancienCheminDePhoto = public_path('assets/photosEmployes') . $employe->photo;

                if (File::exists($ancienCheminDePhoto)) {
                    File::delete($ancienCheminDePhoto);
                }
            }

            $employe->photo = $nouveauCheminPhoto;
            $employe->save();

            return response()->json(['message' => 'Photo de l\'employé modifiée', 'employé' => $employe, 'code' => 200]);
        } else {
            return response()->json(['Erreur' => 'Fichier photo non trouvé dans la requête !', 'code' => 400]);
        }
    }

}
