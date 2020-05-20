<?php
require_once $_SERVER['DOCUMENT_ROOT']."/shop/rutas.php";
require_once CONTROLADOR_PATH."controladorProducto.php";
require_once CONTROLADOR_PATH."controladorImagen.php";
require_once VISTAS_PATH."header.php";
var_dump($_SESSION["id_usu"]);

if( !isset($_SESSION['id_usu'])){
	echo "error";
}else{
	$id_usu=$_SESSION['id_usu'];
}


?>

<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Mis Productos</h1>
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
<section>
    <div>
<?php
$contr=controladorProducto::getInstancia();
$row=$contr->miListadoProductos($id_usu);

if(count($row)>0){
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Id-Producto</th>";
    echo "<th>Tipo</th>";
    echo "<th>Nombre</th>";
    echo "<th>Descripcion</th>";
    echo "<th>Precio</th>";
    echo "<th>Created</th>";
    echo "<th>Stock</th>";
    echo "<th>Accion</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($row as $p){
        echo "<tr>";
        echo "<td>" . $p->id . "</td>";
        echo "<td>" . $p->tipo . "</td>";
        echo "<td>" . $p->nombre . "</td>";
        echo "<td>" . $p->descripcion . "</td>";
        echo "<td>" . $p->precio . "</td>";
        echo "<td>" . $p->created . "</td>";
        if($p->stock ==0){
            echo "<td>Vendido</td>";
        }else{
            echo "<td>En venta</td>";
        }
        echo"<td>";
        echo "<a href='/shop/vistas/detalle_producto_admin.php?id_prod= ".$p->id."&id_usu=".$_SESSION['id_usu']."'>Detalle</a> "; 
        echo "<a href='/shop/vistas/delete_producto_admin.php?id_prod= ".$p->id."&id_usu=".$_SESSION['id_usu']."'>Eliminar</a> ";
        echo "<a href='/shop/vistas/detalle_producto.php?id_prod= ".$p->id."&id_usu=".$_SESSION['id_usu']."'>Ver Producto</a> ";
        echo "</td>";

        echo "</tr>";

    }
    echo "</tbody>";
    echo "</table>";

}else{
    echo "no hay productos";

}

?>
</div>
</section>
<?php require_once VISTAS_PATH."footer.php"; ?>