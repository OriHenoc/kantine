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

}
