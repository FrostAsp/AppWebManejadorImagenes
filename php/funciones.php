<?php
function quitarExtension($archivo)
{
	$extension = pathinfo($archivo, PATHINFO_EXTENSION);
	return basename($archivo,".".$extension);
}
?>