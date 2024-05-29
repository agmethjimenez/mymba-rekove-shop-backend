<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Mail\RecuperarPasswordMail;
use App\Models\Administrador;
use Illuminate\Support\Facades\Mail;
use App\Models\Credencial;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function usuariosTodos(Request $request)
{
    $pv = $request->query('pv');
    $tp = $request->query('tp');

    if ($pv !== null && $tp !== null) {
        $usuarios = Usuario::searchUsuariosByName($pv, $tp);
    } elseif ($pv !== null) {
        $usuarios = Usuario::searchUsuariosByName($pv);
    } elseif ($tp !== null && $tp != 0) {
        $usuarios = Usuario::searchUsuariosByName(null, $tp);
    } else {
        $usuarios = Usuario::getUsuarios();
    }

    return response()->json(['status' => true, 'usuarios' => $usuarios]);
}




    public function usuarioPorid($id)
    {
        return response()->json(Usuario::getUsuariosporid($id));
    }
    public function InsertUser(Request $request)
    {

        $request->validate([
            'identificacion' => 'required',
            'tipoId' => 'required',
            'primerNombre' => 'required',
            'segundoNombre' => 'nullable',
            'primerApellido' => 'required',
            'segundoApellido' => 'nullable',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'required',
            'password' => 'required|min:6'
        ]);
        $user = Usuario::InsertUser([
            'identificacion' => $request->identificacion,
            'tipoId' => $request->tipoId,
            'primerNombre' => $request->primerNombre,
            'segundoNombre' => $request->segundoNombre,
            'primerApellido' => $request->primerApellido,
            'segundoApellido' => $request->segundoApellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => $request->password,
        ]);

        if ($user) {
            return response()->json([
                'status' => true,
                'usuario' => $user
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'error al registrar'
            ]);
        }
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $crede = Usuario::Login([
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($crede['status']) {
            return response()->json($crede, 200);
        } else {
            $credeadmin = Administrador::login([
                'email' => $request->email,
                'password' => $request->password
            ]);
            if (!$credeadmin['status']) {
                return response()->json($crede, 500);
            }

            return response()->json($credeadmin, 200);
        }
    }

    public function UpdateDatos(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nombre1' => 'required',
            'nombre2' => 'nullable',
            'apellido1' => 'required',
            'apellido2' => 'nullable',
            'telefono' => 'required',
            'email' => 'required|email'
        ]);

        $update = Usuario::UpdateDatos([
            'id' => $request->id,
            'nombre1' => $request->nombre1,
            'nombre2' => $request->nombre2,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'telefono' => $request->telefono,
            'email' => $request->email
        ]);

        if ($update['status']) {
            return response()->json([
                "status" => true,
                "mensaje" => $update['mensaje']
            ]);
        } else {
            return response()->json([
                "status" => false,
                "mensaje" => $update['mensaje']
            ]);
        }
    }
    public function desactivarUsuario($id,$token)
    {

        $admin = Administrador::where('token',$token)->first();
        if(!$admin){
            return response()->json([
                "status" => true,
                "mensaje" => "Acceso no autorizado"
            ],401);
        }
        $desactivar = Usuario::desactivarUsuario($id);
        if ($desactivar["status"]) {
            return response()->json([
                "status" => true,
                "mensaje" => $desactivar['mensaje']
            ]);
        } else {
            return response()->json([
                "status" => false,
                "mensaje" => $desactivar['mensaje']
            ]);
        }
    }

    public function enviarCorreoDeRecuperacion(Request $request)
    {
        $email = $request->email;

        $update = Credencial::actualizarTokenyCodigo($email);

        if (!$update['status']) {
            return response()->json(["status" => false, "mensaje" => $update['mensaje']]);
        }

        $token = $update['token'];
        $codigo = $update['codigo'];

        Mail::to($email)->send(new RecuperarPasswordMail($email, $token, $codigo));

        return response()->json(['status' => true, 'message' => 'Correo enviado correctamente']);
    }

    public function validarExistenciaytoken(Request $request)
    {
        $validacion = Credencial::verificarExistenciayCaducidad($request->email, $request->token, $request->codigo);

        if (!$validacion['status']) {
            return response()->json([
                "status" => false,
                "mensaje" => $validacion['mensaje']
            ]);
        } else {
            return [
                "status" => true,
                "mensaje" => "Validado exitosamente"
            ];
        }
    }

    public static function CambioClave(Request $request)
    {
        $cambio = Credencial::CambioClave($request->id, $request->claveactual, $request->clavenueva, $request->clavenueva2);

        if ($cambio['status']) {
            return response()->json($cambio, 200);
        } else {
            return response()->json($cambio, 500);
        }
    }
}
