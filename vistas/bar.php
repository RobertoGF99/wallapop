
<!--================ Start Header Menu Area =================-->
<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="/shop/index.php">Home</a></li>
              <li class="nav-item submenu dropdown">

              
              <?php //comprobamos si existe alguna sesion abierta y mostramos opciones segun si hay alguien logueado o no
              if(!isset($_SESSION['email']) && !isset($_SESSION['id_usu'])){
							 //si no hay nadie logueado, podremos registrarnos como nuevo usuario o iniciar sesion
                echo '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="/shop/vistas/login.php">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="/shop/vistas/registro.php">Register</a></li>
                </ul>';
              }else{
                //si esta registrado, mostramos la opcion de ver nuestro perfil o cerrar la sesion
                echo '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Mi Zona</a>
                <ul class="dropdown-menu">';
                  echo "<li class='nav-item'><a class='nav-link' href='/shop/vistas/mi_perfil.php?email=".$_SESSION['email']. "'>Perfil</a></li>";
                  echo '<li class="nav-item"><a class="nav-link" href="/shop/vistas/exit.php">Cerrar sesion</a></li>';
                echo"</ul>";
              }?>

              </li>
              <li class="nav-item submenu dropdown">
              <?php //mostramos secciones
              $contr=ControladorProducto::getInstancia();
              $secciones=$contr->secciones();
							 
                echo '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Categoria</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="/shop/index.php?tipo=vehiculo">Vehiculos</a></li>
                  <li class="nav-item"><a class="nav-link" href="/shop/index.php?tipo=propiedad">Propiedades</a></li>
                  <li class="nav-item"><a class="nav-link" href="/shop/index.php?tipo=otros">Otros</a></li>
                </ul>';
              ?>

              </li>
            </ul>
            <ul class="nav-shop">
              
              <?php
              echo "<li class='nav-item'><a class='button button-header' href='/shop/vistas/carrito.php?id_usu= ".$_SESSION['id_usu']. "'>Carrito</a></li>";
              ?>
              <?php
              if(!isset($_SESSION['email']) && !isset($_SESSION['id_usu'])){
                echo '<li class="nav-item"><a class="button button-header" href="/shop/vistas/login.php">Subir Producto</a></li>';
              }else{
                echo "<li class='nav-item'><a class='button button-header' href='/shop/vistas/crear_producto.php?id_usu= ".$_SESSION['id_usu']. "'>Subir Producto</a></li>";
                echo "<li class='nav-item'><a class='button button-header' href='/shop/vistas/mis_productos.php?id_usu= ".$_SESSION['id_usu']. "'>Mis Productos</a></li>";
              }?>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!--================ End Header Menu Area =================-->
  <?php
  /*if(isset($_SESSION['email'])){
  $email=$_SESSION['email'];
  echo "logeado como: " .$email;
  
}else{
  echo "no logueado";
}
*/

?>