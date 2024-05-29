<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'identificacion',
        'tipoId',
        'primerNombre',
        'segundoNombre',
        'primerApellido',
        'segundoApellido',
        'email',
        'telefono',
        'activo'
    ];
    public $timestamps = false;

    public function credencial()
    {
        return $this->hasOne(Credencial::class, 'id', 'id');
    }
    public function tipoid()
    {
        return $this->belongsTo(Tipoid::class, 'tipoId', 'codId');
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'usuario', 'id');
    }

    public static function getUsuarios()
    {
        return self::where('activo',true)->with('tipoid')->get();
    }
    public static function searchUsuariosByName($query = null, $tipoid = null)
    {
        $queryBuilder = self::where('activo',true);
    
        if ($query !== null) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->whereRaw("CONCAT(primerNombre, ' ', segundoNombre, ' ', primerApellido, ' ', segundoApellido) LIKE ?", ["%$query%"])
                  ->orWhere('primerNombre', 'LIKE', "%$query%")
                  ->orWhere('segundoNombre', 'LIKE', "%$query%")
                  ->orWhere('primerApellido', 'LIKE', "%$query%")
                  ->orWhere('segundoApellido', 'LIKE', "%$query%")
                  ->where('activo',true);
            });
        }
    
        if ($tipoid !== null && $tipoid != 0) {
            $queryBuilder->where('tipoId', $tipoid);
        }
    
        return $queryBuilder->with('tipoid')->get();
    }
    



    public static function getUsuariosporid($id)
    {
        return self::with('tipoid')->find($id);
    }

    public static function InsertUser($data)
    {
        try {
            $usuario = self::create([
                'identificacion' => $data['identificacion'],
                'tipoId' => $data['tipoId'],
                'primerNombre' => $data['primerNombre'],
                'segundoNombre' => $data['segundoNombre'] ?? null,
                'primerApellido' => $data['primerApellido'],
                'segundoApellido' => $data['segundoApellido'] ?? null,
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'activo' => true
            ]);

            if (!$usuario) {
                throw new \Exception('Error al crear el usuario');
            }
            $idUsuario = $usuario->id;
            Credencial::create([
                'id' => $idUsuario,
                'email' => $data['email'],
                'token' => bin2hex(random_bytes(32)),
                'codigo' => rand(1000, 9999),
                'fecha_cambio' => null,
                'password' => bcrypt($data['password']),
                'activo' => true
            ]);

            return $usuario;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public static function Login($data)
    {
        $usuario = self::where('email', $data['email'])->first();

        if (!$usuario) {
            return [
                'status' => false,
                'message' => 'Usuario no encontrado'
            ];
        }
        $credencial = Credencial::where('email', $data['email'])->first();
        if (!$credencial) {
            return [
                'status' => false,
                'message' => 'Credenciales no encontradas'
            ];
        }
        if (!$usuario->activo) {
            return [
                'status' => false,
                'message' => 'Usuario inactivo'
            ];
        }
        if (!password_verify($data['password'], $credencial->password)) {
            return [
                'status' => false,
                'message' => 'Contraseña incorrecta'
            ];
        }
        $credencial->token = bin2hex(random_bytes(32));
        $credencial->save();
        return [
            'status' => true,
            'tipo'=>'user',
            'id' => $usuario->id,
            'token'=> $credencial->token
        ];
    }

    static public function UpdateDatos($data){
        $usuario = self::find($data['id']);

        if (!$usuario) {
            return[
                "status"=>false,
                "mensaje"=>"Usuario no encontrado"
            ];
        }
        if (!$usuario->activo) {
            return[
                "status"=>false,
                "mensaje"=>"Usuario desactivado"
            ];
        }

        $usuario->primerNombre = $data['nombre1'];
        $usuario->segundoNombre = $data['nombre2'];
        $usuario->primerApellido = $data['apellido1'];
        $usuario->segundoApellido = $data['apellido2'];
        $usuario->telefono = $data['telefono'];
        $usuario->email = $data['email'];
        $usuario->save(); 

        $credencial = Credencial::find($usuario->id);
            if ($credencial) {
                $credencial->email = $data['email'];
                $credencial->save();
            }
        return[
            "status"=>true,
            "mensaje"=>"Datos actualizados correctamente"
        ];

    }

    static public function desactivarUsuario($id){
        $usuario = self::find($id);

        if(!$usuario){
            return[
                "status"=>false,
                "mensaje"=>"usuario no existente"
            ];
        }

        if (!$usuario->activo) {
            return[
                "status"=>false,
                "mensaje"=>"Usuario ya desactivado"
            ];
        }

        $usuario->activo = false;
        $usuario->save();

        $credencial = Credencial::find($usuario->id);
            if ($credencial) {
                $credencial->activo = false;
                $credencial->save();
            }
        return[
            "status"=>true,
            "mensaje"=>"Desactivado correctamente"
        ];


    }
}
