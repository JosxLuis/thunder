<?php
require_once('../lib/config.php');
require_once('../lib/mysql.php');
require_once('image_resize.php');
function generateRandomString($length = 10) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$anio = date('Y');
$mes = date('m');

$fecha = date('Y-m-d H:i:s');

$output_dir = "../img/media/".$anio."/".$mes."/";
$save_file = "img/media/".$anio."/".$mes."/";

 if(isset($_FILES["myfile"]))
 {
	$ret = array();

	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 	 	$nombreImagen  = $fileName;
		$porciones = explode("-", $nombreImagen);
		$claveImagen =  $porciones[0]; // porción1

		$buscarProducto = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."producto WHERE clave='".$claveImagen."' AND portada = 'img/no-picture.jpg'");

		if($buscarProducto['id'.DB_PREFIJO.'producto'] != ""){

 	 	$file_ext = strtolower(substr($fileName, strrpos($fileName, '.') + 1));
		$random = generateRandomString();
		$newName = $output_dir."imagen_".$random.".".$file_ext;
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$newName);
 			
 			$normal = new thumb();
			$normal->loadImage($newName);
			$normal->resize(600, "width");
			$normal->save($newName, 90);

 		$rutadb = $save_file."imagen_".$random.".".$file_ext;
    	$ret[]= $fileName;
    	$guardaArchivo = "UPDATE ".DB_PREFIJO."producto SET portada='".$rutadb."' WHERE id".DB_PREFIJO."producto=".$buscarProducto['id'.DB_PREFIJO.'producto']." ";
    	mysqli_query($conexion,$guardaArchivo);
    	}
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];

	  	$nombreImagen  = $fileName;
		$porciones = explode("-", $nombreImagen);
		$claveImagen =  $porciones[0];

		$buscarProducto = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."producto WHERE clave='".$claveImagen."' AND portada = 'img/no-picture.jpg'");

		if($buscarProducto['id'.DB_PREFIJO.'producto'] != ""){

		  	$file_ext2 = strtolower(substr($fileName, strrpos($fileName, '.') + 1));
			$random2 = generateRandomString();
			$newName2 = $output_dir."imagen_".$random2."_".$i.".".$file_ext2;
			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$newName2);
			$rutadb = $save_file."imagen_".$random2."_".$i.".".$file_ext2;
		  	$ret[]= $fileName;
		  	$guardaArchivo = "UPDATE ".DB_PREFIJO."producto SET portada='".$rutadb."' WHERE id".DB_PREFIJO."producto=".$buscarProducto['id'.DB_PREFIJO.'producto']." ";
	    	mysqli_query($conexion,$guardaArchivo);
	    }
	  }
	
	}
    echo json_encode($ret);
 }
 
 ?>