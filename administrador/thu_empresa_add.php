<?php
	if(isset($_POST['razon_social']) && $_POST['razon_social'] != ""){
		$fecha = date('Y-m-d H:i:s');
		$fotografia = '';

		if($_FILES['imagen']['name'] != null){
			$anio = date('Y');
			$mes = date('m');

			require_once('image_resize.php');
			$dir = "img/media/".$anio."/".$mes."/";
			$max_file = 3;
			$upload_dir = "../img/media/".$anio."/".$mes."/";
			$allowed_image_types = array('image/jpeg'=>"jpeg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg");
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

			}
		}
//".$_SESSION[PREFIJO.'usuario']."


		$insertarRegistro = "INSERT INTO ".DB_PREFIJO."empresa(id".DB_PREFIJO."empresa,id".DB_PREFIJO."usuario,logotipo,razon_social,rfc,direccion,colonia,codigo_postal,ciudad,estado,responsable,puesto,correo,telefono,creado) 
		VALUES (0,".$_POST['usuario'].",'".$fotografia."','".utf8_decode($_POST['razon_social'])."','".utf8_decode($_POST['rfc'])."','".utf8_decode($_POST['direccion'])."','".utf8_decode($_POST['colonia'])."','".utf8_decode($_POST['codigo_postal'])."',
		'".utf8_decode($_POST['ciudad'])."','".utf8_decode($_POST['estado'])."','".utf8_decode($_POST['responsable'])."','".utf8_decode($_POST['puesto'])."','".utf8_decode($_POST['correo'])."','".utf8_decode($_POST['telefono'])."','".$fecha."')";
		//echo $insertarRegistro; exit();
		mysqli_query($conexion,$insertarRegistro) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El registro ha sido guardado con éxito";

	}

	$usuarios = "SELECT * FROM ".DB_PREFIJO."usuario";
	$resUsuarios = mysqli_query($conexion,$usuarios);

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
						<h4>Nueva empresa</h4>
					</div>
			        <div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
			        		<label for="foto">Logotipo</label>
			    			<input type="file" name="imagen">
			        		<label for="razon social">razon social <span>*</span></label>
			        		<input type="text" name="razon_social" required>
			        		<label for="rfc">rfc <span>*</span></label>
			        		<input type="text" name="rfc" placeholder="rfc" required>
			        		<label for="direccion">direccion <span>*</span></label>
			        		<input  type="text" name="direccion" required>
			        		<label for="colonia">colonia <span>*</span></label>
			        		<input type="text" name="colonia" placeholder="colonia" required>
			        		<label for="codigo postal">codigo postal <span>*</span></label>
			        		<input type="text" name="codigo_postal" required required>
			        		<label for="ciudad">ciudad</label>
			        		<input type="text" name="ciudad" placeholder="ciudad" required>
							<label for="estado">estado</label>
			        		<input type="text" name="estado" placeholder="estado" required>
			        		<label for="responsable">responsable</label>
			        		<input type="text" name="responsable" placeholder="Nombre del responsable" required>
			        		<label for="puesto">puesto</label>
			        		<input type="text" name="puesto" placeholder="puesto" required>
			        		<label for="correo">correo</label>
			        		<input type="text" name="correo" placeholder="correo">
			        		<label for="telefono">telefono</label>
			        		<input type="text" name="telefono" placeholder="telefono" required>			
			        		<label for="usuario">Usuario</label>
			        		<select name="usuario" required>
			        			<option value="">Elegir</option>
			        			<?php while($rowUsuario = mysqli_fetch_array($resUsuarios)){ ?>
			        			<option value="<?php echo $rowUsuario['id'.DB_PREFIJO.'usuario']; ?>"><?php echo $rowUsuario['correo']; ?></option>
			        			<?php } ?>
			        		</select>		  
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