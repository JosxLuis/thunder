<?php
	$cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=".$_POST['search_marca']." AND parentid IS NULL ");
	$ciudades = "SELECT * FROM ".DB_PREFIJO."categoria WHERE id".DB_PREFIJO."marca=".$_POST['search_marca']." AND parentid IS NULL ";
	$resultado = mysqli_query($conexion,$ciudades);
	if($cantidad != 0){
?>
	<option value="">Elegir categoría</option>
	<?php 
		while($rowSubcategoria = mysqli_fetch_array($resultado)){
	?>
	<option value="<?php echo $rowSubcategoria['id'.DB_PREFIJO.'categoria'] ?>"><?php echo utf8_encode($rowSubcategoria['nombre']); ?></option>
<?php 
		}
}else{
?>
	<option value="">No hay registros</option>
<?php } ?>