<?php

class controladorBD{
    public $servername="localhost";
    public $username="root";
    public $password="";
    public $dbname="wallapop";
    public $server="mysql";


    private static $instancia=null;


    private function __construct(){

    }

    public static function getInstancia(){
        if (self::$instancia == null) {
            self::$instancia = new ControladorBD();
        }
        return self::$instancia;
    }

    public $conn;
    private $res;

    public function abrirBD(){
        try{
            $this->conn=new PDO($this->server.":host=$this->servername;
            dbname=$this->dbname", $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }


    }
    public function cerrarBD(){
        $this->conn=null;
        $this->res=null;

    }




    public function actualizarBDParm($consulta,$parametros){
        $this->res=$this->conn->prepare($consulta);
        $this->res->execute($parametros);
        return $this->res;
    }

    public function actualizarBDDir($consulta){
        if($this->conn->exec($consulta)!=0){
            return true;
        }else{
            return false;
        }
    }

    public function consultarBDParm($consulta,$parametros){
        $this->res=$this->conn->prepare($consulta);
        $this->res->execute($parametros);
        return $this->res;


    }

    public function consultarBDDir($consulta){
        $this->res=$this->conn->query($consulta);
        return $this->res;
    }


    




}

?>