<?php


require_once CONTROLADOR_PATH."controladorBD.php";
require_once CLASES_PATH."user.php";

class controladorUsuario{
    private static $instancia=null;


    private function __construct(){

    }

    public static function getInstancia(){
        if (self::$instancia == null) {
            self::$instancia = new controladorUsuario();
        }
        return self::$instancia;
    }



    public function almacenarUsuario($nombre, $apellidos, $email, $localizacion, $password){
        $conn=ControladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="INSERT INTO `users` (`nombre`,`apellidos`,`email`,`localizacion`,`password`)
        VALUES (:nombre,:apellidos,:email, :localizacion, :password )";
        $parametros=array(':nombre'=>$nombre,':apellidos'=>$apellidos,':email'=>$email,
        ':localizacion'=>$localizacion,':password'=>$password);


        $estado=$conn->actualizarBDParm($consulta,$parametros);
        $conn->cerrarBD();
        return $estado;
        
    }


    public function buscarUsuarioId($id){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="Select * from `users` WHERE id= :id";
        $parametros= array(':id'=>$id);

        $estado=$conn->consultarBDParm($consulta, $parametros);
        $row=$estado->fetchAll(PDO::FETCH_OBJ);

        //comprobamos que hemos obtenido algun resultado de la consulta
        if(count($row)>0){
            //extraemos el id de la consulta realizada
            $user= new user($row[0]->id,$row[0]->nombre,$row[0]->apellidos,$row[0]->email,$row[0]->password,$row[0]->localizacion,$row[0]->created);
            return $user;
        }else{
            return null;
        }

    }
    public function buscarUsuarioIdassoc($id){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="Select * from `users` WHERE id= :id";
        $parametros= array(':id'=>$id);

        $estado=$conn->consultarBDParm($consulta, $parametros);
        $row=$estado->fetchAll(PDO::FETCH_ASSOC);

        //comprobamos que hemos obtenido algun resultado de la consulta
        if(count($row)>0){
            //extraemos el id de la consulta realizada
            $email=$row[0]['email'];
            return $email;
        }else{
            return null;
        }

    }

    public function iniciarSesion($email,$password){
        $email;
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT * from `users` where `email`=:email and `password`=:password";
        $parametros=array(':email'=>$email,':password'=>$password);

        $estado=$conn->consultarBDParm($consulta,$parametros);

        $row=$estado->fetchAll(PDO::FETCH_ASSOC);
        //$email=$row[0]["email"];
        //var_dump($email);
        //$this->email=$row['email'];
        //var_dump($row[0]['email']);


        if(count($row)>0){
            $_SESSION['email']=$row[0]['email'];
            #var_dump($_SESSION['email']);


            header("location: /shop/index.php");
            exit();
        }else{
            echo "error";
        }


    }
    public function startSesion(user $userlog){
        session_start();
        $_SESSION["id_usu"]=$userlog->getId_usu();
        $_SESSION["nombre_usu"]=$userlog->getNombre();
        $_SESSION["apellido_usu"]=$userlog->getApellido();
        $_SESSION["email"]=$userlog->getEmail();
        $_SESSION["localizacion"]=$userlog->getLocalizacion();
        $_SESSION["fecha_creacion"]=$userlog->getFecha_creacion();

        $_SESSION["carrito"]=array();



        


    }

    public function iniciarSesionn($email,$password){
        $email;
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT * from `users` where `email`=:email and `password`=:password";
        $parametros=array(':email'=>$email,':password'=>$password);

        $estado=$conn->consultarBDParm($consulta,$parametros);

        $row=$estado->fetchAll(PDO::FETCH_OBJ);
        
        //var_dump($row[0]->id);

        //guardamos el usuario en una variable como un objeto
        
        //$conn->cerrarBD();
        //return $user;

        //$email=$row[0]["email"];
        //var_dump($email);
        //$this->email=$row['email'];
        //var_dump($row[0]['email']);


        if(count($row)>0){
            //guardamos el usuario en una variable como un objeto
            $userlog= new user($row[0]->id,$row[0]->nombre,$row[0]->apellidos,$row[0]->email,$row[0]->password,$row[0]->localizacion,$row[0]->fecha_creacion,$row[0]->foto_personal);
            //var_dump($userlog);

            //devolvemos el objeto
            return $userlog;
        }else{
            return null;
        }


    }

    public function closeSesion(){
        session_start();
        session_destroy();
        header("location: /shop/index.php");

    }

    public function actualizarUsuario($usuario){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();
        $consulta="UPDATE `users` SET `nombre`=:nombre, `apellidos`=:apellidos,`email`=:email,`password`=:password,`localizacion`=:localizacion
        WHERE `id`=:id_usu";
        $parametros=array(':id_usu'=>$usuario->getId_usu(),':nombre'=>$usuario->getNombre(),':apellidos'=>$usuario->getApellido(),':email'=>$usuario->getEmail(),':password'=>$usuario->getPassword(),':localizacion'=>$usuario->getLocalizacion());
        $estado=$conn->actualizarBDParm($consulta,$parametros);
        $conn->cerrarBD();
        return $estado;
    }

    public function usuarioId($email){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT `id` From `users` WHERE `email`=:email";
        $parametros=array(':email'=>$email);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $row=$estado->fetchAll(PDO::FETCH_ASSOC);
        $id_usu=$row[0]['id'];
        return $id_usu;

    }
    public function userImages($id_usuario){
        $conn=controladorBD::getInstancia();
        $conn->abrirBD();

        $consulta="SELECT `name` From `images_user` WHERE `id_usuario`=:id_usuario";
        $parametros=array(':id_usuario'=>$id_usuario);
        $estado=$conn->consultarBDParm($consulta,$parametros);
        $images=$estado->fetchAll(PDO::FETCH_ASSOC);
        return $images;
    }


    //cookies functions
    public function crearCookie(){
        
        $expiracion=time() + 24*60*60; //1 dia

        //clave o nombre
        $clave= $_SESSION['email'];

        //valor
        $valor=serialize($_SESSION['carrito']);

        setcookie($clave,$valor,$expiracion);
    }
}

?>