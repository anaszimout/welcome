<?php
//comprobamos si ha ocurrido un error
if ($_FILES["imagen"]["error"] > 0){
	echo "Ha ocurrido un error.";
} else {
	//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
	//y que el tamano del archivo no exceda los 100kb
	$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	$limite_kb = 100;

	if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){
		//esta es la ruta donde copiaremos la imagen
		//recuerden que deben crear un directorio con este mismo nombre
		//en el mismo lugar donde se encuentra el archivo subir.php
		$ruta = "./img/" . $_FILES['imagen']['name'];
		//comprovamos si este archivo existe para no volverlo a copiar.
		//pero si quieren pueden obviar esto si no es necesario.
		//o pueden darle otro nombre para que no sobreescriba el actual.
		if (!file_exists($ruta)){
			//aqui movemos el archivo desde la ruta temporal a nuestra ruta
			//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
			//almacenara true o false
			$resultado = move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
			if ($resultado){
				echo "El archivo ha sido movido exitosamente";
			} else {
				echo "Ocurrió un error al mover el archivo.";
			}
		} else {
			echo('La imagen ya existe, ¿quieres sobreescribirla?');
			$resultado = move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
			if ($resultado){
				echo $_FILES['imagen']['name'] . ", imagen sobreescrita correctamente.";
			} else {
				echo "Ocurrió un error al mover el archivo.";
			}
		}
	} else {
		echo "Archivo no permitido, es un tipo de archivo prohibido o excede el tamaño de $limite_kb Kilobytes";
	}
}
?>