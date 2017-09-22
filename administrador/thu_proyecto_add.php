<?php
	if(isset($_POST['proyecto_tipo']) && $_POST['proyecto_tipo'] != ""){
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
		
				$ruta_image_normal = $dir."imagen_".$random.".".$file_ext;

				$fotografia = $ruta_image_normal;

			}else{
				$fotografia = '';
			}
		}else{
			$fotografia = '';
		}


		$insertarRegistro = "INSERT INTO ".DB_PREFIJO."proyecto(id".DB_PREFIJO."proyecto, id".DB_PREFIJO."administrador, id".DB_PREFIJO."proyecto_tipo, id".DB_PREFIJO."proyecto_status, id".DB_PREFIJO."empresa, portada,nombre, introduccion, descripcion, fecha_inicio, fecha_termino, tags, creado) VALUES (0,".$_SESSION[PREFIJO.'idadmin'].",".$_POST['proyecto_tipo'].",".$_POST['proyecto_status'].",".$_POST['empresa'].",'".$fotografia."','".utf8_decode($_POST['nombre'])."','".utf8_decode($_POST['introduccion'])."','".utf8_decode($_POST['descripcion'])."','".utf8_decode($_POST['fecha_inicio'])."','".utf8_decode($_POST['fecha_termino'])."','".utf8_decode($_POST['tags'])."','".$fecha."')";

		//echo $insertarRegistro; exit();
		mysqli_query($conexion,$insertarRegistro) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El registro ha sido guardado con éxito";

	}

	
	$proyectoTipo = "SELECT * FROM ".DB_PREFIJO."proyecto_tipo";
	$resProyectoTipo = mysqli_query($conexion,$proyectoTipo);

	$proyectoStatus = "SELECT * FROM ".DB_PREFIJO."proyecto_status";
	$resProyectoStatus = mysqli_query($conexion,$proyectoStatus);

	$empresa = "SELECT * FROM ".DB_PREFIJO."empresa";
	$resEmpresa = mysqli_query($conexion,$empresa);



?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>proyectos - <?php echo PROYECTO; ?></title>
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
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Proyectos - <?php echo PROYECTO; ?></title>
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
						<h4>Nuevo Proyecto</h4>
					</div>
			        <div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
			        		<label for="marca">Tipo de proyecto <span>*</span></label>
							<select name="proyecto_tipo" required>
								<option value="">Elegir</option>
								<?php while($rowProyectoTipo = mysqli_fetch_array($resProyectoTipo)){ ?>
									<option value="<?php echo $rowProyectoTipo['id'.DB_PREFIJO.'proyecto_tipo']; ?>"><?php echo utf8_encode($rowProyectoTipo['nombre']); ?></option>
								<?php } ?>
							</select>
							<label for="marca">Estatus del proyecto <span>*</span></label>
							<select name="proyecto_status" required>
								<?php while($rowProyectoStatus = mysqli_fetch_array($resProyectoStatus)){ ?>
									<option value="<?php echo $rowProyectoStatus['id'.DB_PREFIJO.'proyecto_status']; ?>"><?php echo utf8_encode($rowProyectoStatus['nombre']); ?></option>
								<?php } ?>
							</select>
							<label for="marca">Empresa <span>*</span></label>
							<select name="empresa" required>
								<option value="">Elegir</option>
								<?php while($rowEmpresa = mysqli_fetch_array($resEmpresa)){ ?>
									<option value="<?php echo $rowEmpresa['id'.DB_PREFIJO.'empresa']; ?>"><?php echo utf8_encode($rowEmpresa['razon_social']); ?></option>
								<?php } ?>
							</select>
			        		<label for="foto">Portada</label>
			    			<input type="file" name="imagen">
			        		<label for="nombre">Nombre <span>*</span></label>
			        		<input type="text" name="nombre" placeholder="Nombre del proyecto"  required>
			        		<label for="condicion">Introducción</label>
			        		<input type="text" name="introduccion" placeholder="Máx 200 caractéres" maxlength="200"  required>
			        		<label for="descripcion">Descripcion</label>
			        		<textarea  name="descripcion" placeholder="Descripción"></textarea>
			        		<label for="fechaInicio">Iniciado</label>
			        		<input type="text" name="fecha_inicio" readonly="readonly" placeholder="YYYY-MM-DD" required class="default_datetimepicker">
			        		<label for="fechaInicio">Finalizado</label>
			        		<input type="text" name="fecha_termino" readonly="readonly" placeholder="YYYY-MM-DD" required class="default_datetimepicker">
			        		<label for="condicion">Etiquetas</label>
			        		<input type="text" name="tags" placeholder="Separados por coma" maxlength="200"  required>
			    			<label for="requerido" class="req"><span>*</span> campos requeridos</label>
			        		<input type="submit" name="editar" value="Guardar">
			        	</form>
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