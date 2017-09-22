<?php
	if(isset($_POST['editar']) && $_POST['nombre'] != ""){
		$fecha = date('Y-m-d H:i:s');

		if($_FILES['imagen']['name'] != null){
			require_once('image_resize.php');

			$anio = date('Y');
			$mes = date('m');
			

			$dir = "img/media/".$anio."/".$mes."/";
			$max_file = 3;
			$upload_dir = "../img/media/".$anio."/".$mes."/";
			$allowed_image_types = array('image/jpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png");
			$allowed_image_ext = array_unique($allowed_image_types); 
			$image_ext = "";

			foreach ($allowed_image_ext as $mime_type => $ext) {
				$image_ext.= strtoupper($ext)." ";
			}

			$random = strtotime(date('Y-m-d H:i:s'));
			$userfile_name = $_FILES['imagen']['name'];
			$userfile_tmp = $_FILES['imagen']['tmp_name'];
			$userfile_size = $_FILES['imagen']['size'];
			$userfile_type = $_FILES['imagen']['type'];
			$filename = basename($_FILES['imagen']['name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

			$original_location = $upload_dir."".$filename;


			//Solo precedemos si las imagenes son JPG, PNG, GIF y que no exedan el peso limite
			if((!empty($_FILES["imagen"]['name'])) && ($_FILES['imagen']['error'] == 0)) {
				foreach ($allowed_image_types as $mime_type => $ext) {
					//se hace un bucle atraves de los tipos de imagen especificados y se verifica si coincide con la extension despues de eso termina
					if($file_ext==$ext && $userfile_type==$mime_type){
						$error = "";
						break;
					}else{
						$error = "Solo se admiten imagenes con formato <strong>".$image_ext."</strong> <br />";
					}
				}
				//verifica que la imagen sea menor al tamaño especificado
				if ($userfile_size > ($max_file*1048576)) {
					$error.= "Las imagenes deben pesar menos de ".$max_file."MB";
				}
				
			}else{
				$error= "Seleccione una imagen para subir";
			}

			//Todo esta bien ahora si podemos subir la imagen.
			if (strlen($error)==0){			
				
				move_uploaded_file($userfile_tmp, $original_location);
				
				$image_normal = $upload_dir."imagen_".$random.".".$file_ext;
				
				$normal = new thumb();
				$normal->loadImage($original_location);
				$normal->resize(500, "width");
				$normal->save($image_normal, 90);
				
				unlink($original_location);
		
				$ruta_image_normal = $dir."imagen_".$random.".".$file_ext;

			}
				
		//fin condicion
		}else{
			$ruta_image_normal = "";
		}
		$password = trim($_POST['passwd']);
		$insertarRegistro = "INSERT INTO ".DB_PREFIJO."usuario(id".DB_PREFIJO."usuario,correo,token,avatar,nombre,apellidos,creado) 
		VALUES (0,'".$_POST['correo']."','".md5($password)."','".$ruta_image_normal."','".utf8_decode($_POST['nombre'])."','".utf8_decode($_POST['apellidos'])."','".$fecha."')";
		//echo $insertarRegistro; exit();
		mysqli_query($conexion,$insertarRegistro) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El usuario ha sido creado con éxito";

	}


?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Usuarios del Sistema - <?php echo PROYECTO; ?></title>
	<!-- Metas  Especificas para  mobiles -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo ADMINURL; ?>img/favicon.png">
	<link rel="apple-touch-icon" href="<?php echo ADMINURL; ?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo ADMINURL; ?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo ADMINURL; ?>img/apple-touch-icon-114x114.png">
</head>
<body>
	<div class="dashboard">
		<?php require_once(PREFIJO.'menu.php'); ?>
		<div class="container">
			<div class="sixteen columns">
			<?php if (isset($error) && $error != null) { ?>
				<div class="alert alert-danger"><?php echo $error; ?></div>
			<?php } ?>
			<?php if (isset($success)){ ?>
				<div class="alert alert-success"><?php echo $success; ?></div>
			<?php } ?>
			</div>
			<div class="ten columns">
				<div class="list-items">
			        <div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
			        		<h4>Datos de usuario</h4>
			        		<label for="portada">Fotografía</label>
							<input type="file" name="imagen"><br><br>
							<label for="correo">Correo</label>
			        		<input type="text" name="correo" placeholder="Correo Electrónico" value="">
			        		<label for="contrasena">Contraseña</label>
			        		<input type="password" name="passwd"  id="password" value="" placeholder="Contraseña" required>
			        		<label for="contrasena">Confirmar Contraseña</label>
			        		<input type="password" name="confirmapasswd" id="confirm_password" placeholder="Confirmar Contraseña"  value="" required>
			        		<h4>Información Adicional</h4>
							<label for="nombre">Nombre</label>
			        		<input type="text" name="nombre" placeholder="Nombre" value="" required>
			        		<label for="apellidos">Apellidos</label>
			        		<input type="text" name="apellidos" placeholder="Apellidos" value="">
			        		<label for="telefono">Teléfono</label>
			        		<input type="text" name="telefono" placeholder="Teléfono" value="">
			        		<input type="submit" name="editar" value="Guardar">
			        	</form>
			     	</div>
			    </div>
	    </div>
	</div>
	<?php require_once(PREFIJO.'footer.php'); ?>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/default.js"></script>
	<script>
		$(document).ready(function(){
			var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");

			function validatePassword(){
			  if(password.value != confirm_password.value) {
			    confirm_password.setCustomValidity("Las contraseñas no cohinciden");
			  } else {
			    confirm_password.setCustomValidity('');
			  }
			}

			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		});
	</script>
</body>
</html>