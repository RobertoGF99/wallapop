<?php


require_once CONTROLADOR_PATH."controladorBD.php";
require_once CLASES_PATH."user.php";

class controladorImagen{
    private static $instancia=null;


    private function __construct(){

    }

    public static function getInstancia(){
        if (self::$instancia == null) {
            self::$instancia = new controladorImagen();
        }
        return self::$instancia;
    }


    public function saveImage($file_tmp,$file_destino){
        if(move_uploaded_file($file_tmp, $file_destino)){
            return true;
        }else{
            return false;
        }

    }
    function saveImages($count_file, $imagenes){

        $contador=0;
        for($i=0;$i<$count_file;$i++){
            $file_name=$imagenes['name'][$i];
            $file_destino=IMAGES_PATH.$file_name;
            $file_origen=$imagenes['tmp_name'][$i];

            move_uploaded_file($file_origen,$file_destino);

            $contador++;
        }
        return $contador;


    }

    public function deleteImage($file){
        if(file_exists($file)){
            unlink($file);
            return true;
        }else{
            return false;
        }
    }

}