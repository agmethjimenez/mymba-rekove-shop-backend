<?php
namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Credencial;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioTest extends TestCase{
   //use RefreshDatabase;
    public function testLogin(){
        $login = Usuario::login([
            'email'=>'agmeth.jimenez2005@gmail.com',
            'password'=>'agmeth123'
        ]);
        $this->assertEquals(true,$login['status'],"Logueado incorrectamente");
    }
    public function testUpdateData(){
        $update = Usuario::UpdateDatos([
            'id'=>4,
            'nombre1'=>'Agmeth',
            'nombre2'=>'Emilio',
            'apellido1'=>'Jimenez',
            'apellido2'=>'Castro',
            'telefono'=>'3012345678',
            'email'=>'agmeth.jimenez2005@gmail.com'
        ]);
        $this->assertEquals(true,$update['status'],"Error al actualizar datos");
    }

    public function testDeleteUser(){
        $delete = Usuario::desactivarUsuario(3);
        $this->assertEquals(false,$delete['status'],"Error al eliminar usuario");
    }

    public function testValdiarCredenciales(){
        $result = Credencial::verificarExistenciayCaducidad("franco@gmail.com","fa542f3bd0a5b221825319b010c54fb9",1953);
        $this->assertEquals(false,$result['status'],$result['mensaje']);
    }

    public function testCambioPassword(){
        $result = Credencial::ActualizarCredenciales("luracape@gmail.com","e05a4aca622be7182856e5ea1bb3fa3235bae620d08b36e7662374a1140e1e8c","lura123");
        $this->assertEquals(true,$result['status'],$result['mensaje']);
    }


}
