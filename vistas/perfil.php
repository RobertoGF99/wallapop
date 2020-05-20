<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/shop/rutas.php";
require_once CONTROLADOR_PATH . "controladorUsuario.php";
require_once CONTROLADOR_PATH."controladorProducto.php";
require_once CONTROLADOR_PATH . "controladorImagen.php";
require_once VISTAS_PATH . "header.php";

if(isset($_GET['id_perfil'])){
	//recuperamos los datos del usuario
	//recuperamos los productos que este usuario tiene publicados
	$contr=controladorUsuario::getInstancia();
	$user=$contr->buscarUsuarioId($_GET['id_perfil']);
	$contrp=controladorProducto::getInstancia();
	$productos=$contrp->miListadoProductos($_GET['id_perfil']);

	foreach ($productos as $p){
		//var_dump($p->nombre);

	}
	//var_dump($productos);

}


?>

<!--================Blog Area =================-->
<section class="blog_area single-post-area py-80px section-margin--small">
	<div class="container">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 posts-list">
					<div class="single-post row">
						<div class="col-lg-12">
							<div class="feature-img">
								<img class="img-fluid" src="img/blog/feature-img1.jpg" alt="">
							</div>
						</div>
						<div class="col-lg-3  col-md-3">
							<div class="blog_info text-right">
								<ul class="blog_meta list">
									<li></li>
									<li>Unido el dia: <?php echo $user->getFecha_creacion(); ?></li>
									<li>Email: <?php echo $user->getEmail(); ?></li>
									<li>Localizacion: <?php echo $user->getLocalizacion(); ?></li>
								</ul>
								
							</div>
						</div>
						<div class="col-lg-9 col-md-9 blog_details">
							<h2><?php echo $user->getNombre(). " " .$user->getApellido();?></h2>
							
						</div>
					</div>
					<div class="comments-area">
						<h4>Productos</h4>
						<?php //mostramos los productos publicados por este usuario
						foreach($productos as $p){?>
						<div class="comment-list">
							<div class="single-comment justify-content-between d-flex">
								<div class="user justify-content-between d-flex">
									<div class="thumb">
										<img src="" alt="">
									</div>
									<div class="desc">
										<?php echo "<h5><a href='/shop/vistas/detalle_producto.php?id_prod=".$p->id."'>".$p->nombre."-".$p->precio."</a></h5> ";?>
										<p class="date">Publicado el dia: <?php echo $p->created; ?> <?php if($p->stock==1){
											echo "En venta"; }else{ echo "Vendido";}  ?> <?php echo $p->tipo; ?></p>
										<p class="comment">
											<?php echo $p->descripcion; ?>
										</p>
									</div>
								</div>
								
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="comments-area">
						<h4>Opiniones sobre el usuario (no realizado)</h4>
						<div class="comment-list">
							<div class="single-comment justify-content-between d-flex">
								<div class="user justify-content-between d-flex">
									<div class="thumb">
										<img src="img/blog/c1.jpg" alt="">
									</div>
									<div class="desc">
										<h5>
											<a href="#">Emilly Blunt</a>
										</h5>
										<p class="date">December 4, 2017 at 3:12 pm </p>
										<p class="comment">
											Never say goodbye till the end comes!
										</p>
									</div>
								</div>
								<div class="reply-btn">
									<a href="#" class="btn-reply text-uppercase">reply</a>
								</div>
							</div>
						</div>
					</div>
					<div class="comment-form">
						<h4>Da una opinion sobre el usuario (No realizado)</h4>
						<form>
							<div class="form-group form-inline">
								<div class="form-group col-lg-6 col-md-6 name">
									<input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">
								</div>
								<div class="form-group col-lg-6 col-md-6 email">
									<input type="email" class="form-control" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
								</div>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'">
							</div>
							<div class="form-group">
								<textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
							</div>
							<a href="#" class="button button-postComment button--active">Post Comment</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================Blog Area =================-->

<?php require_once VISTAS_PATH . "footer.php";
