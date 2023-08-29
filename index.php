    
    <?php
    require "php/funciones.php";
    require "libs/Sql.php";
    require "libs/Imagen.php";
    
    $titulo = "Manejador de Imagenes";
    $etiquetasMenu = true;
    require "php/encabezado.php";
    
    $archivos = Imagen::leeDirectorio();
    $extensiones_array = array("jpg", "jpeg", "gif", "png");

    ?>
        
        <div class="col-sm-8 sidenav mt-3">
            <h2 class="text-center">Mis Imagenes</h2>
        <?php
        $fotos_array = [];
			foreach ($archivos as $archivo) {
                $ext = $archivo->getExtension();
                if($archivo->isFile() && in_array($ext,$extensiones_array)){
                    $img = $archivo->getPath()."/".$archivo->getFilename();
                    $mini = "mini/".$archivo->getFilename();
                    $foto = [
                        "archivo"=>$archivo->getFilename(),
                        "camino"=>$archivo->getPath(),
                        "size"=>round($archivo->getSize()/1024,1),
                        "fecha"=>$archivo->getFilename()
                    ];
                    $foto["id"] = Imagen::buscaImagen($foto);
                    $fotos_array[] = $foto;
                    if (file_exists($mini)) {
                        print "<img id='' src='".$mini."' onClick=selecciona(".$foto["id"].") />";
                    } else {
                        print "<img id='' src='".$img."' height='80' onClick=selecciona(".$foto["id"].") />";
                    }
                    
                }
			}

        unset($archivos);



        require "php/piepagina.php";   
        ?>



    