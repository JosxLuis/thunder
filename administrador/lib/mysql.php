<?php

	$conexion = mysqli_connect(DB_SERVIDOR,DB_USUARIO,DB_PASSWORD,DB_NOMBRE);
	
	if(!$conexion)
		die("<h3>ERROR al conectar a la base de datos</h3>");
	
	function devolverValorQuery($query) //te devuelve un arreglo con los valores en de la consulta
	{
		global $conexion;
		mysqli_query($conexion,"SET lc_time_names = 'es_MX'" );
		$tabla = mysqli_query($conexion,$query);
		@$registro= mysqli_fetch_array($tabla);
		return $registro;		
	}
	
	function cantidadRegistros($query)  //esta funcion te devuelve la cantidad de registros de la consulta
	{
		global $conexion;
		$resultado=mysqli_query($conexion,$query);
		$cantidad=mysqli_num_rows($resultado);
		return $cantidad;
	}

	
?>