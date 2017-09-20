<?php
	require_once('lib/config.php');
	require_once('lib/funciones.php');

	if(isset($_GET['do'])){
		$ruta = $_GET['do'];
		switch ($ruta) {
			case 'empresa':
				include(PREFIJO.'about.php');
				break;
			case 'servicios':
				include(PREFIJO.'services.php');
				break;
			case 'portafolio':
				include(PREFIJO.'portfolio.php');
				break;
			case 'blog':
				include(PREFIJO.'blog.php');
				break;
			case 'planes':
				include(PREFIJO.'plans.php');
				break;
			case 'contacto':
				include(PREFIJO.'contact.php');
				break;
			case 'preguntas':
				include(PREFIJO.'faqs.php');
				break;
			case 'ayuda':
				include(PREFIJO.'help.php');
				break;
			case 'versiones':
				include(PREFIJO.'version.php');
				break;
			case 'privacidad':
				include(PREFIJO.'privacy.php');
				break;
			case 'terminos':
				include(PREFIJO.'terms.php');
				break;
			case 'soporte':
				include(PREFIJO.'support.php');
				break;
			case 'mapa-de-sitio':
				include(PREFIJO.'sitemap.php');
				break;
			case '404':
				include(PREFIJO.'404.php');
				break;
			default:
				include(PREFIJO.'main.php');
				break;
		}
	}else{
		include(PREFIJO.'main.php');
	}
?>