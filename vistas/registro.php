<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorUsuario.php";
require_once CONTROLADOR_PATH."controladorImagen.php";
require_once CONTROLADOR_PATH."funciones.php";
require_once VISTAS_PATH."header.php";

?>

<?php
//si recibimos datos del formulario, filtramos y procesamos
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"]){
	$nombreVal=filtrado($_POST["nombre"]);
	if(empty($nombreVal)){
		$errores[]='Introduzca un nombre, por favor';
	}
	else{
		$nombre=$nombreVal;
	}
	$apellidosVal=filtrado($_POST["apellidos"]);
	if(empty($apellidosVal)){
		$errores[]='Introduzca un apellido, por favor';
	}
	else{
		$apellidos=$apellidosVal;
	}
	$emailVal=filtrado($_POST["email"]);
	if(empty($emailVal)){
		$errores[]='Introduzca un email, por favor';
	}
	else{
		$email=$emailVal;
	}
	$localizacionVal=filtrado($_POST["localizacion"]);
	if(empty($localizacionVal)){
		$errores[]='Introduzca una localizacion, por favor';
	}
	else{
		$localizacion=$localizacionVal;
	}

	$passwordVal=filtrado($_POST["password"]);
	$confirmPasswordVal=$_POST["confirmPassword"];
	if(empty($passwordVal || empty($confirmPasswordVal))){
		$errores[]='Introduzca la contraseña, por favor';
	}elseif($passwordVal!=$confirmPasswordVal){
		$errores[]='las contraseñas deben coincidir';
	}
	else{
		$password=$confirmPasswordVal;
	}
	//procesamos las imagenes
	if(empty($errores)){
		if(count($_FILES['imagen_personal']['name'])){
			for($i=0; $i<count($_FILES['imagen_personal']['name']);$i++){
				$tmp_file=$_FILES['imagen_personal']['tmp_name'][$i];
				if($tmp_file!=""){
					$name_file=$_FILES['imagen_personal']['name'][$i];
					$size_file=$_FILES['imagen_personal']['size'][$i];
					$path_file=IMAGES_PATH.$_FILES['imagen_personal']['name'][$i];
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
		//almacenamos el usuario
		$contr=controladorUsuario::getInstancia();
		$estado=$contr->almacenarUsuario($nombre,$apellidos,$email,$localizacion,$password);


		$estadoid=$contr->usuarioId($email);
		$contri=controladorBD::getInstancia();
		$contri->abrirBD();
		//almacenamos las imagenes
		if(count($_FILES['imagen_personal']['name'])){
			for($i=0; $i<count($_FILES['imagen_personal']['name']);$i++){
				$consultai="INSERT INTO `images_user` (`name`,`id_usuario`) VALUES (:name,:id_usu)";
				$parametrosi=array(':name'=>$_FILES['imagen_personal']['name'][$i], 'id_usu'=>$estadoid);
				$insert=$contri->actualizarBDParm($consultai,$parametrosi);
			}
		}
		$contri->cerrarBD();


		if($estado){
			header("location: /shop/index.php");
		}else{
			echo "Ha sucedido algun error. Vuelva a intentarlo.";
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
					<h1>Register</h1>
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
	<!-- ================ end banner area ================= -->
  
  <!--================Login Box Area =================-->
	<section class="login_box_area section-margin">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<div class="hover">
							<h4>Ya tienes una cuenta?</h4>
							<p>Haz click aqui para iniciar sesion</p>
							<a class="button button-account" href="/shop/vistas/login.php">Login Now</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner register_form_inner">
						<h3>Create an account</h3>
						<form class="row login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
							<div class="col-md-12 form-group">
								<input type="text" maxlength="30" pattern="([^\s][A-zÀ-ž\s]+)" class="form-control" id="nombre" name="nombre" placeholder="Nombre" onfocus="this.placeholder = ''" onblur="this.placeholder = 'nombre'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text"  pattern="([^\s][A-zÀ-ž\s]+)" maxlength="50" class="form-control" id="apellidos" name="apellidos" placeholder="Apellido" onfocus="this.placeholder = ''" onblur="this.placeholder = 'apellido'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="localizacion" name="localizacion" placeholder="¿Donde Vive?" onfocus="this.placeholder = ''" onblur="this.placeholder = 'localizacion'">
							</div>
							  
              				<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
             				</div>
              				<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'">
							</div>
							<div class="col-md-12 form-group">
								<input type="file" multiple class="form-control" id="imagen_personal" name="imagen_personal[]" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = 'imagen_personal'">
							</div>
							<div class="col-md-12 form-group">
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" name="submit" class="button button-register w-100">Register</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
<?php require_once VISTAS_PATH."footer.php"; ?>