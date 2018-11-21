<html>
<head>
<title>eliminar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body class="w3-white">
<center>
	<div class="w3-panel w3-lime w3-card-4">
    
  
<?php
$usuario=$_POST['usuario_nuevo'];
$contra=$_POST['contrasena_nuevo'];


include('../conexion.php');
include('../check.php');
$sqlquery = "INSERT INTO `usuario`( `nombre`, `contrasena`) VALUES ('".$usuario."','".$contra."')";
//echo "DELETE FROM `programacion.salones` WHERE `pantallas_id_pantallas` = ".$pantalla." AND `archivo_id_archivo` = ".$id_archivo;
if($result = $mysqli->query($sqlquery)){
	echo "<p>Se ha insertado con &eacute;xito </p><br>";
}else{
	echo "<p>No se pudo insertar</p><br>";
}
//echo $archivo;


$mysqli->close();
?>

</div>
<div class="w3-panel w3-black w3-card-4"><br><a  href="../inicio.php">Regresar.</a><br></div>
</center>
</body>
</html>

