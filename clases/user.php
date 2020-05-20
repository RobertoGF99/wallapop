<?php

class user{

    private $id_usu;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $localizacion;
    private $fecha_creacion;
    private $foto_personal;


    public function __construct($id_usu, $nombre, $apellido, $email, $password, $localizacion,  $fecha_creacion){
        $this->id_usu=$id_usu;
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->email=$email;
        $this->password=$password;
        $this->localizacion=$localizacion;
        $this->fecha_creacion=$fecha_creacion;
    }
    



    /**
     * Get the value of id_usu
     */ 
    public function getId_usu()
    {
        return $this->id_usu;
    }

    /**
     * Set the value of id_usu
     *
     * @return  self
     */ 
    public function setId_usu($id_usu)
    {
        $this->id_usu = $id_usu;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellido
     */ 
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     *
     * @return  self
     */ 
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of contraseña
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of contraseña
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of localizacion
     */ 
    public function getLocalizacion()
    {
        return $this->localizacion;
    }

    /**
     * Set the value of localizacion
     *
     * @return  self
     */ 
    public function setLocalizacion($localizacion)
    {
        $this->localizacion = $localizacion;

        return $this;
    }


    /**
     * Get the value of fecha_creacion
     */ 
    public function getFecha_creacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set the value of fecha_creacion
     *
     * @return  self
     */ 
    public function setFecha_creacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }
}

?>