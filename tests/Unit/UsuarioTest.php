<?php
namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Usuario;
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
}
