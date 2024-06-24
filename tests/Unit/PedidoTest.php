<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pedido;

class PedidoTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testUpdateEstado(){
        $result = Pedido::updatePedido("65ee45a6a6",3);
        $this->assertEquals(true,$result['status']);
    }

}
