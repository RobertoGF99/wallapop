<?php 
error_reporting(E_ALL & ~E_NOTICE);

header("Content-Type: text/html; charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorProducto.php";
require_once ROOT_PATH."rutas.php"; 
//existen funciones como header() o setcookie() que deben ejecutarse antes de haber enviado ningún texto de la página al cliente. En caso contrario se producirá un error "Cannot modify header information - headers already sent by
ob_start();
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Home</title>
	<link rel="icon" href="img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
//barra de navegacion
require_once VISTAS_PATH."bar.php" 
?>