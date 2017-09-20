<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

function realip() 
{
   if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function getUrl() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

function strleft($s1, $s2) {
    return substr($s1, 0, strpos($s1, $s2));
}


function nosql($var){  
$var = mysql_escape_string($var);  
$sen = array("SCRIPT"," AND ", "+" ,"SELECT", "UPDATE", "INSERT", "DELETE", "<>", "*","DROP","WHERE","\'"," OR ","ALERT"); 
$cache= explode(" ",$var);

foreach($cache as $value){
	//echo $value."<br>";
	if (in_array( strtoupper($value), $sen, true)){
		return false;
		exit();	
	}
}
 return true;
} 

function save_logs($Tipo,$Servicio,$Post,$Get,$Files,$database_logs){
  $conexion = mysql_connect(localhost, root, root );
  //$conexion = mysql_connect('localhost', 'foropetr_userdb', 'G.tCn@DD1_*H' );
  $userAgent = $_SERVER["HTTP_USER_AGENT"];
  $userAgent = strtolower ($userAgent);
  $Ip=realip();
  $Url=getUrl();
  $Server="";
  //serialize($_SERVER);
  $SaveLogs = "INSERT INTO logs (idlogs,IP,SO,Tipo,Servicio,Url,FechaUpdate,DataPost,DataGet,DataServer,DataFiles) VALUES (0,".GetSQLValueString($Ip, "text").",".GetSQLValueString($userAgent, "text").",".GetSQLValueString($Tipo, "text").",".GetSQLValueString($Servicio, "text").",".GetSQLValueString($Url, "text").",Now(),".GetSQLValueString($Post, "text").",".GetSQLValueString($Get, "text").",".GetSQLValueString($Server, "text").",".GetSQLValueString($Files, "text").")";
  //echo $SaveLogs;
  mysql_query($SaveLogs, $conexion) or die(mysql_error());
}
function verifica_usuario_ep($email){

  $conexion = mysql_connect(localhost, root, root );
  //$conexion = mysql_connect('localhost', 'foropetr_userdb', 'G.tCn@DD1_*H' );
  $usuarioEp = "SELECT email FROM users WHERE email ='".$email."'";
  //echo $usuarioEp;
  $resultado = mysql_query($usuarioEp,$conexion);
  $numRow = mysql_num_rows($resultado);
  if($numRow == 1){
    return $numRow;
  }else{
    return $numRow;
  }
}
?>