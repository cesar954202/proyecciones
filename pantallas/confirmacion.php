
<!DOCTYPE html>
<html>
<head>
  <title>Eliminado</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>
<?php 
include('../check.php');
include('../conexion.php');
//variables
$id_pantalla=$_POST['id_pantalla'];
$tipo=$_POST['tipo'];
$nombre_pantalla=$_POST['nombre_pantalla'];
//funcion para eliminar la carpeta
function E_carpeta($tipo,$nombre_pantalla){
  include('../conexion.php');
  $carpeta="../$tipo/pantallas/$nombre_pantalla";
      foreach(glob($carpeta . "/*") as $archivos_carpeta){             
        if (is_dir($archivos_carpeta)){
          rmDir_rf($archivos_carpeta);
        } else {
        unlink($archivos_carpeta);
        }
      }
      rmdir($carpeta);
      echo "<div class='w3-row w3-light-green '><h4 class='w3-center'>Se ha eliminado la carpeta: <b>$nombre_pantalla</b></h4></div>";
       
     }
//funcion para eliminar la tabla
function E_tabla($tipo,$id_pantalla,$nombre_pantalla){
  include('../conexion.php');
  if($result1 = $mysqli->query("DELETE FROM `programacion_$tipo` WHERE `id_pantalla` = $id_pantalla or `id_pantalla`=(select id_pantalla from pantallas_$tipo where nombre = '$nombre_pantalla"."_2')")){
         if($result1 = $mysqli->query("DELETE FROM pantallas_$tipo WHERE `id_pantalla` = ".$id_pantalla." or pantallas_$tipo.nombre='$nombre_pantalla"."_2'")){
         echo "<div class='w3-row w3-light-green '><h4 class='w3-center'>Se ha eliminado la pantalla de la base de datos con &eacute;xito</h4></div>"; 
         
         } else{echo "<div class='w3-row w3-pale-red '><h4 class='w3-center'>No fue posible eliminar las tablas de la base de datos</h4></div>";}
      }
}
//funcion para eliminar los archivos
function E_archivos($tipo,$id_pantalla,$nombre_pantalla){
  include('../conexion.php');

  if ($tipo=="promociones") {
    $tipo_archivo="videos";
  }else{
    $tipo_archivo="imagenes";
  }


  if ($result = $mysqli->query("SELECT archivos.id_archivo, archivos.nombre as 'archivo' FROM `programacion_$tipo` 
INNER JOIN archivos on archivos.id_archivo=programacion_$tipo.id_archivo 
INNER JOIN pantallas_$tipo on pantallas_$tipo.id_pantalla=programacion_$tipo.id_pantalla 
where programacion_$tipo.id_pantalla=$id_pantalla or pantallas_$tipo.nombre='$nombre_pantalla"."_2'")){
    if ($result->num_rows == 0){
          //no borra nada
            }else{              
              while ($row = $result->fetch_object()){ 
                if ($result2 = $mysqli->query("select count(id_programacion) as 'num' from programacion_$tipo where id_archivo=".$row->id_archivo)){
                    if ($result2->num_rows > 0){
                      while ($row2 = $result2->fetch_object()){
                        $numero=$row2->num;
                          echo "numero:".$numero;
                            if($numero==1){
                                if($result3 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = ".$row->id_archivo)){
                                  echo "<div class='w3-row w3-light-green '><h4 class='w3-center'>Se ha eliminado el archivo:<b>$row->archivo</b> con &eacute;xito</h4></div>"; 
                              }
                            unlink("../$tipo/$tipo_archivo/" . $row->archivo);
                            echo "<div class='w3-row w3-light-green '><h4 class='w3-center'>Se han eliminaron los videos o imagenes de la carpeta</b></h4></div>"; 
                        }
                    }
                }
              }
            }
          }
        }
      }

//funcion para eliminar los eventos
  function E_eventos($tipo,$id_pantalla){
  include('../conexion.php');

  if ($result = $mysqli->query("SELECT eventos.id_evento,eventos.nombre as 'evento' FROM `programacion_$tipo` 
INNER JOIN eventos on eventos.id_evento=programacion_$tipo.id_evento
where programacion_$tipo.id_pantalla=$id_pantalla")){
    if ($result->num_rows == 0){
          //no borra nada
            }else{            
              while ($row = $result->fetch_object()){
                        ////////genera id para la imagen
                        if ($result2 = $mysqli->query("select count(id_programacion) as 'num' from programacion_$tipo where id_evento=".$row->id_evento)){
                            if ($result2->num_rows > 0){
                              while ($row2 = $result2->fetch_object()){
                                $numero=$row2->num;
                                echo "numero:".$numero;
                                if($numero==1){
                                  if($result3 = $mysqli->query("DELETE FROM `eventos` WHERE `id_evento` = ".$row->id_evento)){
                                      echo "<div class='w3-row w3-light-green '><h4 class='w3-center'>Se ha eliminado el evento:<b>$row->evento</b> con &eacute;xito</h4></div>";
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }

///verifica si aplica la eliminacion de eventos(soo aplica para pantallas de salones)
if($tipo=="salones"){
E_eventos($tipo,$id_pantalla);
}

E_archivos($tipo,$id_pantalla,$nombre_pantalla);
E_tabla($tipo,$id_pantalla,$nombre_pantalla);
E_carpeta($tipo,$nombre_pantalla);

  //guarda el historial
      if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','eliminó',(Select CURRENT_TIMESTAMP),'Pantalla ".$nombre_pantalla."','N/A')")){
              echo "<div class='w3-row w3-light-green w3-center'><h4>Hay nuevos cambios en el historial</h4></div>";             
    }
     
?>

<form action="index.php"><button class="w3-btn w3-block  w3-left w3-black  w3-large " >Regresar</button></form>
</body>
</html>