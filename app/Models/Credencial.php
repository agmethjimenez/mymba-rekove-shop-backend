<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Credencial extends Model
{
    use HasFactory;

    protected $table = 'credenciales';
    protected $fillable = [
        'id',
        'email',
        'token',
        'codigo',
        'fecha_cambio',
        'password',
        'activo'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(Usuario::class,'id','id');
    }

    public static function actualizarTokenyCodigo($email){
        $user = self::where('email',$email)->where('activo',true)->first();

        if(!$user){
            return[
                "status"=>false,
                "mensaje"=>"No encontrado"
            ];
        }
        $user->token = bin2hex(random_bytes(16));
        $user->fecha_cambio = now() ;
        $user->codigo = rand(1000,9999);
        $user->save();

        return[
            "status"=>true,
            "token"=>$user->token,
            "codigo"=>$user->codigo,
            "email"=>$email
        ];
    }


    public static function verificarExistenciayCaducidad($email, $token, $codigo)
    {
        $credencial = self::where('email', $email)
            ->where('token', $token)
            ->where('codigo', $codigo)
            ->first();

        if (!$credencial) {
            return [
                "status" => false,
                "mensaje" => "Usuario no encontrado."
            ];
        }

        $fechaCambio = Carbon::parse($credencial->fecha_cambio);
        $ahora = Carbon::now();

        if ($fechaCambio->diffInMinutes($ahora) < 30) {
            return [
                "status" => true
            ];
        } else {
            return [
                "status" => false,
                "mensaje" => "Código caducado."
            ];
        }
    }

    static public function ActualizarCredenciales($email,$tokenK,$password){
        $passwordEncriptada = bcrypt($password);
        $token = bin2hex(random_bytes(16));

        $usuario = self::where('email',$email)->where('token',$tokenK)->first();

        if(!$usuario){
            return[
                "status"=>false,
                "mensaje"=>"Usuario no existente"
            ];
        }

        if(!$usuario->activo){
            return[
                "status"=>false,
                "mensaje"=>"Usuario desactivado"
            ];
        }

        $usuario->password = $passwordEncriptada;
        $usuario->token = $token;
        $usuario->save();

        return[
            "status"=>true,
            "mensaje"=>"Clave remplazada correctamente"
        ];
    }


    static public function CambioClave($id,$passwordvieja,$password, $passwordConfiramar){
        $credencial = self::find($id);
        if($password !== $passwordConfiramar){
            return[
                "status"=>false,
                "mensaje"=>"Las claves nuevas no coinciden"
            ];
        }
        $verificarpasswordvieja = password_verify($passwordvieja,$credencial->password);

        if (!$verificarpasswordvieja) {
            return[
                "status"=>false,
                "mensaje"=>"Contraseña actual no coinciden"
            ];
        }

        $credencial->password = bcrypt($password);
        $credencial->save();

        return[
            "status"=>true,
            "mensaje"=>"Clave actualizada correctamente"
        ];
    }
}
