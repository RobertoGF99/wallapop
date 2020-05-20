<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorUsuario.php";
require_once CONTROLADOR_PATH."controladorImagen.php";
require_once CONTROLADOR_PATH."funciones.php";
require_once VISTAS_PATH."header.php";

//comprobamos que existe el usuario con la sesion abierta, buscamos y recuperamos los datos del usuario
if(isset($_SESSION['id_usu']) && isset($_SESSION['email']) && isset($_GET["email"])){
	$emailGet=$_GET["email"];
	var_dump($emailGet);
    $idGet=$_SESSION['id_usu'];
    $conn=controladorUsuario::getInstancia();
    $usu=$conn->buscarUsuarioID($_SESSION['id_usu']);
    if(!empty($usu)){
        //var_dump($usu);
        $id=$usu->getId_usu();
        $nombre=$usu->getNombre();
        $apellidos=$usu->getApellido();
        $email=$usu->getEmail();
        $localizacion=$usu->getLocalizacion();
		$create=$usu->getFecha_creacion();

		$images=$conn->userImages($_SESSION['id_usu']);

        

    }else{
        echo "el usuario no existe";
	}
	//si no hay una sesion abierta, no se podra acceder a esta pagina.
}else{
	"error";
}


//si el usuario pulsa el boton actualizar, procesamos los datos introducidos
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["actualizar"]){
	var_dump($_FILES['imagen_personal']['size']);

	$id=$_POST['id'];
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
	$confirmPasswordVal=filtrado($_POST["confirmPassword"]);
	if(empty($passwordVal || empty($confirmPasswordVal))){
		$password="";
	}elseif($passwordVal!=$confirmPasswordVal){
		$errores[]='las contraseñas deben coincidir';
	}elseif((empty($passwordVal) && !empty($confirmPasswordVal)) || (!empty($passwordVal) && empty($confirmPasswordVal))){
		$errores[]='si quiere cambiar la contraseña, asegurese de que la confirma';
	} 
	else{
		$password=$confirmPasswordVal;
	}
	$create=$_POST['create'];



	if(empty($errores) && $_FILES['imagen_personal']['size']>0){

		//tmp
		$file_tmp=$_FILES['imagen_personal']['tmp_name'];
		//var_dump($file_tmp);
		//name
		$file_name=$_FILES['imagen_personal']['name'];
		//var_dump($file_name);

		//ruta donde almacenamos la imagen
		$file_destino=IMAGES_PATH.$file_name;
		//var_dump($file_destino);
		$contri=ControladorImagen::getInstancia();
		$estado=$contri->saveImage($file_tmp,$file_destino);
		//var_dump($estado);
		if($estado==0){
			$errores[]='error al subir la imagen';
		}
	}elseif(empty($errores) && $_FILES['imagen_personal']['size']==0){
		$file_name=$_POST['imagenAntigua'];

	}	

	if(empty($errores)){	
		//comprobmos si vamos a actualizar la contraseña
		if($password==""){
			//recuperamos la contraseña que tenemos
			$contrp=controladorUsuario::getInstancia();
			$user=$contrp->buscarUsuarioID($id);
			$pass=$user->getPassword();
		}else{
			$pass=$password;
		}
		//almacenamos los datos obtenidos del formulario en un objeto y lo pasamos como parametro a nuestra funcion
		$user=new user($id,$nombre,$apellidos,$email,$pass,$localizacion,$create);
		$contr=controladorUsuario::getInstancia();
		$estado=$contr->actualizarUsuario($user);
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
					<h1>Mi Perfil</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Gestiona tu perfil</li>
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
                            <h4>Bienvenido a Tu Perfil <?php echo $nombre; ?></h4>
                            <h5> <?php echo 'Unido el dia: ' .$create; ?> </h5>
							
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner register_form_inner">
						<h3>Mis datos</h3>
						<form class="row login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'nombre'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos ?>" placeholder="Apellido" onfocus="this.placeholder = ''" onblur="this.placeholder = 'apellido'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="localizacion" name="localizacion" value="<?php echo $localizacion ?>" placeholder="¿Donde Vive?" onfocus="this.placeholder = ''" onblur="this.placeholder = 'localizacion'">
							</div>
							  
              				<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
             				</div>
              				<div class="col-md-12 form-group">
								<input type="passowrd" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'">
							</div>
							<div class="col-md-12 form-group">
								<input type="file" class="form-control" id="imagen_personal" name="imagen_personal" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = 'imagen_personal'">
							</div>
							<div class="col-md-12 form-group">
							</div>

							<input type="hidden" name="id" value="<?php echo $id; ?>"/>
							<input type="hidden" name="create" value="<?php echo $create; ?>"/>
							<input type="hidden" name="imagenAntigua" value="<?php echo $imagenAntigua; ?>"/>
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
			<?php 
			//mostramos las imagenes del usuario
			foreach($images as $i){ ?>
			<td><img src='/shop/images/<?php echo $i['name']  ?>' width="200" height="100"></img></td>
			<?php } ?>
			</tbody>
		</table>
	</section>
	<!--================End Login Box Area =================-->
