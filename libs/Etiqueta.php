<?php

class Etiqueta{


    function __construct(){}

	public static function altaEtiqueta($id,$marca)
	{
		$db = new Sql();
		$mensaje = "ok";
		//Verificamos si existe la etiqueta
		$sql = "SELECT * FROM etiquetas ";
		$sql.= "WHERE etiqueta='".$marca."'";
		$r = $db->query($sql);
		if ($r==NULL) {
			//Insertamos la etiqueta
			$sql = "INSERT INTO etiquetas VALUES(0,'".$marca."')";
			if ($db->queryNoSelect($sql)) {
				//Insertar en la tabla pivote
				$idEtiqueta = $db->recuperaId();
				$sql = "INSERT INTO imagenetiqueta VALUES(0,";
				$sql.= $id.",".$idEtiqueta.")";
				if (!$db->queryNoSelect($sql)) {
					$mensaje = "Error al insertar el registro en la tabla pivote";
				}
			} else {
				$mensaje = "Error al insertar el registro en la tabla de etiquetas";
			}
		} else {
			
			//Ya existe la etiqueta
			$idEtiqueta = $r["id"];
			$sql = "SELECT * FROM imagenetiqueta ";
			$sql.= "WHERE idEtiqueta=".$idEtiqueta." AND ";
			$sql.= "idImagen=".$id;
			$r = $db->query($sql);
			//
			if($r==NULL){
				//Insertar si no existe
				$sql = "INSERT INTO imagenetiqueta VALUES(0,";
				$sql.= $id.",".$idEtiqueta.")";
				if (!$db->queryNoSelect($sql)) {
					$mensaje = "Error al insertar el registro";
				}
			}

		}
		return $mensaje;
	}

    public static function leeEtiquetas(){

        $db = new Sql();

        $sql = "SELECT * FROM etiquetas ";
		$sql.= "ORDER BY etiqueta";
		$data = $db->querySelect($sql);
        $db->close();

        return $data;
    }

    public static function leeEtiquetasImagen($id){

        $db = new Sql();

		$sql = "SELECT e.etiqueta, e.id ";
		$sql.= "FROM imagenetiqueta as i, etiquetas as e ";
		$sql.= "WHERE i.idImagen=".$id." AND ";
		$sql.= "e.id=i.idEtiqueta";
		$data = $db->querySelect($sql);
		$db->close();
		return $data;
    }

	public static function borraEtiqueta($idImagen, $idEtiqueta){

		$db = new Sql();

		$sql = "DELETE FROM imagenEtiqueta ";
		$sql.= "WHERE idImagen=".$idImagen." AND ";
		$sql.= "idEtiqueta=".$idEtiqueta;
		$r = $db->queryNoSelect($sql);
		$db->close();
		return $r;

	}


}



?>