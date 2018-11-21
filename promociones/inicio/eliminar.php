<html>
<head>
<center>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<body>
<?php
$id_archivo=$_GET['id_archivo'];
$archivo=$_GET['archivo'];
$pantalla=$_GET['pantalla'];
$id_programa = $_GET['id_programa'];

include('../../conexion.php');
include('../../check.php');
			/////////historial

            if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','eliminó',(Select CURRENT_TIMESTAMP),'$archivo',(Select nombre FROM pantallas_promociones where id_pantalla=$pantalla))")){
              echo "<div class='w3-row w3-green'><h2>Hay nuevos cambios en el historial</h2></div>";
              }
            /////////historial 
if($result = $mysqli->query("DELETE FROM `programacion_promociones` WHERE `programacion_promociones`.`id_programacion` = ".$id_programa)){ 
	echo "<div class='w3-row w3-green '><h2>Se borr&oacute; con &eacute;xito la programaci&oacute;n</h2></div>";
}else{
	echo "<div class='w3-row w3-red'><h2>No se pudo borrar</h2></div>";
}
//revisa si hay programaciones que ocupen el video
if($result = $mysqli->query("SELECT * FROM `programacion_promociones` WHERE id_archivo=".$id_archivo)){
if ($result->num_rows == 0){
	echo "<div class='w3-row w3-green '><h2>Se ha eliminado con &eacute;xito el video:<b>$archivo</b></h2></div>";
	unlink("../videos/" . $archivo);
	//elimina de la tabla archivos
	if($result = $mysqli->query("DELETE FROM `archivos` WHERE `archivos`.`id_archivo` = ".$id_archivo)){ 
	echo "<div class='w3-row w3-green '><h2>Se borr&oacute; con &eacute;xito la programaci&oacute;n</h2></div>";
}else{echo "<div class='w3-row w3-red'><h2>No se pudo borrar</h2></div>";}		
}
}else{echo "<div class='w3-row w3-red '><h2>No fue posible consultar las programaciones del archivo</h2></div>";}
// close database connection
$mysqli->close();
?>
<a href="../index.php"><div class='w3-row w3-black '><h2>Regresar.</h2></div></a>
</center>
</body>
</html>
