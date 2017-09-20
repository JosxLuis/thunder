<?php
	if(isset($_POST['eliminar-foto']) && $_POST['eliminar-foto'] != ""){
		$portada = devolverValorQuery("SELECT portada FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."producto=".$_GET['id']." ");
		if($portada['portada'] != ""){
    		unlink("../".$portada['portada']);
		}
		$borrarEntrada = "UPDATE ".DB_PREFIJO."producto SET portada = '' WHERE id".DB_PREFIJO."producto= ".$_GET['id']."";
		mysqli_query($conexion,$borrarEntrada) or die(mysql_error());
		$curpage = curPageURL();
		header("Location:".$curpage);
	}

	if(isset($_POST['editar']) && $_POST['marca'] != ""){
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

				$portada = devolverValorQuery("SELECT portada FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."producto=".$_GET['id']." ");
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


		$editarRegistro = "UPDATE ".DB_PREFIJO."producto SET $fotografia id".DB_PREFIJO."categoria=".$_POST['subcategoria'].",clave='".utf8_decode($_POST['clave'])."',nombre='".utf8_decode($_POST['nombre'])."',descripcion='".utf8_decode($_POST['descripcion'])."',condicion='".utf8_decode($_POST['condicion'])."' WHERE id".DB_PREFIJO."producto=".$_GET['id']." ";
		//echo $editarRegistro; exit();
		mysqli_query($conexion,$editarRegistro) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El registro ha sido guardado con éxito";

	}

	$marcas = "SELECT * FROM ".DB_PREFIJO."marca";
	$resMarcas = mysqli_query($conexion,$marcas);

	$consulta = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."producto=".$_GET['id']." ");

	$consultaMarca = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."marca WHERE id".DB_PREFIJO."marca = (SELECT id".DB_PREFIJO."marca FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."categoria=".$consulta['id'.PREFIJO.'categoria'].")");

	$categoriaHijo = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."categoria=".$consulta['id'.PREFIJO.'categoria']." ");

	$categoriaPadre = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."categoria=".$categoriaHijo['parentid']." ");

	$categorias = "SELECT * FROM ".DB_PREFIJO."categoria WHERE parentid IS NULL AND id".DB_PREFIJO."marca =".$consultaMarca['id'.DB_PREFIJO.'marca']." ";
	$resCategorias = mysqli_query($conexion,$categorias);

	$subcategorias = "SELECT * FROM ".DB_PREFIJO."categoria WHERE parentid=".$categoriaPadre['id'.DB_PREFIJO.'categoria']." ";
	$resSubCategorias = mysqli_query($conexion,$subcategorias);


?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Productos - <?php echo PROYECTO; ?></title>
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
						<h4>Editar Producto</h4>
					</div>
			        <div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
			        		<label for="marca">Marca <span>*</span></label>
							<select name="marca" id="marca" required>
								<option value="<?php echo $consultaMarca['id'.DB_PREFIJO.'marca']; ?>"><?php echo utf8_encode($consultaMarca['nombre']); ?></option>
								<?php while($rowMarca = mysqli_fetch_array($resMarcas)){ ?>
									<option value="<?php echo $rowMarca['id'.DB_PREFIJO.'marca']; ?>"><?php echo utf8_encode($rowMarca['nombre']); ?></option>
								<?php } ?>
							</select>
							<label for="categoria">Categoría</label>
			        		<select name="categoria" id="categoria" required>
			        			<option value="<?php echo $categoriaPadre['id'.DB_PREFIJO.'categoria']; ?>"><?php echo utf8_encode(mostrarNombreCategoria($categoriaPadre['id'.DB_PREFIJO.'categoria'])); ?></option>
			        			<?php while($rowCategoria = mysqli_fetch_array($resCategorias)){ ?>
			        			<option value="<?php echo $rowCategoria['id'.DB_PREFIJO.'categoria']; ?>"><?php echo utf8_encode($rowCategoria['nombre']); ?></option>
			        			<?php } ?>
			        		</select>
			        		<label for="subcategoria">Subcategoría</label>
							<select name="subcategoria" id="subcategoria" required>
					        	<option value="<?php echo $categoriaHijo['id'.DB_PREFIJO.'categoria']; ?>"><?php echo utf8_encode(mostrarNombreCategoria($categoriaHijo['id'.DB_PREFIJO.'categoria'])); ?></option>
					        	<?php while($rowSubCategoria = mysqli_fetch_array($resSubCategorias)){ ?>
			        			<option value="<?php echo $rowSubCategoria['id'.DB_PREFIJO.'categoria']; ?>"><?php echo utf8_encode($rowSubCategoria['nombre']); ?></option>
			        			<?php } ?>
					        </select>
			        		<label for="foto">Fotografía</label>
			        		<div class="mintext">Si no seleccionas otra imagen se conserva la imagen anterior</div>
			    			<input type="file" name="imagen">
			    			<label for="clave">Clave <span>*</span></label>
			        		<input type="text" name="clave" value="<?php echo utf8_encode($consulta['clave']); ?>" placeholder="Clave del producto" required>
			        		<label for="nombre">Nombre <span>*</span></label>
			        		<textarea name="nombre"><?php echo utf8_encode($consulta['nombre']); ?>"</textarea>
			        		<label for="descripcion">Descripcion</label>
			        		<textarea  name="descripcion" placeholder="Descripción"><?php echo utf8_encode($consulta['descripcion']); ?></textarea>
			        		<label for="condicion">Condición</label>
			        		<input type="text" name="condicion" value="<?php echo utf8_encode($consulta['condicion']); ?>" placeholder="Ej. Nuevo" required>
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