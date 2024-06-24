<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Administrador;

class AdministradorTest extends TestCase{
    public function testLogin(){
        $login = Administrador::login([
            'email'=>'reddestroe345@mymba.com',
            'password'=>'reddestrow'
        ]);
        $this->assertEquals(true,$login['status'],$login['mensaje']);
    }
    public function testUpdateData(){
        $admin = Administrador::updateAdmin([
            "token"=>"985f9a8e423fbd8711072d40f99f28874debe534eac7227f0fb70cdc5625c1b5",
            "username"=>"tester1",
            "email"=>"tester1@mymba.com",
        ]);
        $this->assertEquals(true,$admin['status'],$admin['message']);
    }
}