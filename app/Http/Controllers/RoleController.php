<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function listeRole()
    {
        $roles = Role::all();
        return response()->json(['liste des roles'=>$roles, 'code' => 200]);
    }


    public function creerRole(Request $request)
    {

     $input = $request->all();
            // dd($input);
            $role = Role::create($input);
     
     return response()->json(['role crée'=>$role, 'code' => 201]);          
    }

    public function voirRole($id)
    {
        $role = Role::find($id);
        return response()->json(['voir le role'=>$role, 'code' => 200]);
    }


    public function modifierRole(Request $request, $id)
    {
       
        $role = Role::find($id);
        $input = $request->all();
        $role->update($input);
        return response()->json([' role modifié'=>$role, 'code' => 200]);
    }


    public function changerActivation($id)
    {
       
        $role = Role::find($id);
        $message = "";
        if($role->active == 1){
            $role->active = 0;  
            $message = "Rôle désactivé";
        }else {
            $role->active = 1; 
            $message = "Rôle activé";
        }
        $role->update();
        return response()->json([$message=>$role, 'code' => 200]);

    }

    public function changerSuppression($id)
    {
       
        $role = Role::find($id);
        $message = "";
        if($role->deleted == 1){
            $role->deleted = 0;  
            $message = "Rôle restauré ";
        }else {
            $role->deleted = 1; 
            $message = "Rôle supprimé";
        }
        $role->update();
        return response()->json([$message=>$role, 'code' => 200]);

    }
   

}
