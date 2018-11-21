<html>
<head>
<title>Editar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body class="w3-white">
<center>
	<div class="w3-panel w3-lime w3-card-4">
    
  
<?php
$contra=$_POST['contrasena_E'];
//$nombre=$_POST['nombre_E'];

include('../conexion.php');
include('../check.php');
//echo $contrasena;
//$sqlquery = "UPDATE `usuario` SET `contrasena` = '".$contrasena."' WHERE `usuario`.`nombre` = ".$nombre
//echo "UPDATE `usuario` SET `contrasena` = '".$contrasena."' WHERE `usuario`.`nombre` = ".$nombre
//echo "UPDATE `usuario` SET `contrasena` = '".$contra."' WHERE `usuario`.`nombre` = '".$user_check."'";
if($result = $mysqli->query("UPDATE `usuario` SET `contrasena` = '".$contra."' WHERE `usuario`.`nombre` = '".$user_check."'")){

	echo "<p>Se ha modificado con &eacute;xito</p><br>";
}else{
	echo "<p>No se pudo editar</p><br>";
}
//echo $archivo;

/////
$mysqli->close();
?>

</div>
<div class="w3-panel w3-black w3-card-4"><br><a  href="../inicio.php">Regresar.</a><br></div>
</center>
</body>
</html>
