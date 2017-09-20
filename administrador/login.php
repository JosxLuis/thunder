<?php

if(isset($_POST['usuario']))
{
    //print_r($_POST);
    $password=trim($_POST['passw']);
    $consulta = devolverValorQuery("SELECT id".DB_PREFIJO."administrador,usuario,token,id".DB_PREFIJO."administrador_rol FROM ".DB_PREFIJO."administrador WHERE usuario='".$_POST['usuario']."' and token='".md5($password)."'");
    if($consulta['usuario'] == true)
    {
        @session_start();
        $_SESSION[PREFIJO.'user'] = $consulta['usuario'];
        $_SESSION[PREFIJO.'idadmin'] = $consulta['id'.DB_PREFIJO.'administrador'];
        $_SESSION[PREFIJO.'tipo'] = $consulta['id'.DB_PREFIJO.'administrador_rol'];
        header("Location:".ADMINURL);
        exit();
    }
    else
    {
        //$md5 = md5($password);
        header("Location: index.php?error_login=true");
        exit();
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Favicons -->
    <link rel="shortcut icon" href="<?php echo ADMINURL; ?>img/favicon.png">
</head>
<body>
<?php if(isset($_GET['error_login'])){ ?>
        <div class="alert alert-danger"><i class="icon-minus-circle"></i> Los datos son incorrectos</div>
<?php } ?>
<div class="login">
    <div class="content">
       	<form name="login" method="post" action="">
            <div class="icono">
                <i class="fa-icon-user"></i>
            </div>
            <input type="text" name="usuario" placeholder="Usuario:" required autofocus />
            <input type="password" name="passw" placeholder="Contraseña:" required />
            <input type="submit" name="entrar" value="Ingresar" />
            <br />
        </form>
    </div>
</div>
</body>
</html>