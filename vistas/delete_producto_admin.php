<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorProducto.php";
require_once CONTROLADOR_PATH."controladorImagen.php";
require_once VISTAS_PATH."header.php";


if(isset($_SESSION['id_usu']) && $_GET['id_prod']){

	//comprobamos que hay una sesion iniciada
    $contr=controladorProducto::getInstancia();
	$producto=$contr->productoDetalle($_GET['id_prod'],$_SESSION['id_usu']);
	$images=$contr->productoImages($_GET['id_prod']);
	//var_dump($images);
}
if(empty($producto)){
	echo "producto no encontrado.";
}
//si pulsamos el boton eliminar, eliminamos el producto y las imagenes correspondientes
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $contr=controladorProducto::getInstancia();
    $estado=$contr->deleteProducto($_POST['id_prod']);
    if($estado==1){

		$images=$contr->productoImages($_POST['id_prod']);
		$contri=controladorImagen::getInstancia();
		foreach($images as $i){
			$contri->deleteImage(IMAGES_PATH.$i['name']);
		}
		//eliminamos las imagenes de la base de datos
		$estadoi=$contr->deleteProductoImages($_POST['id_prod']);
        if($estadoi==1){
            header("location: /shop/vistas/mis_productos.php");
            
        }else{
            echo "ha habido algun error al eliminar el producto (parte de la imagen)";
        }
    }else{
        echo "ha habido algun error al eliminar el producto (parte prod)";
    }
}
?>
    <!--================Single Product Area =================-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="owl-carousel owl-theme s_Product_carousel">
						
						<!-- <div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div> -->
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo $producto->getNombre();?></h3>
						<h2><?php echo $producto->getPrecio();?></h2>
						<ul class="list">
							<li><span>Categoria: </span><?php echo $producto->getTipo();?></li>

							<li><span>Disponibilidad: </span><?php $stock=$producto->getStock();
							if($stock==1){
								echo "En venta";
							}else{
								echo "vendido";
							}?></li>
							<li><span>Fecha publicacion: </span><?php echo $producto->getCreated();?></li>
						</ul>
						<p>Descripcion: <?php echo $producto->getDescripcion();?></p>
                        <input type="hidden" name="id_prod" value="<?php echo $producto->getId_producto(); ?>"/>
                        <div class="col-md-12 form-group">
							<button type="submit" value="eliminar" name="eliminar" class="button button-register w-100">Eliminar</button>
						</div>
                    </div>
                    
                </div>
                
			</div>
		</div>
    </div>
	</form>
	<section>
		<table border="solid" width=100%>
			<tbody>
			<?php foreach($images as $i){ ?>
			<td><img src='/shop/images/<?php echo $i['name']  ?>' width="200" height="100"></img></td>
			<?php } ?>
			</tbody>
		</table>
	</section>
	<!--================End Single Product Area =================-->

?>
<?php require_once VISTAS_PATH."footer.php"; ?>