<?php 

	$fechaActual = date('Y-m-d');
	$mesActual = date('m');
	$anioActual = date('Y');

	$d = new DateTime($fechaActual, new DateTimeZone('UTC')); 
	$d->modify('first day of previous month');
	$year = $d->format('Y'); //2012
	$month = $d->format('m'); //12

	/*$productos = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."producto ");
	$productosUrrea = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."categoria IN (SELECT id".DB_PREFIJO."categoria FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=1)");
	$productosSurtek = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."categoria IN (SELECT id".DB_PREFIJO."categoria FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=2)");
	$productosLock = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."categoria IN (SELECT id".DB_PREFIJO."categoria FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=3)");

	$subcategoriasUrrea = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=1");
	$subcategoriasSurtek = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=2");
	$subcategoriasLock = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=3");


	$cantidadCotizaciones = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."cotizacion WHERE MONTH(creado)=".$mesActual." AND YEAR(creado) = ".$anioActual."");
	$cantidadCotizacionesAnterior = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."cotizacion WHERE MONTH(creado)=".$month." AND YEAR(creado) = ".$year."");*/
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Administrador - <?php echo PROYECTO; ?></title>
	<!-- Metas  Especificas para  mobiles -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo ADMINURL; ?>img/favicon.png">
	<link rel="apple-touch-icon" href="<?php echo ADMINURL; ?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo ADMINURL; ?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo ADMINURL; ?>img/apple-touch-icon-114x114.png">

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Productos'],
          ['Lock',      10],
          ['Urrea',     30],
          ['Surtek',    15]
        ]);

        var piechart_options = {
          title: 'Total de Productos 55',legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, piechart_options);

        var databar = google.visualization.arrayToDataTable([
          ['Task', 'categorias'],
          ['Lock',      8],
          ['Urrea',     12],
          ['Surtek',    6]
        ]);

        var barchart_options = {title:'Categorias por Marca',legend: 'none'};
        var barchart = new google.visualization.BarChart(document.getElementById('barchart'));
        barchart.draw(databar, barchart_options);
      }
    </script>
</head>
<body>
	<div class="dashboard">
		<?php require_once(PREFIJO.'menu.php'); ?>
		<div class="container">
			<div class="eight columns">
				<div class="tablero">
					<div class="estadistica">
						<div class="titulo">
							<h4>Productos</h4>
							<p>Cantidad de productos por marca</p>
						</div>
						<div id="piechart" style="width:100%; height:300px;"></div>
					</div>
				</div>
			</div>
			<div class="eight columns">
				<div class="tablero">
					<div class="estadistica">
						<div class="titulo">
							<h4>Categorías</h4>
							<p>Cantidad de categorias por marca</p>
						</div>
						<div id="barchart" style="width:100%; height:300px;"></div>
					</div>
				</div>
			</div>
			<div class="row"></div>
			<div class="eight columns">
				<div class="tablero">
					<div class="estadistica">
						<div class="titulo">
							<h4>Cotizaciones</h4>
							<p>que han solicitado en el mes actual vs mes anterior</p>
						</div>
						<div class="cotizaciones">
							<div class="cantidad">
								<h3>0/0</h3>
								<span>Cotizaciones</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(PREFIJO.'footer.php'); ?>
	</div>
	
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/default.js"></script>
</body>
</html>