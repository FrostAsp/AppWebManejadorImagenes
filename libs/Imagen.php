<?php

class Imagen{


    function __construct(){  }

	public static function leeDirectorio()
	{
		$archivo = new RecursiveDirectoryIterator("img");
		$archivo->setFlags(FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS);
		$archivo = new RecursiveIteratorIterator($archivo, RecursiveIteratorIterator::SELF_FIRST);
		return $archivo;
	}

	public static function buscaImagen($data)
	{
		$db = new SQL();
		
		$sql = "SELECT id FROM imagenes ";
		$sql .= "WHERE archivo='" . $data["archivo"] . "' AND ";
		$sql .= "camino='" . $data["camino"] . "'";
		$r = $db->query($sql);
		
		if ($r == NULL) {
			$sql = "INSERT INTO imagenes (archivo, camino, size, fecha) ";
			$sql .= "VALUES ('" . $data["archivo"] . "', ";
			$sql .= "'" . $data["camino"] . "', ";
			$sql .= $data["size"] . ", ";
			$sql .= "'" . $data["fecha"] . "')";
			
			if ($db->queryNoSelect($sql)) {
				$id = $db->recuperaId();
			} else {
				$id = NULL;
			}
		} else {
			$id = $r["id"];
		}
		//
		//Crear viñeta / mini
		//
		$mini = quitarExtension($data["archivo"]);
		if(file_exists("mini/".$mini.".jpg")==false){
			Imagen::optimizar($id,$mini,0,"mini",80);
		} 
		$db->close();
		return $id;
		
	}

	public static function leeImagen($id)
	{
		$db = new SQL();
	
		$sql = "SELECT * FROM imagenes ";
		$sql .= "WHERE id=" . $id;
		$data = $db->query($sql);
		$db->close();
		return $data;

		
	}

	public static function borrarImagen($id){

		$data = self::leeImagen($id);
		$db = new Sql();
		$archivo = $data["camino"]."/".$data["archivo"];
		$mini = "mini/".$data["archivo"];
		if(file_exists($archivo)){
			unlink($archivo);
		}else{
			print "Error";
			exit();
		}
		if (file_exists($mini)) {
			unlink($mini);
		} else {
			print "Error";
			exit();
		}
		//Borrar de la tabla imagenes
		$sql = "DELETE FROM imagenes WHERE id=".$id;
		if($db->queryNoSelect($sql)){
			$sql = "DELETE FROM imagenEtiqueta ";
			$sql.= "WHERE idImagen =".$id;
			if($db->queryNoSelect($sql)){
				return true;
			}
		}
		return false;
	}
	
	public static function optimizar($id,$nombre,$op,$carpeta,$nuevoAlto=0)
	{
		$data = self::leeImagen($id);
		//
		$archivo = $data["camino"]."/".$data["archivo"];
		//
		$info = getimagesize($archivo);
		$ancho = $info[0];
		$alto = $info[1];
		$tipo = $info["mime"];
		//
		//Nuevas dimensiones
		//
		if ($op>0) {
			$nuevoAncho = $ancho * $op / 100;
			$nuevoAlto = $alto * $op / 100;
		} else if($nuevoAlto>0){
			$factor = $nuevoAlto / $alto; 
			$nuevoAncho = $ancho * $factor;
		}

		//
		//Leemos la información del archivo a memoria
		//
		switch ($tipo) {
			case 'image/jpg':
			case 'image/jpeg':
				$imagen = imagecreatefromjpeg($archivo);
				break;

			case 'image/png':
				$imagen = imagecreatefrompng($archivo);
				break;

			case 'image/gif':
				$imagen = imagecreatefromgif($archivo);
				break;
		}

		//Crear el lienzo

		$lienzo = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
								
		//Preparamos el lienzo para el canal alfa				
		if ($tipo=="image/png") {
									
			imagecolortransparent($lienzo, imagecolorallocatealpha($lienzo, 0, 0, 0, 127));							
			imagealphablending($lienzo, false);
			imagesavealpha($lienzo, true);
								
		}
		//optimizamos
		imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
		
		//verificar carpeta
		if (file_exists($carpeta)==false) {
			mkdir($carpeta, 0777, true);
		}

		//Vaciamos al disco
		if($tipo=="image/jpg" || $tipo=="image/jpeg"){
			imagejpeg($lienzo, $carpeta."/".$nombre.".jpg",80);
		} else if($tipo=="image/gif"){
			imagegif($lienzo, $carpeta."/".$nombre.".gif");
		} else if($tipo=="image/png"){
			imagepng($lienzo, $carpeta."/".$nombre.".png");
		} 
		
		//regresamos
		//header("location:index.php");
		return true;
	}

}



?>