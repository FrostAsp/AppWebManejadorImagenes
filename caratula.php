<?php
require "libs/Sql.php";
require "libs/Imagen.php";
require "libs/Etiqueta.php";

if (isset($_GET["id"])) {
	$id = $_GET["id"];
}else if(isset($_GET["i"]) && isset($_GET["e"])){

	$id = $_GET["i"];
	$idEtiqueta = $_GET["e"];
	if(!Etiqueta::borraEtiqueta($id, $idEtiqueta)){
		print "Error al borrar la etiqueta";
	}

} else if(isset($_POST["id"]) && isset($_POST["etiqueta"])){
	$id = $_POST["id"];
	$etiqueta = $_POST["etiqueta"];
	if($etiqueta !=""){

		$mensaje = Etiqueta::altaEtiqueta($id,$etiqueta);
		if($mensaje != "ok"){
			print $mensaje."<br>";
		}
	}
} else {
	header("location:index.php");
}

$data = Imagen::leeImagen($id);
$etiquetas_array = Etiqueta::leeEtiquetas();
$tagns_array = Etiqueta::leeEtiquetasImagen($id);

$etiquetasMenu = false;
$titulo = "Muestra Imagen";
require "php/encabezado.php";
?>
<div class="col-sm-5">
	<?php
		$archivo = $data["camino"]."/".$data["archivo"];
		print "<img src='".$archivo."' width='100%'/>";
	?>
</div>
<div class="col-sm-3">
	<h3 class="text-center">Datos de la imagen</h3>
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

	print "<a class='btn btn-info btn-block' href='#'>Filtrar</a><br>";
	print "<a class='btn btn-info btn-block' href='#'>Rotar</a><br>";
	print "<a class='btn btn-info btn-block' href='optimizar.php?id=".$id."'>Cambiar tamaño</a><br>";
	print "<a class='btn btn-danger btn-block' href='borrar.php?id=".$id."'>Borrar</a><br>";
	print "<a class='btn btn-success btn-block' href='index.php'>Regresar</a><br>";
	?>

	<form action="caratula.php" method="post">
		<input type="hidden" name="id" id="id" value="<?php print $id; ?>">
		<input list="etiqueta" name="etiqueta"/>
		<datalist>
		
			<?php
			
			foreach($etiquetas_array as $etiqueta){
				print "<option value='".$etiqueta["etiqueta"]."'>";
			}			
			
			?>

		</datalist>
		<input type="submit" value="Enviar etiqueta">
	</form>
	
	<br>
	<?php
	foreach($tagns_array as $tag){

		$e = $tag["etiqueta"];
		$idEtiqueta = $tag["id"];
		print "<a href='caratula.php?i=".$id."&e=".$idEtiqueta."
		'>&times;</a>&nbsp;".$e."<br>";
	}
	?>

</div>
<?php
require "php/piepagina.php";
?>