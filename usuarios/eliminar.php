<html>
<head>
<title>Eliminar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body class="w3-white">
<center>
	<div class="w3-panel w3-lime w3-card-4">
    
  
<?php

//$contra=$_POST['contrasena_E'];
include('../conexion.php');
include('../check.php');

//$sqlquery = "DELETE FROM `usuario` WHERE `usuario`.`nombre` = '".$user_check."'";

if(isset($_POST["usuarios"])){
  $usuarios = $_POST["usuarios"];
//echo $archivo;
$count = count($usuarios);
for ($i = 0; $i < $count; $i++) {         
        $sqlp="DELETE FROM `usuario` WHERE `usuario`.`id_usuario` = '".$usuarios[$i]."'";
            if(mysqli_query($mysqli,$sqlp)){
              echo"<br>Se elimin&oacute; con exito  <br>";
            }else{
        echo "<p>No se pudo Eliminar</p><br>"; 
      }
          }
/////
$mysqli->close();
}else {
  echo "<br> <p>Debes seleccionar al menos una pantalla del menu para poder programar tu evento. </p><br>";
} 


?>

</div>
<div class="w3-panel w3-black w3-card-4"><br><a  href="../inicio.php">Regresar.</a><br></div>
</center>
</body>
</html>
