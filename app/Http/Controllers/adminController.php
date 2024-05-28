<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function registro(Request $request){
        $admin = Administrador::createAdmin([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=> $request->password
        ]);

        if(!$admin){
            return response()->json([
                'status'=>false,
                'mensaje' => "Error al crear administrador"
            ]);
        }
        return response()->json([
            'status'=>true,
            'admin' => $admin
        ],201);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:administradores,id',
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $id = $request->id;
        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;
        $confirmPassword = $request->new_password_confirmation;

        $response = Administrador::changePassword($id, $currentPassword, $newPassword, $confirmPassword);

        return response()->json($response, $response['status'] ? 200 : 400);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:administradores,id',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $data = $request->only(['id', 'username', 'email']);

        $response = Administrador::updateAdmin($data);

        return response()->json($response, $response['status'] ? 200 : 400);
    }
}
