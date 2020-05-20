<?php


require_once CONTROLADOR_PATH."controladorBD.php";
require_once CLASES_PATH."producto.php";
require_once CLASES_PATH."user.php";
require_once CONTROLADOR_PATH."controladorProducto.php";

class controladorCarrito{
    private static $instancia=null;


    private function __construct(){

    }

    public static function getInstancia(){
        if (self::$instancia == null) {
            self::$instancia = new controladorCarrito();
        }
        return self::$instancia;
    }

    public function añadirCarrito($producto){
        $stock=$producto->getStock();

        
        if($stock==1){
            $_SESSION['carrito'][$producto->getId_producto()]=[$producto];
            return true;

        }else{
            return false;
        }



    }


}
