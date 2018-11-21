<html>
<head>
<title>eliminar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body class="w3-white">
<center>
     
<?php 
//$id_archivo=$_GET['id_archivo'];
//$archivo=$_GET['archivo'];
//$pantalla=$_GET['pantalla'];
$id_programacion = $_GET["id_programacion"];

include('../../conexion.php');
include('../../check.php');
///////////inserta en historial
//echo "SELECT nombre_evento FROM `programacion_salones` where programacion_salones.archivo_id_archivo=".$id_archivo." and pantallas_salones_id_pantallas=".$pantalla;
if ($result1 = $mysqli->query("SELECT archivos.id_archivo as 'id_archivo',archivos.nombre as 'archivo',eventos.nombre as 'evento',eventos.id_evento as 'id_evento',pantallas_salones.id_pantalla AS 'pantalla',pantallas_salones.nombre AS 'nombre_pantalla'
FROM programacion_salones
INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
INNER JOIN archivos on archivos.id_archivo=programacion_salones.id_archivo
INNER JOIN pantallas_salones on pantallas_salones.id_pantalla=programacion_salones.id_pantalla
WHERE programacion_salones.id_programacion=$id_programacion")){
        if ($result1->num_rows > 0){
          while ($row1= $result1->fetch_object()){
            $nombre_evento=$row1->evento;
            $nombre_pantalla=$row1->nombre_pantalla;
            $id_pantalla=$row1->pantalla;
            $id_evento=$row1->id_evento;
            $archivo=$row1->archivo;
            $id_archivo=$row1->id_archivo;
            //echo $nombre_evento;
            }

        }
      }
      
///////////elimina de tabla programacion
if($result = $mysqli->query("DELETE FROM `programacion_salones` WHERE `programacion_salones`.`id_programacion` =".$id_programacion)){
	echo "<div class='w3-row w3-green'><h2>Se ha eliminado con &eacute;xito de esta programacion el evento: <b>$nombre_evento</b> de la pantalla: <b>$nombre_pantalla</b></h2></div>";
  /////////////inserta en historial
  //echo "INSERT INTO `historial`(`id_usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ((SELECT id_usuario from usuario where nombre='$user_check'),'eliminó',(Select CURRENT_TIMESTAMP),$id_evento,$id_pantalla)";
              if($result1 = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','eliminó',(Select CURRENT_TIMESTAMP),(SELECT nombre from eventos where id_evento=$id_evento),(SELECT nombre from pantallas_salones where id_pantalla=$id_pantalla))")){
         }
////////////////////////////
}else{
	echo "<div class='w3-row w3-red '><h2>No se pudo Eliminar</h2></div>";
}
//////////////////eliminando de tabla archivos
if ($result2 = $mysqli->query("SELECT id_programacion FROM `programacion_salones` where programacion_salones.id_evento=".$id_evento)){
    if ($result2->num_rows > 0){

            }else{
                if($result2 = $mysqli->query("DELETE FROM `eventos` WHERE `id_evento` = ".$id_evento)){
                  //unlink("../imagenes/" . $archivo);
                  echo "<div class='w3-row w3-green '><h2>se elimin&oacute; el evento:<b>$nombre_evento</b></h2></div>"; 
                  }
              }
         }

/////////////
         if ($result2 = $mysqli->query("SELECT id_programacion FROM `programacion_salones` where programacion_salones.id_archivo=".$id_archivo)){
    if ($result2->num_rows > 0){

            }else{
                if($result2 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = ".$id_archivo)){
                  unlink("../imagenes/" . $archivo);
                  echo "<div class='w3-row w3-green '><h2>se elimin&oacute; el archivo:<b>$archivo</b></h2></div>"; 
                  }
              }
         }
 
/////////////
$mysqli->close();
?>


<a  href="index.php"><div class="w3-row w3-black w3-card-4"><h2>Regresar.</h2></div></a>
</center>
</body>
</html>
