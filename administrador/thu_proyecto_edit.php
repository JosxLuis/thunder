<?php
	if(isset($_POST['eliminar-foto']) && $_POST['eliminar-foto'] != ""){
		$portada = devolverValorQuery("SELECT portada FROM ".DB_PREFIJO."proyecto WHERE id".DB_PREFIJO."proyecto=".$_GET['id']." ");
		if($portada['portada'] != ""){
    		unlink("../".$portada['portada']);
		}
		$borrarEntrada = "UPDATE ".DB_PREFIJO."proyecto SET portada = '' WHERE id".DB_PREFIJO."proyecto= ".$_GET['id']."";
		mysqli_query($conexion,$borrarEntrada) or die(mysql_error());
		$curpage = curPageURL();
		header("Location:".$curpage);
	}

	if(isset($_POST['editar']) && $_POST['proyecto_tipo'] != ""){
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

				$portada = devolverValorQuery("SELECT portada FROM ".DB_PREFIJO."proyecto WHERE id".DB_PREFIJO."proyecto=".$_GET['id']." ");
				if($portada['portada'] != "" && $portada['portada'] != "img/no-picture.jpg"){
		    		unlink("../".$portada['portada']);
				}
		
				$ruta_image_normal = $dir."imagen_".$random.".".$file_ext;

				$fotografia = "portada='".$ruta_image_normal."', ";

			}else{
				$fotografia = "";
			}
		}else{
			$fotografia = "";
		}


		$editarRegistro = "UPDATE ".DB_PREFIJO."proyecto SET $fotografia id".DB_PREFIJO."proyecto_tipo=".$_POST['proyecto_tipo'].", id".DB_PREFIJO."proyecto_status=".$_POST['proyecto_status'].", id".DB_PREFIJO."empresa=".$_POST['empresa'].", nombre='".utf8_decode($_POST['nombre'])."', introduccion='".utf8_decode($_POST['introduccion'])."',descripcion='".utf8_decode($_POST['descripcion'])."',fecha_inicio='".utf8_decode($_POST['fecha_inicio'])."',fecha_termino='".utf8_decode($_POST['fecha_termino'])."',tags='".utf8_decode($_POST['tags'])."' WHERE id".DB_PREFIJO."proyecto=".$_GET['id']." ";
		//echo $editarRegistro; exit();
		mysqli_query($conexion,$editarRegistro) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El registro ha sido guardado con éxito";

	}

	$proyecto = "SELECT * FROM ".DB_PREFIJO."proyecto_tipo";
	$resProyecto = mysqli_query($conexion,$proyecto);

	$proyectoStatus = "SELECT * FROM ".DB_PREFIJO."proyecto_status";
	$resProyectoStatus = mysqli_query($conexion,$proyectoStatus);

	$empresa = "SELECT * FROM ".DB_PREFIJO."empresa";
	$resEmpresa = mysqli_query($conexion,$empresa);


	$consulta = devolverValorQuery("SELECT *,date_format(fecha_inicio,'%Y-%m-%d') as fecha_inicio,date_format(fecha_termino,'%Y-%m-%d') as fecha_termino FROM ".DB_PREFIJO."proyecto WHERE id".DB_PREFIJO."proyecto=".$_GET['id']." ");


?>
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
						<h4>Editar Proyecto</h4>
					</div>
			        <div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
			        		<label for="marca">Tipo de proyecto <span>*</span></label>
							<select name="proyecto_tipo" id="marca" required>
								<option value="<?php echo $consulta['id'.DB_PREFIJO.'proyecto_tipo']; ?>"><?php echo utf8_encode(mostrarNombre($consulta['id'.DB_PREFIJO.'proyecto_tipo'],"proyecto_tipo","nombre")); ?></option>
								<?php while($rowProyecto = mysqli_fetch_array($resProyecto)){ ?>
									<option value="<?php echo $rowProyecto['id'.DB_PREFIJO.'proyecto_tipo']; ?>"><?php echo utf8_encode($rowProyecto['nombre']); ?></option>
								<?php } ?>
							</select>
							<label for="marca">Estatus del proyecto <span>*</span></label>
							<select name="proyecto_status" required>
								<option value="<?php echo $consulta['id'.DB_PREFIJO.'proyecto_status']; ?>"><?php echo utf8_encode(mostrarNombre($consulta['id'.DB_PREFIJO.'proyecto_status'],"proyecto_status","nombre")); ?></option>
								<?php while($rowProyectoStatus = mysqli_fetch_array($resProyectoStatus)){ ?>
									<option value="<?php echo $rowProyectoStatus['id'.DB_PREFIJO.'proyecto_status']; ?>"><?php echo utf8_encode($rowProyectoStatus['nombre']); ?></option>
								<?php } ?>
							</select>
							<label for="marca">Empresa <span>*</span></label>
							<select name="empresa" required>
								<option value="<?php echo $consulta['id'.DB_PREFIJO.'empresa']; ?>"><?php echo utf8_encode(mostrarNombre($consulta['id'.DB_PREFIJO.'empresa'],"empresa","razon_social")); ?>
								</option>
								<?php while($rowEmpresa = mysqli_fetch_array($resEmpresa)){ ?>
									<option value="<?php echo $rowEmpresa['id'.DB_PREFIJO.'empresa']; ?>"><?php echo utf8_encode($rowEmpresa['razon_social']); ?></option>
								<?php } ?>
							</select>
			        		<label for="foto">Portada</label>
			        		<div class="mintext">Si no seleccionas otra imagen se conserva la imagen anterior</div>
			    			<input type="file" name="imagen">
			        		<label for="nombre">Nombre <span>*</span></label>
			        		<input type="text" name="nombre" placeholder="Nombre del servicio" value="<?php echo utf8_encode($consulta['nombre']); ?>"  required>
			        		<label for="condicion">Introducción</label>
			        		<input type="text" name="introduccion" placeholder="Máx 200 caractéres" value="<?php echo utf8_encode($consulta['introduccion']); ?>" maxlength="200"  required>
			        		<label for="descripcion">Descripcion</label>
			        		<textarea  name="descripcion" placeholder="Descripción"><?php echo utf8_encode($consulta['descripcion']); ?></textarea>
			        		<label for="fechaInicio">Iniciado</label>
			        		<input type="text" name="fecha_inicio" readonly="readonly" placeholder="YYYY-MM-DD" value="<?php echo $consulta['fecha_inicio']; ?>" required class="default_datetimepicker">
			        		<label for="fechaInicio">Finalizado</label>
			        		<input type="text" name="fecha_termino" readonly="readonly" placeholder="YYYY-MM-DD" value="<?php echo $consulta['fecha_termino']; ?>" required class="default_datetimepicker">
			        		<label for="condicion">Etiquetas</label>
			        		<input type="text" name="tags" placeholder="Separados por coma" maxlength="200" value="<?php echo utf8_encode($consulta['tags']); ?>"  required>
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
						<label for="portada">Foto de perfil</label>
		        		<?php if($consulta['portada'] != ""){ ?>
	        				<div class="foto" style="background:url(<?php echo URL.$consulta['portada']; ?>)"></div>
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