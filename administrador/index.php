<?php
if(!session_start()){
session_start();
}
require_once('lib/config.php');
require_once('lib/mysql.php');
require_once('lib/pagination.php');
require_once('lib/funciones.php');

$checkanio = date('Y');
$checkmes = date('m');
$rutaYear = "../img/media/".$checkanio."/";
$rutaMonth = "../img/media/".$checkanio."/".$checkmes."/";
makeDir($rutaYear);
makeDir($rutaMonth);

if(isset($_SESSION[PREFIJO.'idadmin'])){
	
	if(isset($_GET['do'])){
		$ruta=$_GET['do'];
		switch($ruta){
			case "profile":
				include(PREFIJO.'perfil.php');
				break;
			case "usuarios":
				if(isset($_GET['act'])){
					switch(@$_GET['act']){
						case "nuevo":include(PREFIJO.'usuarios_add.php');
						break;
						case "editar":include(PREFIJO.'usuarios_edit.php');
						break;
						case "eliminar":include(PREFIJO.'usuarios.php');
						break;
					}
				}else{
					include(PREFIJO.'usuarios.php');
				}
			break;
			case "servicios":
				if(isset($_GET['act'])){
					switch(@$_GET['act']){
						case "nuevo":include(PREFIJO.'servicios_add.php');
						break;
						case "editar":include(PREFIJO.'servicios_edit.php');
						break;
						case "eliminar":include(PREFIJO.'servicios.php');
						break;
					}
				}else{
					include(PREFIJO.'servicios.php');
				}
			break;	
				case "portafolio":
				if(isset($_GET['act'])){
					switch(@$_GET['act']){
						case "nuevo":include(PREFIJO.'portafolio_add.php');
						break;
						case "editar":include(PREFIJO.'portafolio_edit.php');
						break;
						case "eliminar":include(PREFIJO.'portafolio.php');
						break;
					}
				}else{
					include(PREFIJO.'portafolio.php');
				}
			break;	
			case "slider":
				if(isset($_GET['act'])){
					switch(@$_GET['act']){
						case "nuevo":include(PREFIJO.'slider_add.php');
						break;
						case "editar":include(PREFIJO.'slider_edit.php');
						break;
						case "eliminar":include(PREFIJO.'slider.php');
						break;
					}
				}else{
					include(PREFIJO.'slider.php');
			    }
			break;
			case "users":
				if(isset($_GET['act'])){	
					switch(@$_GET['act']){
						case "nuevo":include(PREFIJO.'configuracion_usuarios_add.php');
						break;
						case "editar":include(PREFIJO.'configuracion_usuarios_edit.php');
						break;
						case "permisos":include(PREFIJO.'configuracion_usuarios_privileges.php');
						break;
						case "eliminar":include(PREFIJO.'configuracion_usuarios.php');
						break;
					}
				}else{
					include(PREFIJO.'configuracion_usuarios.php');
				}
			break;
			case "profile":
				include(PREFIJO.'profile.php');
				break;
			case "settings":
				include(PREFIJO.'settings.php');
				break;
			case "salir":
				include('logout.php');
				break;
			default: 
				include(PREFIJO.'main.php');
				break;
		}
		
	}
	else{
		include(PREFIJO.'main.php');
	}
	
}
else{
	include('login.php');
}
?>