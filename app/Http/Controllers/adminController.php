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
            'id' => 'required',
            'password_actual' => 'required',
            'new_password' => 'required',
        ]);

        $id = $request->id;
        $currentPassword = $request->password_actual;
        $newPassword = $request->new_password;
        $confirmPassword = $request->new_password2;

        $response = Administrador::changePassword($id, $currentPassword, $newPassword, $confirmPassword);

        return response()->json($response, $response['status'] ? 200 : 400);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $data = $request->only(['id', 'username', 'email']);

        $response = Administrador::updateAdmin($data);

        if (!$response['status']) {
            return response()->json([
                'status' => false,
                'message' => $response['message']
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => $response['message'],
            'admin' => $response['admin']
        ], 200);
    }

    public function getAdmins(){
        return response()->json(Administrador::all(),200);
    }

    public function searchByUsername(Request $request)
    {

        $username = $request->query('username');
        $result = Administrador::searchByUsername($username);

        return response()->json($result);
    }

    public function searchByToken(Request $request)
    {
        $token = $request->query('tk');
        $result = Administrador::searchByToken($token);

        if (!$result) {
            return response()->json([
                'status' => false,
                'message' => 'Administrador no encontrado con ese token'
            ], 404);
        }

        return response()->json($result,200);
    }
}
