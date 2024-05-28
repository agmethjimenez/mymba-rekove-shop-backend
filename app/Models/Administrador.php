<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;
    protected $table = "administradores";
    protected $primaryKey = 'id';
    protected $fillable =[
        'id',
        'username',
        'email',
        'token',
        'clave',
        'activo'
    ];
    public $timestamps = false;

    public static function createAdmin($data){
        return self::create([
            "id"=> substr(uniqid(), 0, 10),
            "username"=> $data['username'],
            "email"=>$data['email'],
            "token" => bin2hex(random_bytes(32)),
            "clave" => bcrypt($data['password']),
            "activo" => true
        ]);

    }

    public static function updateAdmin($data)
    {
        $admin = self::find($data['id']);

        if (!$admin) {
            return [
                'status' => false,
                'message' => 'Administrador no encontrado'
            ];
        }

        $admin->username = $data['username'];
        $admin->email = $data['email'];
        $admin->save();

        return [
            'status' => true,
            'message' => 'Administrador actualizado correctamente',
            'admin' => $admin
        ];
    }

    public static function login($data)
    {
        $admin = self::where('email', $data['email'])->where('activo', true)->first();

        if ($admin && password_verify($data['password'], $admin->clave)) {
            return [
                'status' => true,
                'mensaje' => 'Verificado correctamente',
                'tipo'=> 'admin',
                'usuario' => [
                    'id_admin' => $admin->id,
                    'username' => $admin->username,
                    'token' => $admin->token,
                    'email' => $admin->email
                ]
            ];
        } else {
            return [
                'status' => false,
                'mensaje' => 'Usuario no encontrado o contraseña incorrecta'
            ];
        }
    }


    public static function changePassword($id, $currentPassword, $newPassword, $confirmPassword)
    {
        $admin = self::find($id);

        if (!$admin) {
            return [
                'status' => false,
                'message' => 'Administrador no encontrado'
            ];
        }

        if (!password_verify($currentPassword, $admin->clave)) {
            return [
                'status' => false,
                'message' => 'Contraseña actual incorrecta'
            ];
        }

        if ($newPassword !== $confirmPassword) {
            return [
                'status' => false,
                'message' => 'La nueva contraseña y la confirmación no coinciden'
            ];
        }

        $admin->clave = bcrypt($newPassword);
        $admin->save();

        return [
            'status' => true,
            'message' => 'Contraseña actualizada correctamente'
        ];
    }


}
