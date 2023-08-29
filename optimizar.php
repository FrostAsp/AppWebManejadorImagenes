<?php
require "libs/Sql.php";
require "libs/Imagen.php";

if (isset($_GET["id"])) {
	$id = $_GET["id"];
} else if(isset($_POST["id"])){
	$id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $op = $_POST["op"];
    if($nombre!="" && $op!=""){
       if(Imagen::optimizar($id,$nombre,$op,"img/nuevas")){
        header("location:index.php");
       }else{
            print "Error al optimizar la imagen";
       }

    }
} else {
	header("location:index.php");
}

$data = Imagen::leeImagen($id);



$etiquetasMenu = false;
$titulo = "Optimizar Imagen";
require "php/encabezado.php";
?>
<div class="col-sm-5">
	<?php
		$archivo = $data["camino"]."/".$data["archivo"];
		print "<img src='".$archivo."' width='100%'/>";
	?>
</div>
<div class="col-sm-3">
	<h3 class="text-center">Optimizar la imagen</h3>
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
	?>
    <br>
    <form action="optimizar.php" method="post">

        <select id="op" name="op">

           <option value="">Selecciona un porcentaje</option>
           <option value="75">75%</option>
           <option value="50">50%</option>
           <option value="25">25%</option>
           <option value="10">10%</option>

        </select>

        <br><br>
        <label for="nombre">Nombre de la nueva imagen:</label>
        <br><br>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <input type="hidden" name="id" id="id" value="<?php print $id;
        ?>"/>
        <br>
        <input type="submit" class="btn btn-info btn-block" value="Optimizar"/>


    </form>
    <br>
    <a class='btn btn-success btn-block' href='index.php'>Regresar</a><br>

</div>
<?php
require "php/piepagina.php";
?>