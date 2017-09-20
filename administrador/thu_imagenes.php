<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Subir imágenes</title>
	<!-- Metas  Especificas para  mobiles -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/themes/blitzer/jquery.ui.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>js/uploadfile/uploadfile.css">

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
				<div class="list-items">
					<div class="titulo">
						<h4>Módulo de imágenes</h4>
						<p>&nbsp;</p>
					</div>
					<div id="multiplefileuploader">Subir Imagenes</div>
					<div id="status"></div>
				<br>
			</div>
		</div>
		<div class="clear"></div>
		
	</div>
	<?php require_once(PREFIJO.'footer.php'); ?>
	
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/default.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.ui.js"></script>
    <script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.confirm.js"></script>
    <script type="text/javascript" src="<?php echo ADMINURL; ?>js/uploadfile/uploadfile.min.js"></script>
	<script>
		$(document).ready(function()
		{
			var settings = {
			    url: "<?php echo ADMINURL.PREFIJO; ?>_ajax_upload_file.php",
			    dragDrop:true,
			    fileName: "myfile",
			    returnType:"json",
				 onSuccess:function(files,data,xhr)
			    {
			       location.reload();
			    },
			    showDelete:false,
			    deleteCallback: function(data,pd)
				{
			    for(var i=0;i<data.length;i++)
			    {
			        $.post("<?php echo ADMINURL; ?>sc_transparencia_ajax_delete_file.php",{op:"delete",name:data[i]},
			        function(resp, textStatus, jqXHR)
			        {
			            //Show Message  
			            $("#status").append("<div>File Deleted</div>");      
			        });
			     }      
			    pd.statusbar.hide(); //You choice to hide/not.

			}
		}
			var uploadObj = $("#multiplefileuploader").uploadFile(settings);
		});
</script>
    <script>
    	$(document).ready(function(){
    		$(".confirm").easyconfirm({locale: { title: 'Borrar publicacion', button: ['No','Sí']}});
    	});
    </script>
</body>
</html>