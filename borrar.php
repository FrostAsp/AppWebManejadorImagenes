<?php
require "libs/Sql.php";
require "libs/Imagen.php";

if (isset($_GET["id"])) {
	$id = $_GET["id"];
} else if(isset($_GET["d"])){
	$id = $_GET["d"];
	//proceso de borrado
	if(Imagen::borrarImagen($id)){
		header("location:index.php");
	}else{
		print "Existio un problema al borrar la imagen<br>";
	}
	

} else {
	header("location:index.php");
}

$data = Imagen::leeImagen($id);
$etiquetasMenu = false;
$titulo = "Borrar Imagen";
require "php/encabezado.php";
?>
<div class="col-sm-5">
	<?php
		$archivo = $data["camino"]."/".$data["archivo"];
		print "<img src='".$archivo."' width='100%'/>";
	?>
</div>
<div class="col-sm-3">
	<h3 class="text-center">Borrar la imagen</h3>
	<?php
	$img = $data["camino"]."/".$data["archivo"];
	$imagen = getimagesize($img);
	$ancho = $imagen[0];
	$alto = $imagen[1];

	print "<table>";
	print "<tr><td>id: </td><td>".$id."</td></tr>";
	print "<tr><td>Archivo: </td><td>".$data["archivo"]."</td></tr>";
	print "<tr><td>Camino: </td><td>".$data["camino"]."</td></tr>";
	print "<tr><td>Tamaño: </td><td>".$data["size"]." kb</td></tr>";
	print "<tr><td>Ancho: </td><td>".number_format($ancho,0)."px </td></tr>";
	print "<tr><td>Alto: </td><td>".number_format($alto,0)."px </td></tr>";
	print "<tr><td>Fecha: </td><td>".date("Y/m/d",$data["fecha"])."</td></tr>";
	print "</table>";
	print "<br>";
	print "<a class='btn btn-danger btn-block' href='borrar.php?d=".$id."'>Borrar</a><br>";
	print "<a class='btn btn-success btn-block' href='caratula.php?id=".$id."'>Regresar</a><br>";
	?>
</div>
<?php
require "php/piepagina.php";
?>