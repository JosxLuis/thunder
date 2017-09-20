<?php

function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function generateNickname($correo){
  $term_arroba = substr(strrchr ($correo, '@'),0);

  $longitud_correo = strlen($correo);
  $longitud_dominio = strlen($term_arroba);
  $diferencia = $longitud_correo-$longitud_dominio;

  $nickname = substr($correo, 0,$diferencia);
  return $nickname;
}

function mostrarStatusBoletin($id){
  switch ($id) {
    case '0':
      $status = "Borrador";
      break;
    case '1':
      $status = "Publicado";
      break;
    case '2':
      $status = "Papelera";
      break;
    default:
      $status = "Publicado";
      break;
    
  }
  return $status;
}

function mostrarNombreEstado($id){
  $nombre = devolverValorQuery("SELECT nombre FROM ".DB_PREFIJO."estado WHERE id".DB_PREFIJO."estado=".$id."");
  return $nombre['nombre'];
}

function mostrarNombreMarca($id){
  $nombre = devolverValorQuery("SELECT nombre FROM ".DB_PREFIJO."marca WHERE id".DB_PREFIJO."marca=".$id."");
  return $nombre['nombre'];
}

function mostrarNombreCategoria($id){
  $nombre = devolverValorQuery("SELECT nombre FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."categoria=".$id."");
  return $nombre['nombre'];
}

function mostrarProductoMarca($id){
  $nombre = devolverValorQuery("SELECT nombre FROM ".DB_PREFIJO."marca WHERE id".DB_PREFIJO."marca=(SELECT id".DB_PREFIJO."marca FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."categoria=".$id.")");
  return $nombre['nombre'];
}

function mostrarNombreTipoUsuario($id){
  $nombre = devolverValorQuery("SELECT nombre FROM ".DB_PREFIJO."administrador_rol WHERE id".DB_PREFIJO."administrador_rol=".$id."");
  return $nombre['nombre'];
}

function mostrarNombreActividadTipo($id){
  $nombre = devolverValorQuery("SELECT nombre FROM ".DB_PREFIJO."actividad_tipo WHERE id".DB_PREFIJO."actividad_tipo=".$id."");
  return $nombre['nombre'];
}

function mostrarSioNo($id){
  switch ($id) {
    case '0':
      $status = "No";
      break;
    case '1':
      $status = "Sí";
      break;
    default:
      $status = "-";
      break;
    
  }
  return $status;
}

function mostrarNombreDescuento($id){
   switch ($id) {
      case '0':
        $status = "No";
        break;
      case '1':
        $status = "Sí";
        break;
      default:
        $status = "-";
        break;
      
    }
    return $status;
}

function mostrarNombreSexo($id){
  switch ($id) {
    case 'M':
      $status = "Masculino";
      break;
    case 'F':
      $status = "Femenino";
      break;
    default:
      $status = "No definido";
      break;
    
  }
  return $status;
}

function mostrarPoststatus($id){
  switch ($id) {
    case '0':
      $status = "Borrador";
      break;
    case '1':
      $status = "Publicado";
      break;
    case '2':
      $status = "Papelera";
      break;
    default:
      $status = "Publicado";
      break;
    
  }
  return $status;
}

function nombreCategoria($idcategoria){
  $resCategoria = devolverValorQuery("SELECT titulo FROM post_category WHERE idpost_category =".$idcategoria." ");
  return $resCategoria['titulo'];
}

function nombreBlogEstatus($id){
  $resEstatus = devolverValorQuery("SELECT status FROM blog_post WHERE idblog_post =".$id." ");
  switch ($resEstatus['status']) {
    case 0:
      $status = "Publicado";
      break;
    case 1:
      $status = "Borrador";
      break;
    case 2:
      $status = "Papelera";
      break;
    default:
      $status = "Publicado";
      break;
  }
  return $status;
}

function mostrarLocalidad($id){
  $localidad = devolverValorQuery("SELECT estado.nombre as estado,municipio.nombre as ciudad FROM estado inner join municipio on estado.idestado=municipio.idestado and municipio.idmunicipio=".$id." ");
  $ubicacion = $localidad['ciudad'].", ".$localidad['estado'];
  return $ubicacion;
}

function contadorLikes($id){
  $likes_count = cantidadRegistros("SELECT * FROM likes WHERE idhistoria=".$id." ");
  return $likes_count;
}

function postLiked($id,$user){
  $revisar_post = cantidadRegistros("SELECT * FROM likes WHERE idhistoria=".$id." AND idusuario=".$user." ");
  return $revisar_post;
}

function mostrarPortadaMiniatura($id){
  $foto = devolverValorQuery("SELECT miniatura FROM foto WHERE idregalo =".$id." ");
  $ruta = URL.$foto['miniatura'];
  return $ruta;
}
function mostrarPortadaMediana($id){
  $foto = devolverValorQuery("SELECT mediana FROM foto WHERE idregalo =".$id." ");
  $ruta = URL.$foto['mediana'];
  return $ruta;
}
function mostrarPortadaGrande($id){
  $foto = devolverValorQuery("SELECT original FROM foto WHERE idregalo =".$id." ");
  $ruta = URL.$foto['original'];
  return $ruta;
}
function mostrarIdEstado($id){
	$nombre = devolverValorQuery("SELECT idestado FROM municipio WHERE idmunicipio=".$id."");
	return $nombre['idestado'];
}
function mostrarNombreCiudad($id){
	$nombre = devolverValorQuery("SELECT nombre FROM municipio WHERE idmunicipio=".$id."");
	return $nombre['nombre'];
}



function calculaPeriodo($periodo){
    $fecha = date("Y-m-d H:i:s");
    $fechaActual = strtotime ( "+".$periodo." hour" , strtotime ( $fecha ) ) ;
    $fechaFormato = date ( 'Y-m-d' , $fechaActual );
    $fechaFinal = $fechaFormato;

    return $fechaFinal." 00:00:00";
}
function calculaPeriodoPublicar($periodo){
    $fecha = date("Y-m-d H:i:s");
    $fechaActual = strtotime ( "+".$periodo." hour" , strtotime ( $fecha ) ) ;
    $fechaFormato = date ( 'Y-m-d' , $fechaActual );
    $fechaFinal = $fechaFormato;

    return $fechaFinal;
}

function mostrarNombreNotifica($id){
  $nombre = devolverValorQuery("SELECT nombre FROM notificacion_correo WHERE idnotificacion_correo=".$id."");
  return $nombre['nombre'];
}

function limpiar_cadena($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'i', 'i', 'i', 'i'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'u', 'u', 'u', 'u'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'n', 'c', 'c',),
        $string
    );

    $string = str_replace(
        array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'),
        array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".","®","º","°"),
        '',
        $string
    );

    $string = str_replace(" ","-",$string);


    return $string;
}

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 


function curPageURL() {
     $pageURL = 'http';
     if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) { $pageURL .= "s";}
     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
     return $pageURL;
}

function makeDir($path)
{
     return is_dir($path) || mkdir($path);
}

function calcular_dias($fecha_i,$fecha_f)
    {
      $dias = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
      $dias   = abs($dias); $dias = ceil($dias);   
      return $dias;
    }


?>