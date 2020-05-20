<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorProducto.php";
require_once CONTROLADOR_PATH."controladorImagen.php";
require_once CONTROLADOR_PATH."funciones.php";
require_once VISTAS_PATH."header.php";
//var_dump($_SESSION["id_usu"]);

if( !isset($_SESSION['id_usu'])){
	echo "error";
}else{
	$id_usu=$_SESSION['id_usu'];
}


if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"]){
	/*
	var_dump($_POST['nombre']);
	var_dump($_POST['descripcion']);
	var_dump($_POST['tipo']);
	var_dump($_POST['precio']);
	var_dump($_POST['stock']);
	var_dump($_POST['id_usu']);
	$total=array($_FILES['imagen']);
	var_dump($total);
	*/
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
	$id_usuVal=$_POST["id_usu"];
	if(empty($id_usuVal)){
		$errores[]='error con el usuario';
	}else{
		$id_usu=$id_usuVal;
	}

	if(empty($errores)){
		//si hay imagenes para guardar....
		if(count($_FILES['imagen']['name'])){
			for($i=0; $i<count($_FILES['imagen']['name']);$i++){
				//obtenemos la ruta temporal
				$tmp_file=$_FILES['imagen']['tmp_name'][$i];
				if($tmp_file!=""){
					//obtenemos el nombre de la imagen y el tamaño
					$name_file=$_FILES['imagen']['name'][$i];
					$size_file=$_FILES['imagen']['size'][$i];
					//Guardamos en un variable la ruta que queremos que tengan las imagenes
					$path_file=IMAGES_PATH.$_FILES['imagen']['name'][$i];
					if(move_uploaded_file($tmp_file,$path_file)){
						$images[]=$name_file;
						$images_size[]=$size_file;
						//var_dump($images);
					}
				}
			}
		}
		
	}
	if(empty($errores)){
		//si no hay errores almacenamos el producto en la base de datos
		$contr=controladorProducto::getInstancia();
		$estado=$contr->almacenarProducto($nombre,$descripcion,$tipo,$precio,$stock,$id_usu);

		$contrid=controladorProducto::getInstancia();
		$estadoid=$contrid->productoId($_SESSION['id_usu']);

		//hacemos lo mismo con las imagenes
		$contri=controladorBD::getInstancia();
		$contri->abrirBD();
		if(count($_FILES['imagen']['name'])>0){
			for($i=0; $i<count($_FILES['imagen']['name']);$i++){
				$consultai="INSERT INTO `images_producto` (`name`,`id_producto`) VALUES (:name,:id_prod)";
				$parametrosi=array(':name'=>$_FILES['imagen']['name'][$i], 'id_prod'=>$estadoid);
				$insert=$contri->actualizarBDParm($consultai,$parametrosi);
			}
		}
		$contri->cerrarBD();
			//var_dump($i);
		//}

		
		//var_dump($contr);
		if($estado){
			header("location: /shop/index.php");
			
			
		}else{
			echo "Ha sucedido un error.";
		}
	}else{
			var_dump($errores);
		}

}

?>

<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Sube tu Producto</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Register</li>
            </ol>
          </nav>
                </div>
                
            </div>
    </div>
    </section>
    <div class="login_form_inner register_form_inner">
						<h3>Caracteristicas de tu producto</h3>
						<form class="row login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" onfocus="this.placeholder = ''" onblur="this.placeholder = 'nombre'">
							</div>
							<div class="col-md-12 form-group">
							<fieldset>
								<!-- Textarea -->
								<div class="col-md-12" rows="6">                     
									<textarea  class="form-control" id="descripcion" name="descripcion" placeholder="Como es tu producto..."></textarea>
								</div>
								</fieldset>
							</div>
							<div class="col-md-12 form-group">
								<select name="tipo">
									<option value="propiedad">Propiedad</option>
									<option value="vehiculo">Vehiculo</option>
									<option value="objeto">Otros</option>
								</select>
							 </div>
							<div class="col-md-12 form-group">
								<input type="number" class="form-control" id="precio" name="precio" placeholder="Precio" onfocus="this.placeholder = ''" onblur="this.placeholder = 'precio'">
							</div>
							<div class="col-md-12 form-group">
								<input type="file" multiple="multiple" class="form-control" id="imagen" name="imagen[]" placeholder="Imagen de tu producto" onfocus="this.placeholder = ''" onblur="this.placeholder = 'imagen'">
							</div>
							  
              				<div class="col-md-12 form-group">
								<select name="stock">
									<option value='1'>En venta</option>
									<option value='0'>Vendido</option>
								</select>
							 </div>
							 
							 
							 
							<div class="col-md-12 form-group">
							<input type="hidden" name="id_usu" value="<?php echo $id_usu; ?>"/>
							
						</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" name="submit" class="button button-register w-100">Subir Producto</button>
							</div>



						</form>
					</div>

<?php require_once VISTAS_PATH."footer.php"; ?>