<?php
if (!isset($_SESSION)) {
  session_start();
}
session_destroy();
$_SESSION[PREFIJO.'user'] = NULL;
$_SESSION[PREFIJO.'idadmin'] = NULL;
header("Location:".ADMINURL."");
exit();
?>