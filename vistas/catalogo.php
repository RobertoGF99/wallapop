<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/shop/rutas.php";

require_once CONTROLADOR_PATH."controladorProducto.php";
require_once CONTROLADOR_PATH."controladorCarrito.php";
require_once CONTROLADOR_PATH."controladorUsuario.php";
require_once CONTROLADOR_PATH."controladorImagen.php";


$contr=controladorProducto::getInstancia();
//comprobamos si hemos recibido algun parametro de filtro
if($_GET['tipo']){
  $productos=$contr->listadoProductosFiltro($_GET['tipo']);
  if(empty($productos)){
    echo "no hay productos en esta categoria";
  }

}else{
  $productos=$contr->listadoProductos();

}


if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["añadir_carrito"]){

  if(!isset($_SESSION['email'])){
    header("location: /shop/vistas/login.php");
  }else{
    $id_prod=$_POST['añadir_carrito'];
  //var_dump($id);
  $contr=controladorProducto::getInstancia();
  $producto=$contr->buscarProducto($id_prod);

  $contr_carrito=controladorCarrito::getInstancia();
  if($contr_carrito->añadirCarrito($producto)){
    $cookie=controladorUsuario::getInstancia();
    //$cookie->crearCookie();
    header("location: /shop/index.php");
  }else{
    echo "ya ha sido vendido";
  }

  }
  //comprobamos que esta en stock


}


?>


<section class="lattest-product-area pb-40 category-list">
            <div class="row">
            <?php foreach($productos as $p){ ?>
              <div class="col-md-6 col-lg-4">
                <div class="card text-center card-product">
                  <div class="card-product__img">
                    <img class="card-img" src="img/product/product1.png" alt="">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <ul class="card-product__imgOverlay">
                      <?php echo "<li><button type='submit' name='añadir_carrito' value='".$p['id']."'><i class='ti-shopping-cart'></i></button></li>";?>
                    </ul>
                    </form>
                  </div>
                  <div class="card-body">
                    <p><?php echo $p['tipo']; ?></p>
                    <p><?php if($p['stock']==1){
                        echo "En venta";
                    }else{
                        echo "Vendido";
                    } ?></p>
                    <?php echo "<h4 class='card_product__title'><a href='/shop/vistas/detalle_producto.php?id_prod=".$p["id"]."'>".$p["nombre"]."</a></h4> ";?>
                    <p class="card-product__price"><?php echo $p['precio']; ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
            </div>
</section>