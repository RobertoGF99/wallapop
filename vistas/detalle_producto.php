<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorProducto.php";
require_once CONTROLADOR_PATH."controladorUsuario.php";
require_once CONTROLADOR_PATH."controladorImagen.php";
require_once VISTAS_PATH."header.php";


if(isset($_GET['id_prod'])){
    $contr=controladorProducto::getInstancia();
	$producto=$contr->buscarProducto($_GET['id_prod']);
	$images=$contr->productoImages($_GET['id_prod']);

	//email del usuario propietario del producto
	$email=$contruser=controladorUsuario::getInstancia()->buscarUsuarioIdassoc($producto->getId_usuario());
	//var_dump($email);
	//var_dump($images);
}
if(empty($producto)){
	echo "producto no encontrado.";
}
?>
    <!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="owl-carousel owl-theme s_Product_carousel">
						<div class="single-prd-item">
                         <img src="/shop/images/" class="img-fluid">
						</div>
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
							<?php echo "<li><span><a href='/shop/vistas/perfil.php?id_perfil=".$producto->getId_usuario()."'>Subido por: ".$email."</a></span></li> ";?>
						</ul>
						<p>Descripcion: <?php echo $producto->getDescripcion();?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
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

<?php require_once VISTAS_PATH."footer.php"; ?>