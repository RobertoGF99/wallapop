<?php

require_once CONTROLADOR_PATH."controladorBD.php";
require_once CLASES_PATH."producto.php";


class controladorProducto{
    private static $instancia=null;


    private function __construct(){

        
    }
    public static function getInstancia(){
        if (self::$instancia == null) {
            self::$instancia = new controladorProducto();
        }
        return self::$instancia;
    }

    public function almacenarProducto($nombre,$descripcion,$tipo,$precio,$stock,$id_usu){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="INSERT INTO `productos` (`tipo`, `nombre`,`descripcion`,`precio`,`stock`,`id_usuario`)
        VALUES (:tipo,:nombre,:descripcion,:precio,:stock,:id_usu)";
        $parametros=array(':tipo'=>$tipo,':nombre'=>$nombre,':descripcion'=>$descripcion,':precio'=>$precio,':stock'=>$stock,':id_usu'=>$id_usu);
   
        $estado=$conn->actualizarBDParm($consulta,$parametros);
        $conn->cerrarBD();
        return $estado;
    }


    public function listadoProductos(){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        
        $consulta="SELECT * from `productos`";
        $estado=$conn->consultarBDDir($consulta);
        $row=$estado->fetchAll(PDO::FETCH_ASSOC);
        return $row;

    }
    public function listadoProductosFiltro($tipo){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        
        $consulta="SELECT * from `productos` WHERE `tipo`=:tipo";
        $parametros=array(':tipo'=>$tipo);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $row=$estado->fetchAll(PDO::FETCH_ASSOC);
        return $row;

    }
    public function miListadoProductos($id_usu){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        
        $consulta="SELECT * from `productos` where `id_usuario`=:id_usu";
        $parametros=array(':id_usu'=>$id_usu);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $row=$estado->fetchAll(PDO::FETCH_OBJ);
        return $row;

    }

    public function productoDetalle($id_prod,$id_usu){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        $consulta="SELECT * from `productos` WHERE `id`=:id_prod AND `id_usuario`=:id_usu";
        $parametros=array(':id_prod'=>$id_prod,':id_usu'=>$id_usu);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $row=$estado->fetchAll(PDO::FETCH_OBJ);

        if(count($row)>0){
            $producto=new producto($row[0]->id,$row[0]->tipo,$row[0]->nombre,$row[0]->descripcion,
            $row[0]->precio,$row[0]->created,$row[0]->stock,$row[0]->id_usuario);
            return $producto;
        }else{
            return null;
        }
        
    }

    public function deleteProducto($id_prod){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        $consulta="DELETE from `productos` WHERE `id`=:id_prod";
        $parametros=array(':id_prod'=>$id_prod);
        $estado=$conn->actualizarBDParm($consulta,$parametros);
        return $estado;
    }

    public function buscarProducto($id_prod){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        $consulta="SELECT * from `productos` WHERE `id`=:id_prod";
        $parametros=array(':id_prod'=>$id_prod);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $row=$estado->fetchAll(PDO::FETCH_OBJ);

        if(count($row)>0){
            $producto=new producto($row[0]->id,$row[0]->tipo,$row[0]->nombre,$row[0]->descripcion,
            $row[0]->precio,$row[0]->created,$row[0]->stock,$row[0]->id_usuario);
            $conn->cerrarBD();
            return $producto;
        }else{
            return null;
        }
        
    } 

    public function productoId($id_usuario){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT `id` From `productos` WHERE `id_usuario`=:id_usuario ORDER BY `id`";
        $parametros=array(':id_usuario'=>$id_usuario);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $row=$estado->fetchAll(PDO::FETCH_ASSOC);
        $id_prod=$row[0]['id'];
        return $id_prod;

    }

    public function productoImages($id_producto){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT `name` From `images_producto` WHERE `id_producto`=:id_producto";
        $parametros=array(':id_producto'=>$id_producto);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $images=$estado->fetchAll(PDO::FETCH_ASSOC);
        return $images;
    }
    
    public function deleteProductoImages($id_producto){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="DELETE From `images_producto` WHERE `id_producto`=:id_producto";
        $parametros=array(':id_producto'=>$id_producto);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        return $estado;

    }

    public function actualizarProducto($producto){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        $consulta="UPDATE `productos` SET `tipo`=:tipo, `nombre`=:nombre, `descripcion`=:descripcion,`precio`=:precio,`stock`=:stock WHERE `id`=:id_prod";
        $parametros=array(':tipo'=>$producto->getTipo(),':nombre'=>$producto->getNombre(),':descripcion'=>$producto->getDescripcion(),':precio'=>$producto->getPrecio(),':stock'=>$producto->getStock(),':id_prod'=>$producto->getId_producto());
        $estado=$conn->actualizarBDParm($consulta,$parametros);
        $conn->cerrarBD();
        return $estado;
    }

    public function secciones(){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT `tipo` FROM `categoria`";
        $estado=$conn->consultarBDDir($consulta);
        $row=$estado->fetchAll(PDO::FETCH_OBJ);
        if(count($row)>0){
            $conn->cerrarBD();
            return $row;
            
        }else{
            return null;
        }
        
    }
    


}

?>