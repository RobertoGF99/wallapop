<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."funciones.php";
require_once CONTROLADOR_PATH."controladorUsuario.php";
require_once VISTAS_PATH."header.php";
require_once CLASES_PATH."user.php";
//require_once CONTROLADOR_PATH."controladorSesion.php";

//procesamos los datos introducidos
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"]){
	$emailVal=filtrado($_POST['email']);
	if(empty($emailVal)){
		$errores[]="introduzca su email";
	}else{
		$email=$emailVal;
	}

	$passwordVal=filtrado($_POST['password']);
	if(empty($passwordVal)){
		$errores[]="introduzca su contraseña";
	}else{
		$password=$passwordVal;
	}

	if(empty($errores)){
		$contr=controladorUsuario::getInstancia();
		$userlog=$contr->iniciarSesionn($email,$password);

	}else{
		echo "ha sucedido algun error";
	}
	//si la base de datos no devuelve ningun objeto, es que no existe el usuario
	if(empty($userlog)){
		echo "usu no encontrado";
	}else{
		//si devuelve algun objeto, el usuario existe. Iniciamos la sesion
		$contr=ControladorUsuario::getInstancia();
		$contr->startSesion($userlog);
		//$contr->crearCookie();

		header("location: /shop/index.php");
		//echo "sesion iniciada correctamente: " .$_SESSION["email"];
	}
}
?>
 <!-- ================ start banner area ================= -->	
 <section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Login / Register</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Login/Register</li>
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
							<h4>Eres un Usuario Nuevo?</h4>
							<p>Aqui podras crear tu cuenta</p>
							<a class="button button-account" href="/shop/vistas/registro.php">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="email" name="email" placeholder="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" name="submit" value="submit" class="button button-login w-100">Log In</button>
								<a href="#">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
