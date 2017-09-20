<?php
	$cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."categoria WHERE parentid=".$_POST['search_categoria']." ");
	$ciudades = "SELECT * FROM ".DB_PREFIJO."categoria WHERE parentid=".$_POST['search_categoria']." ";
	$resultado = mysqli_query($conexion,$ciudades);
	if($cantidad != 0){
?>
	<option value="">Elegir subcategoría</option>
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