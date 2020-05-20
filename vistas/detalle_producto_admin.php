<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/shop/rutas.php";
require_once CONTROLADOR_PATH . "controladorProducto.php";
require_once CONTROLADOR_PATH."funciones.php";
require_once VISTAS_PATH . "header.php";
require_once CLASES_PATH . "producto.php";

if (isset($_SESSION['id_usu']) && isset($_SESSION['email']) && isset($_GET['id_prod'])) {
	$conn = controladorProducto::getInstancia();
	$producto = $conn->productoDetalle($_GET['id_prod'], $_SESSION['id_usu']);
	//print_r($producto);
	if (!empty($producto)) {
		var_dump($producto);
		$id_prod = $producto->getId_producto();
		$tipo = $producto->getTipo();
		$nombre = $producto->getNombre();
		$descripcion = $producto->getDescripcion();
		$precio = $producto->getPrecio();
		$created = $producto->getCreated();
		$stock = $producto->getStock();
		$id_usu = $producto->getId_usuario();


		//cogemos las imagenes
		$images = $conn->productoImages($id_prod);
		//var_dump($images);
		/*foreach ($images as $i) {
			var_dump(IMAGES_PATH . $i['name']);
		}*/
	} else {
		echo "error al encontrar el producto";
	}
}else{
	echo "error. debes estar registrado para ver tus productos";
}
	

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["actualizar"]){
	$nombreVal=filtrado($_POST["nombre"]);
	if(empty($nombreVal)){
		$errores[]='Introduzca un nombre, por favor';
	}
	else{
		$nombre=$nombreVal;
	}
	$descripcionVal=filtrado($_POST["descripcion"]);
	if(empty($descripcionVal)){
		$errores[]='Introduzca una descripcion del producto, por favor';
	}
	else{
		$descripcion=$descripcionVal;
	}
	$tipoVal=filtrado($_POST["tipo"]);
	if(empty($tipoVal)){
		$errores[]='elija una categoria, por favor';
	}
	else{
		$tipo=$tipoVal;
	}
	$precioVal=$_POST["precio"];
	if(empty($precioVal)){
		$errores[]='Introduzca un precio, por favor';
	}
	else{
		$precio=$precioVal;
	}

	$stockVal=filtrado($_POST["stock"]);
	if(empty($stockVal)){
		$errores[]='indica si hay stock o no.';
	}else{
		$stock=$stockVal;
	}
	$id_prodVal=$_POST["id_prod"];
	if(empty($id_prodVal)){
		$errores[]='error con el producto';
	}else{
		$id_prod=$id_prodVal;
	}

	if(empty($errores)){
		$producto=new producto($id_prod,$tipo,$nombre,$descripcion,$precio,$created,$stock,$id_usu);
		$contr=controladorProducto::getInstancia();
		$estado=$contr->actualizarProducto($producto);
		if($estado){
			header("location: /shop/index.php");
		}else{
			echo "Ha sucedido algun error al actualizar los datos";
		}
	}else{
			var_dump($errores);
		}


	}





?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
	<div class="container h-100">
		<div class="blog-banner">
			<div class="text-center">
				<h1>Producto:</h1>
				<nav aria-label="breadcrumb" class="banner-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active" aria-current="page">Gestiona tu Producto</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</section>
<!-- ================ end banner area ================= -->

<!--================Login Box Area =================-->
<section class="login_box_area section-margin">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="login_box_img">
					<div class="hover">
						<h4>Producto</h4>
						<h5> <?php echo 'Subido el dia: ' . $created; ?> </h5>

					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner register_form_inner">
					<h3>Mis datos</h3>
					<form class="row login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'nombre'">
						</div>
						<div class="col-md-12 form-group">
							<fieldset>
								<!-- Textarea -->
								<div class="col-md-12">
									<textarea class="form-control" id="descripcion" name="descripcion" placeholder=""><?php echo $descripcion; ?></textarea>
								</div>
							</fieldset>
						</div>
						<div class="col-md-12 form-group">
							<select name="tipo">
								<?php if ($tipo == "propiedad") {
									echo '<option value="propiedad" selected>Propiedad</option>';
									echo '<option value="vehiculo">Vehiculo</option>';
									echo '<option value="objeto">Otros</option>';
								} elseif ($tipo == "vehiculo") {
									echo '<option value="propiedad">Propiedad</option>';
									echo '<option value="vehiculo" selected>Vehiculo</option>';
									echo '<option value="objeto">Otros</option>';
								} else {
									echo '<option value="propiedad">Propiedad</option>';
									echo '<option value="vehiculo">Vehiculo</option>';
									echo '<option value="objeto" selected>Otros</option>';
								} ?>

							</select>
						</div>
						<div class="col-md-12 form-group">
							<input type="number" class="form-control" id="precio" name="precio" placeholder="Precio" onfocus="this.placeholder = ''" onblur="this.placeholder = 'precio'" value="<?php echo $precio ?>">
						</div>
						<div class="col-md-12 form-group">
							<select name="stock">
								<?php if ($stock == "1") {
									echo '<option value="1" selected>En venta</option>';
									echo '<option value="0">Vendido</option>';
								} else {
									echo '<option value="1">En venta</option>';
									echo '<option value="0" selected>Vendido</option>';
								} ?>
							</select>
						</div>
						<div class="col-md-12 form-group">
							<input type="file" class="form-control" id="imagen" name="imagen" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = 'imagen'">
						</div>
						<div class="col-md-12 form-group">
						<input type="hidden" name="created" value="<?php echo $created; ?>"/>	
						<input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>"/>
						</div>
						<div class="col-md-12 form-group">
							<button type="submit" value="actualizar" name="actualizar" class="button button-register w-100">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<table border="solid" width=100%>
		<tbody>
			<?php foreach ($images as $i) { ?>
				<td><img src='/shop/images/<?php echo $i['name']  ?>' width="200" height="100"></img></td>
			<?php } ?>
		</tbody>
	</table>
</section>
<!--================End Login Box Area =================-->

<?php require_once VISTAS_PATH . "footer.php"; ?>