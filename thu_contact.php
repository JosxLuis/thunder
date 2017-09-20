<?php
	if(isset($_POST['nombre']) && $_POST['nombre'] != ""){
		$mensaje = "
		<!doctype html>
		<html>
		  <head>
		    <meta name=\"viewport\" content=\"width=device-width\" />
		    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		    <title>Simple Transactional Email</title>
		    <style>
		      /* -------------------------------------
		          GLOBAL RESETS
		      ------------------------------------- */
		      img {
		        border: none;
		        -ms-interpolation-mode: bicubic;
		        max-width: 100%; }

		      body {
		        background-color: #f6f6f6;
		        font-family: sans-serif;
		        -webkit-font-smoothing: antialiased;
		        font-size: 14px;
		        line-height: 1.4;
		        margin: 0;
		        padding: 0; 
		        -ms-text-size-adjust: 100%;
		        -webkit-text-size-adjust: 100%; }

		      table {
		        border-collapse: separate;
		        mso-table-lspace: 0pt;
		        mso-table-rspace: 0pt;
		        width: 100%; }
		        table td {
		          font-family: sans-serif;
		          font-size: 14px;
		          vertical-align: top; }

		      /* -------------------------------------
		          BODY & CONTAINER
		      ------------------------------------- */

		      .body {
		        background-color: #f6f6f6;
		        width: 100%; }

		      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		      .container {
		        display: block;
		        Margin: 0 auto !important;
		        /* makes it centered */
		        max-width: 580px;
		        padding: 10px;
		        width: 580px; }

		      /* This should also be a block element, so that it will fill 100% of the .container */
		      .content {
		        box-sizing: border-box;
		        display: block;
		        Margin: 0 auto;
		        max-width: 580px;
		        padding: 10px; }

		      /* -------------------------------------
		          HEADER, FOOTER, MAIN
		      ------------------------------------- */
		      .main {
		        background: #fff;
		        border-radius: 3px;
		        width: 100%; }

		      .wrapper {
		        box-sizing: border-box;
		        padding: 20px; }

		      .footer {
		        clear: both;
		        padding-top: 10px;
		        text-align: center;
		        width: 100%; }
		        .footer td,
		        .footer p,
		        .footer span,
		        .footer a {
		          color: #999999;
		          font-size: 12px;
		          text-align: center; }

		      /* -------------------------------------
		          TYPOGRAPHY
		      ------------------------------------- */
		      h1,
		      h2,
		      h3,
		      h4 {
		        color: #000000;
		        font-family: sans-serif;
		        font-weight: 400;
		        line-height: 1.4;
		        margin: 0;
		        Margin-bottom: 30px; }

		      h1 {
		        font-size: 35px;
		        font-weight: 300;
		        text-align: center;
		        text-transform: capitalize; }

		      p,
		      ul,
		      ol {
		        font-family: sans-serif;
		        font-size: 14px;
		        font-weight: normal;
		        margin: 0;
		        Margin-bottom: 15px; }
		        p li,
		        ul li,
		        ol li {
		          list-style-position: inside;
		          margin-left: 5px; }

		      a {
		        color: #3498db;
		        text-decoration: underline; }

		      /* -------------------------------------
		          BUTTONS
		      ------------------------------------- */
		      .btn {
		        box-sizing: border-box;
		        width: 100%; }
		        .btn > tbody > tr > td {
		          padding-bottom: 15px; }
		        .btn table {
		          width: auto; }
		        .btn table td {
		          background-color: #ffffff;
		          border-radius: 5px;
		          text-align: center; }
		        .btn a {
		          background-color: #ffffff;
		          border: solid 1px #3498db;
		          border-radius: 5px;
		          box-sizing: border-box;
		          color: #3498db;
		          cursor: pointer;
		          display: inline-block;
		          font-size: 14px;
		          font-weight: bold;
		          margin: 0;
		          padding: 12px 25px;
		          text-decoration: none;
		          text-transform: capitalize; }

		      .btn-primary table td {
		        background-color: #3498db; }

		      .btn-primary a {
		        background-color: #3498db;
		        border-color: #3498db;
		        color: #ffffff; }

		      /* -------------------------------------
		          OTHER STYLES THAT MIGHT BE USEFUL
		      ------------------------------------- */
		      .last {
		        margin-bottom: 0; }

		      .first {
		        margin-top: 0; }

		      .align-center {
		        text-align: center; }

		      .align-right {
		        text-align: right; }

		      .align-left {
		        text-align: left; }

		      .clear {
		        clear: both; }

		      .mt0 {
		        margin-top: 0; }

		      .mb0 {
		        margin-bottom: 0; }

		      .preheader {
		        color: transparent;
		        display: none;
		        height: 0;
		        max-height: 0;
		        max-width: 0;
		        opacity: 0;
		        overflow: hidden;
		        mso-hide: all;
		        visibility: hidden;
		        width: 0; }

		      .powered-by a {
		        text-decoration: none; }

		      hr {
		        border: 0;
		        border-bottom: 1px solid #f6f6f6;
		        Margin: 20px 0; }

		      /* -------------------------------------
		          RESPONSIVE AND MOBILE FRIENDLY STYLES
		      ------------------------------------- */
		      @media only screen and (max-width: 620px) {
		        table[class=body] h1 {
		          font-size: 28px !important;
		          margin-bottom: 10px !important; }
		        table[class=body] p,
		        table[class=body] ul,
		        table[class=body] ol,
		        table[class=body] td,
		        table[class=body] span,
		        table[class=body] a {
		          font-size: 16px !important; }
		        table[class=body] .wrapper,
		        table[class=body] .article {
		          padding: 10px !important; }
		        table[class=body] .content {
		          padding: 0 !important; }
		        table[class=body] .container {
		          padding: 0 !important;
		          width: 100% !important; }
		        table[class=body] .main {
		          border-left-width: 0 !important;
		          border-radius: 0 !important;
		          border-right-width: 0 !important; }
		        table[class=body] .btn table {
		          width: 100% !important; }
		        table[class=body] .btn a {
		          width: 100% !important; }
		        table[class=body] .img-responsive {
		          height: auto !important;
		          max-width: 100% !important;
		          width: auto !important; }}

		      /* -------------------------------------
		          PRESERVE THESE STYLES IN THE HEAD
		      ------------------------------------- */
		      @media all {
		        .ExternalClass {
		          width: 100%; }
		        .ExternalClass,
		        .ExternalClass p,
		        .ExternalClass span,
		        .ExternalClass font,
		        .ExternalClass td,
		        .ExternalClass div {
		          line-height: 100%; }
		        .apple-link a {
		          color: inherit !important;
		          font-family: inherit !important;
		          font-size: inherit !important;
		          font-weight: inherit !important;
		          line-height: inherit !important;
		          text-decoration: none !important; } 
		        .btn-primary table td:hover {
		          background-color: #34495e !important; }
		        .btn-primary a:hover {
		          background-color: #34495e !important;
		          border-color: #34495e !important; } }

		    </style>
		  </head>
		  <body class=\"\">
		    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\">
		      <tr>
		        <td>&nbsp;</td>
		        <td class=\"container\">
		          <div class=\"content\">

		            <!-- START CENTERED WHITE CONTAINER -->
		            <span class=\"preheader\">Tenemos un nuevo mensaje de contacto en el sitio.</span>
		            <table class=\"main\">

		              <!-- START MAIN CONTENT AREA -->
		              <tr>
		                <td class=\"wrapper\">
		                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
		                  	<tr>
		                  		<td><img src=\"\"</td>
		                  	</tr>
		                    <tr>
		                      <td>
		                        <p>El visitante ".utf8_encode($_POST['nombre'])." envió un mensaje de contacto.</p>
		                        <p>Mensaje: ".utf8_encode($_POST['mensaje'])."</p>
		                        <p>Teléfono: ".utf8_encode($_POST['telefono'])."</p>
		                        <p>Correo: ".utf8_encode($_POST['correo'])."</p>
		                        <p>".PROYECTO."</p>
		                      </td>
		                    </tr>
		                  </table>
		                </td>
		              </tr>

		              <!-- END MAIN CONTENT AREA -->
		              </table>

		            <!-- START FOOTER -->
		            <div class=\"footer\">
		              <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
		                <tr>
		                  <td class=\"content-block\">
		                    <span class=\"apple-link\">".PROYECTO." - 2017</span>
		                    <br> ¿No quieres volver a recibir mensajes de nosotros? <a href=\"#\">Cancelar la suscripción</a>.
		                  </td>
		                </tr>
		                <tr>
		                  <td class=\"content-block powered-by\">
		                    Powered by <a href=\"#\">".PROYECTO."</a>.
		                  </td>
		                </tr>
		              </table>
		            </div>

		            <!-- END FOOTER -->
		            
		<!-- END CENTERED WHITE CONTAINER --></div>
		        </td>
		        <td>&nbsp;</td>
		      </tr>
		    </table>
		  </body>
		</html>";

		$envio = enviar_correo("contacto@sauberpl.mx","Sabuer Productos de Limpieza","Nuevo mensaje de contacto de ".PROYECTO.".",$mensaje);

		$status = substr($envio, 0,1);
		$mensaje = substr($envio, 2);
		

	}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
	<title>Contacto - Sauber</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo URL; ?>img/favicon.png">
	<link rel="apple-touch-icon" href="<?php echo URL; ?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>img/apple-touch-icon-114x114.png">

	<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>css/layout.css">
	
</head>
<body>
<?php include(PREFIJO.'header.php'); ?>
<div class="section sec-grad-blue mh-200 overh">
	<div class="container">
		<div class="seven columns">
			<div class="box pd-ver-20">
				<br>
				<h3 class="col-white">¿Necesitas información?</h3>
				<p class="col-white">Resuelve todas tus dudas fácilmente, solo tienes que ingresar tus datos y tus dudas en el formulario de abajo y te responderemos en breve.</p>
			</div>
		</div>
		<div class="nine columns relative">
			<div class="box ">
				<div class="contact-imagen"></div>
			</div>
		</div>
	</div>
</div>
<div class="section sec-white">
	<div class="container">
	
		<div class="sixteen columns">
			<div class="navegacion">
				<ul>
					<li><a href="#">Inicio</a></li>
					<li class="separador">/</li>
					<li>Contacto</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>		
	
		<div class="sixteen columns">
			<h3 class="col-green">Contacto</h3>
			<p>Si tienes alguna duda, necesitas más información o darnos algún comentario puedes escribirnos en el siguiente formulario</p>
				<?php if(isset($status) && $status == 1){ ?>
					<div class="alert alert-success">
						<i class="icon-success"></i> <?php echo $mensaje; ?>
					</div>
				<?php } ?>
				<?php if(isset($status) && $status == 0){ ?>
					<div class="alert alert-error">
						<i class="icon-error"></i> <?php echo $mensaje; ?>
					</div>
				<?php } ?>
		</div>
		<div class="row"></div>
		<div class="ten columns">
			<div class="box">
				<div class="">
					
					<form action="" method="post">
						<label for="label1">Nombre Completo:</label>
						<input type="text" name="nombre" class="" placeholder="Nombre Completo" required>
						
						<div class="box-half f-left">
							<label for="doble">Correo:</label>
							<div class="pd-right-2">
								<input type="text" name="correo" class="" placeholder="Direccion de correo válida" required 
								pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Escribe una dirección de correo válida Ej. micorreo@gmail.com">
							</div>
						</div>
						<div class="box-half f-left">
							<label for="doble">Teléfono:</label>
							<div class="pd-left-2">
								<input type="text" name="telefono" class="" placeholder="Numero de diez digitos" required>
							</div>
						</div>
						<label for="textarea">Escriba</label>
						<textarea name="mensaje" id="" cols="30" rows="10" placeholder="Escribe tu mensaje" required></textarea>

					<input type="submit" name="enviar" value="Enviar" class="btn btn-big btn-blue btn-inli">	
					</form>
				</div>
			</div>
		</div>
		
		<div class="six columns mh-500">
			<div class="box pd-all-5">
					<h5>Dirección:</h5>
					<p>Avenida Frontera Comalapa No. 160 Fracc. Las Torres</p>
					<br>
					<h5>Teléfono:</h5>
					<p>(961) 614 3988</p>
					<br>
					<h5>Corréo:</h5>
					<p>venta.j3@gmail.com</p>
			</div>
			<div class="box">
				 <div id="map-canvas"></div>
			</div>
		</div>
	

	</div>
</div>
<div class="section sec-blue pd-30">
	<div class="container">
		<div class="ten columns">
			<div class="box pd-30">
				<h3 class="col-white no-mar-bo">¿Tienes dudas respecto a nuestros servicios o nuestros paquetes? contáctanos</h3>
			</div>
		</div>
		<div class="six columns">
			<div class="box pd-30">
				<a href="" class="btn abtn btn-default btn-big btn-white-out btn-center">Contáctanos</a>
			</div>
		</div>
	</div>
</div>
<?php include(PREFIJO.'footer.php'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAt2dF6ir_paylmj1vGAc4SNI184ML0-I0&amp;sensor=false"></script>
<script src="<?php echo URL; ?>js/mapa.js"></script>
<script>
	$(document).ready(function(){        
        initialize();
	});
</script>
    

</body>
</html>