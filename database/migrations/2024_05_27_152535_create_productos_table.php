<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('idProducto')->primary();
            $table->string('proveedor');
            $table->string('nombre');
            $table->text('descripcionP');
            $table->string('contenido');
            $table->decimal('precio',10,0);
            $table->unsignedBigInteger('marca');
            $table->unsignedBigInteger('categoria');
            $table->integer('cantidadDisponible');
            $table->string('imagen');
            $table->boolean('activo')->default(true);

            $table->foreign('proveedor')->references('idProveedor')->on('proveedores');
            $table->foreign('marca')->references('idMarca')->on('marcas');
            $table->foreign('categoria')->references('categoria')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
