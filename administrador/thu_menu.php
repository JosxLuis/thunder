<?php $buscarAvatar = devolverValorQuery("SELECT avatar FROM ".DB_PREFIJO."administrador WHERE id".DB_PREFIJO."administrador=".$_SESSION[PREFIJO.'idadmin']." "); ?>

<header>
	<div class="cabecera">
		<div class="titulo">Administración</div>
	</div>
	<div class="user-detail">
		<div class="avatar">
			<a <?php if($buscarAvatar['avatar'] != ""){ ?> style="background:url(<?php echo URL.$buscarAvatar['avatar']; ?>);" <?php } ?> ></a>
			<div class="no-image">
					<i class="fa-icon-user"></i>
			</div>
		</div>
		<div class="username"><a href="<?php echo ADMINURL; ?>profile/"><i class="fa-icon-user-o"></i> <?php echo $_SESSION[PREFIJO.'user']; ?></a></div>
	</div>
	<nav>
		<ul class="menu">
			<li class="menu-icon"><a href="#">Menu</a></li>
			<li <?php if($_GET['do'] == ""){ echo 'class="current"'; } ?>>
				<a href="<?php echo ADMINURL; ?>"><i class="fa-icon-dashboard"></i> Tablero</a>
			</li>
			<li class="encabezado <?php if(isset($_GET['do']) && $_GET['do'] == "servicios"){ ?>current <?php } ?>">
				<a href="<?php echo ADMINURL; ?>content/servicios/"> <i class="fa-icon-bolt"></i> Servicios</a>
			</li>
			<li class="encabezado <?php if(isset($_GET['do']) && $_GET['do'] == "portafolio"){ ?>current <?php } ?>">
				<a href="<?php echo ADMINURL; ?>content/portafolio/"> <i class="fa-icon-suitcase"></i> portafolio</a>
			</li>
			<?php if($_SESSION[PREFIJO.'tipo'] == 1){ ?>
			<li class="encabezado">
				<a href="javascript:;" class="toggle" id="7"> <i class="fa-icon-gears"></i> Configuración <span><i class="fa-icon-caret-down"></i></span></a>
					<div id="item_7" class="mostrar">
						<ul>
							<li <?php if(isset($_GET['do']) && $_GET['do'] == "usuarios"){ ?>class="current"<?php } ?>><a href="<?php echo ADMINURL; ?>content/usuarios"> <i class="fa-icon-user"></i> Usuarios</a></li>
							<li <?php if(isset($_GET['do']) && $_GET['do'] == "slider"){ ?>class="current"<?php } ?>><a href="<?php echo ADMINURL; ?>content/slider"> <i class="fa-icon-image"></i> Slider</a></li>
						</ul>
					</div>
			</li>
			<?php } ?>
		</ul>
	</nav>
</header>
<div class="navegacion">
	<div class="area">
		<h4><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do'];  ?>" <?php if(isset($_GET['act']) && $_GET['act'] != ""){ ?> class="current" <?php } ?>><?php echo $_GET['do'];  ?></a> <?php if(isset($_GET['act']) && $_GET['act'] != ""){ ?> / <span><?php echo $_GET['act']; ?> registro</span> <?php } ?></h4>
	</div>
	<div class="objetos">
		<ul>
			<li><a href="<?php echo ADMINURL ?>salir/"><i class="fa-icon-sign-out"></i></a></li>
		</ul>
	</div>
</div>