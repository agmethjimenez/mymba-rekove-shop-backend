<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'idProducto';
    protected $fillable = [
        'idProducto',
        'proveedor',
        'nombre',
        'descripcionP',
        'contenido',
        'precio',
        'marca',
        'categoria',
        'cantidadDisponible',
        'imagen',
        'activo'
    ];
    public $timestamps = false;
    public $incrementing = false; 

    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor','idProveedor');

    }
    public function marca(){
        return $this->belongsTo(Marca::class,'marca','idMarca');
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class,'categoria','categoria');
    }
    public function detallespedido(){
        return $this->hasMany(DetallePedido::class,'idProducto','idProducto');
    }

    public static function getProductos($id = null,$name = null, $category = null){
        $productos = self::with(['proveedor','marca','categoria'])->where('activo',true);

        if($id !== null){
            $productos->where('idProducto',$id);
        }

        if($name !== null){
            $productos->where('nombre', 'like', '%'.$name.'%');
        }

        if($category !== null && $category !== 0){
            $productos->where('categoria',$category);
        }

        return $productos->get();
    }

    public static function getOneProducto($id){
        return self::where('idProducto',$id)->where('activo',true)->with(['proveedor','marca','categoria'])->first();
    }

    public static function createProducto($data){
        $producto = self::create([
            'idProducto'=>rand(10000,99999),
            'proveedor' => $data['proveedor'],
            'nombre'=>$data['nombre'],
            'descripcionP'=>$data['descripcion'],
            'contenido' => $data['contenido'],
            'precio' => $data['precio'],
            'marca' => $data['marca'],
            'categoria' => $data['categoria'],
            'cantidadDisponible'=> $data['stock'],
            'imagen' => $data['imagen'],
            'activo' => true
        ]);

        if(!$producto){
            return[
                'status'=>false,
                'mensaje'=>"Error al crear producto"
            ];
        }
        $admin = Administrador::where('token',$data['admin'])->first();

        ProductoAgregado::create([
            "administrador"=>$admin->id,
            "producto" => $producto->idProducto,
            'agregado_el'=> now()
        ]);
        return[
            'status'=>true,
            'mensaje'=>"Producto creado exitosamente",
            'producto'=>$producto
        ];

    }

    public static function updateProducto($id, $data){
        $producto = self::find($id);

        if(!$producto){
            return [
                'status'=>false,
                'mensaje'=>"Producto no encontrado"
            ];
        }

        $producto->proveedor = $data['proveedor'];
        $producto->nombre = $data['nombre'];
        $producto->descripcionP = $data['descripcion'];
        $producto->contenido = $data['contenido'];
        $producto->precio = $data['precio'];
        $producto->marca = $data['marca'];
        $producto->categoria = $data['categoria'];
        $producto->cantidadDisponible = $data['stock'];
        $producto->imagen = $data['imagen'];

        if(!$producto->save()){
            return [
                'status'=>false,
                'mensaje'=>"Error al actualizar producto"
            ];
        }

        return [
            'status'=>true,
            'mensaje'=>"Producto actualizado exitosamente",
            'producto'=>$producto
        ];
    }

    static public function desactivarProducto($id){
        $producto = self::find($id);

        if(!$producto){
            return [
                'status'=>false,
               'mensaje'=>"Producto no encontrado"
            ];
        }

        $producto->activo = false;

        if(!$producto->save()){
            return [
                'status'=>false,
               'mensaje'=>"Error al desactivar producto"
            ];
        }

        return [
            'status'=>true,
           'mensaje'=>"Producto desactivado exitosamente"
        ];
    }
}
