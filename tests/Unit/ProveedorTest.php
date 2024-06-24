<?php
namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Proveedor;

class ProveedorTest extends TestCase{

    public function testCreate(){
        $result = Proveedor::createProveedor([
            "nombre"=>"Occident45q Solituon",
            "ciudad"=>"Bogoat",
            "correo"=>"occi45@mail.com",
            "telefono"=>"54723245",
        ]);
        $this->assertEquals(true,$result['status'],"Error al crear proveedor");
    }
    public function testUpdate(){
        $result = Proveedor::updateProveedor(102,[
            "nombre"=>"Animalia Pet Shop",
            "ciudad"=>"Medellin",
            "correo"=>"animalia@emailmascotas.net",
            "telefono"=>"987-6543",
            "estado"=>1
        ]);
        $this->assertEquals(true,$result['status'],$result['mensaje']);

    }

}