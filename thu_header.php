<header>
	<div class="container">
		<div class="four columns">
			<div class="logo">
				<a href="<?php echo URL; ?>"></a>
			</div>
		</div>
		<div class="eight columns">
			<div id="menu-movil" class="">
				<nav>
					<ul>
						<li <?php if(isset($_GET['do']) && $_GET['do'] == ""){ ?> class="current"<?php } ?> ><a href="<?php echo URL; ?>">Inicio</a></li>
						<li <?php if(isset($_GET['do']) && $_GET['do'] == "empresa"){ ?> class="current"<?php } ?>>
							<a href="<?php echo URL; ?>empresa/">Empresa</a>
						</li>
						<li <?php if(isset($_GET['do']) && $_GET['do'] == "servicios"){ ?> class="current"<?php } ?>>
							<a href="<?php echo URL; ?>servicios/">Servicios</a>
							<!--<ul>
								<li><a href="#">subsección</a></li>
								<li><a href="#">subsección</a></li>
								<li><a href="#">subsección</a></li>
								<li><a href="#">subsección</a></li>
							</ul>-->
						</li>
						<li <?php if(isset($_GET['do']) && $_GET['do'] == "portafolio"){ ?> class="current"<?php } ?>><a href="<?php echo URL; ?>portafolio/">Portafolio</a></li>
						<li <?php if(isset($_GET['do']) && $_GET['do'] == "contacto"){ ?> class="current"<?php } ?>><a href="<?php echo URL; ?>contacto/">Contacto</a></li>
					</ul>
					<div class="clear"></div>
				</nav>
			</div>
		</div>
	</div>
	<a href="javascript:;" id="movil-button" class="desplegar-menu"><i class="icon-menu"></i></a>
</header>