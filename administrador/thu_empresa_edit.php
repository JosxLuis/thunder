<?php
	if(isset($_POST['eliminar-foto']) && $_POST['eliminar-foto'] != ""){
		$logotipo = devolverValorQuery("SELECT logotipo FROM ".DB_PREFIJO."empresa WHERE id".DB_PREFIJO."empresa=".$_GET['id']." ");
		if($logotipo['logotipo'] != ""){
    		unlink("../".$logotipo['logotipo']);
		}
		$borrarEntrada = "UPDATE ".DB_PREFIJO."empresa SET logotipo = '' WHERE id".DB_PREFIJO."empresa= ".$_GET['id']."";
		mysqli_query($conexion,$borrarEntrada) or die(mysql_error());
		$curpage = curPageURL();
		header("Location:".$curpage);
	}

	$fotografia = "";

	if(isset($_POST['editar']) && $_POST['nombre'] != ""){
		$fecha = date('Y-m-d H:i:s');

		if($_FILES['imagen']['name'] != null){
			$anio = date('Y');
			$mes = date('m');

			require_once('image_resize.php');
			$dir = "img/media/".$anio."/".$mes."/";
			$max_file = 3;
			$upload_dir = "../img/media/".$anio."/".$mes."/";
			$allowed_image_types = array('image/jpeg'=>"jpeg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png");
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
				$normal->resize(600, "width");
				$normal->save($image_normal, 90);
				
				unlink($original_location);

				$logotipo = devolverValorQuery("SELECT logotipo FROM ".DB_PREFIJO."empresa WHERE id".DB_PREFIJO."empresa=".$_GET['id']." ");
				if($logotipo['logotipo'] != "" && $logotipo['logotipo'] != "img/no-picture.jpg"){
		    		unlink("../".$logotipo['logotipo']);
				}
		
				$ruta_image_normal = $dir."imagen_".$random.".".$file_ext;

				$fotografia = "logotipo='".$ruta_image_normal."', ";

			}
		}


		$editarRegistro = "UPDATE ".DB_PREFIJO."empresa SET $fotografia logotipo='".utf8_decode($_POST['logotipo'])."',apellidos='".utf8_decode($_POST['apellidos'])."',puesto='".utf8_decode($_POST['puesto'])."',facebook='".utf8_decode($_POST['facebook'])."',twitter='".utf8_decode($_POST['twitter'])."',instagram='".utf8_decode($_POST['instagram'])."',correo='".utf8_decode($_POST['correo'])."' WHERE id".DB_PREFIJO."empresa=".$_GET['id']." ";
		//echo $editarRegistro; exit();
		mysqli_query($conexion,$editarRegistro) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El registro ha sido guardado con éxito";

	}

	$proyecto = "SELECT * FROM ".DB_PREFIJO."nombre";
	$resProyecto = mysqli_query($conexion,$proyecto);

	$consulta = devolverValorQuery("SELECT *, date_format(fecha_ingreso,'%Y-%m-%d') as fecha_ingreso FROM ".DB_PREFIJO."empresa WHERE id".DB_PREFIJO."empresa=".$_GET['id']." ");

	//Un comentario para que se modifique el archivo


?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Empresa - <?php echo PROYECTO; ?></title>
	<!-- Metas  Especificas para  mobiles -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>js/datetime/datetimepicker.css">

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
					<div class="titulo">
						<h4>Editar equipo</h4>
					</div>
			        <div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
			        		<label for="foto">logotipo</label>
			        		<div class="mintext">Si no seleccionas otra imagen se conserva la imagen anterior</div>
			    			<input type="file" name="imagen">
			        		<label for="nombre">Nombre <span>*</span></label>
			        		<input type="text" name="nombre" placeholder="Nombres" value="<?php echo utf8_encode($consulta['nombre']); ?>" required>
			        		<label for="apellidos">apellidos <span>*</span></label>
			        		<input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo utf8_encode($consulta['apellidos']); ?>" required>
			        		<label for="fecha de ingreso">fecha de ingreso <span>*</span></label>
			        		<input  type="text" name="fecha_ingreso" placeholder="ej: YYYY-MM-DD" value="<?php echo utf8_encode($consulta['fecha_ingreso']); ?>" required>
			        		<label for="puesto">puesto <span>*</span></label>
			        		<input type="text" name="puesto" value="<?php echo utf8_encode($consulta['puesto']); ?>" placeholder="puesto">
			        		<label for="correo">correo <span>*</span></label>
			        		<input type="text" name="correo" placeholder="ej: micorreo@thundertechnology.mx" value="<?php echo utf8_encode($consulta['correo']); ?>" required>
			        		<label for="facebook">facebook</label>
			        		<input type="text" name="facebook" value="<?php echo utf8_encode($consulta['facebook']); ?>" placeholder="facebook">
							<label for="twitter">twitter</label>
			        		<input type="text" name="twitter" value="<?php echo utf8_encode($consulta['twitter']); ?>" placeholder="twitter">
			        		<label for="instagram">instagram</label>
			        		<input type="text" name="instagram" value="<?php echo utf8_encode($consulta['instagram']); ?>" placeholder="instagram">
			    			<label for="requerido" class="req"><span>*</span> campos requeridos</label>
			        		<input type="submit" name="editar" value="Guardar">
			        	</form>
			        </div>
			    </div>
	    	</div>
	    	<div class="six columns">
				<div class="list-items">
					<div class="form-add">
						<div class="foto-perfil">
						<label for="logotipo">Foto de perfil</label>
		        		<?php if($consulta['logotipo'] != ""){ ?>
	        				<div class="foto" style="background:url(<?php echo URL.$consulta['logotipo']; ?>)"></div>
	        				<div class="eliminar-foto">
		        				<form name="form2" action="" method="post">
		        					<input type="submit" class="delete" name="eliminar-foto" value="Eliminar Fotografía" class="confirm" title="¿Está seguro de borrar la fotografía?">
		        				</form>
		        			</div>
		        			
		        		<?php } ?>
		        		</div>
					</div>
				</div>
			</div>
	</div>
	<?php require_once(PREFIJO.'footer.php'); ?>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/default.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/datetime/datetimepicker.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {

			$('.default_datetimepicker').datetimepicker({
				timepicker:false,
				format: 'Y-m-d',
				lang:'es',
				scrollInput:false
		 });

		$("#marca").change(function(){
	        if (this.value != "") {
	            $.ajax({
	                type: "POST",
	                url: "<?php echo ADMINURL;?>buscar-categoria/",
	                //url: "http://www.ampacet.mx/buscar-ciudad/",
	                data: {
	                    'search_marca' : this.value
	                },
	                dataType: "html",
	                success: function(html){
	                    $("#categoria").html(html);
	                }
	            });
	            /*$("#subcategoria").removeAttr("disabled");
	            $("#subcategoria").attr("required","required");*/
	        }else{
	        	/*$("#subcategoria").removeAttr("required");
	            $("#subcategoria").attr("disabled","disabled");*/
	        }
    	});

		$("#categoria").change(function(){
	        if (this.value != "") {
	            $.ajax({
	                type: "POST",
	                url: "<?php echo ADMINURL;?>buscar-subcategoria/",
	                //url: "http://www.ampacet.mx/buscar-ciudad/",
	                data: {
	                    'search_categoria' : this.value
	                },
	                dataType: "html",
	                success: function(html){
	                    $("#subcategoria").html(html);
	                }
	            });
	            /*$("#subcategoria").removeAttr("disabled");
	            $("#subcategoria").attr("required","required");*/
	        }else{
	        	/*$("#subcategoria").removeAttr("required");
	            $("#subcategoria").attr("disabled","disabled");*/
	        }
    	});
		
	});
	</script>
</body>
</html>