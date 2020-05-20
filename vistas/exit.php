<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";

require_once CONTROLADOR_PATH."controladorUsuario.php";
require_once VISTAS_PATH."header.php";

//cerramos la sesion
$conn=controladorUsuario::getInstancia();
$conn->closeSesion();
?>