 <!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body class="w3-white">
    <head>
      <title>subir</title>
    </head>
       <body>
          <center>
            <?php
            include('../check.php');        
            include('../conexion.php');

            //variables
            $tipo_anterior= $_POST["tipo_anterior"];
            $nombre_pantalla = $_POST["nombre_pantalla"];
            $nombre_anterior = $_POST["nombre_pantalla_anterior"];
            $tipo = $_POST["tipo"];
            $formato= $_POST["formato"];
            $id_pantalla= $_POST["id_pantalla"];
            $nombre_pantalla= str_replace(' ','_',$nombre_pantalla);


          if($tipo==1){
            $tipo="salones";
          }else{
            $tipo="promociones";
          }
            /// funcion para eliminar la carpeta
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
      echo "<div class='w3-row w3-light-green '><h4 class='w3-center'>Se ha eliminad&oacute; la carpeta: <b>$nombre_pantalla</b></h4></div>"; 
     }
//funcion para eliminar las tablas
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

 

if($tipo=="salones"){
E_eventos($tipo,$id_pantalla);
}
E_archivos($tipo_anterior,$id_pantalla,$nombre_anterior);
E_tabla($tipo_anterior,$id_pantalla,$nombre_anterior);
E_carpeta($tipo_anterior,$nombre_anterior);
//variables

  ///inserta la nueva pantalla en base de datos
  if(mysqli_query($mysqli,"INSERT INTO `pantallas_".$tipo."`(nombre,formato) VALUES ('$nombre_pantalla','$formato');")){
           echo"<div class='w3-row w3-light-green '><h4>Se ha creado la pantalla: <b>$nombre_pantalla</b></h4></div>";}
           //toma el id de la pantalla recien creada
        if ($result = $mysqli->query("SELECT id_pantalla FROM pantallas_".$tipo." where nombre='$nombre_pantalla'")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_pantalla=$row->id_pantalla;
            }
          }
        } 
 ///crear carpeta
 $carpeta = "../$tipo/pantallas/$nombre_pantalla";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
  }
//copia los archivos de la plantilla a su detino final
copiar("plantillas/$formato/",$carpeta);
    function copiar($fuente, $destino){
    if(is_dir($fuente)){
        $dir=opendir($fuente);
        while($archivo=readdir($dir)){
            if($archivo!="." && $archivo!=".."){
                if(is_dir($fuente."/".$archivo)){
                    if(!is_dir($destino."/".$archivo)){
                        mkdir($destino."/".$archivo);
                    }
                    copiar($fuente."/".$archivo, $destino."/".$archivo);
                }else{
                    copy($fuente."/".$archivo, $destino."/".$archivo);
                }
            }
        }
        closedir($dir);
    }else{
        copy($fuente, $destino);
    }
}
///edita texto
$nombre_p="$"."nombre_p";
$id_p="$"."id_p";
$id_p_2="$"."id_p_2";
$baner="$"."baner";
$i=0;
//cuadrado (salones)
if($formato=="cuadrado"){
    $archivos = array("index.php", "evento.php", "default.php", "completa.php");
    while($i<4){
    $archivo = "../$tipo/pantallas/$nombre_pantalla/$archivos[$i]";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"$nombre_pantalla\";$id_p=\"$id_pantalla\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
      }
    }
    ///horizontal (promociones) 
    if($formato=="horizontal"){
    ///// index
    $archivo = "../$tipo/pantallas/$nombre_pantalla/index.php";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"$nombre_pantalla\";$id_p=\"$id_pantalla\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
    } 
    //vertical (salones)
if($formato=="vertical"){
    $archivos = array("index.php", "evento.php", "default.php", "completa.php");
    while($i<4){
    $archivo = "../$tipo/pantallas/$nombre_pantalla/$archivos[$i]";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"$nombre_pantalla\";$id_p=\"$id_pantalla\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
      }
    }
    //vertical dividido(salones)
if($formato=="vertical_dividido"){
    ////inserta la otra pantalla  
  $nombre_pantalla_2=$nombre_pantalla."_2";
  if(mysqli_query($mysqli,"INSERT INTO `pantallas_".$tipo."`(`nombre`) VALUES ('$nombre_pantalla_2');")){
           echo"<div class='w3-row w3-green '><h2>Se ha creado ela pantalla: <b>$nombre_pantalla_2</b></h2></div>";}
  ////////id de la pantalla creada
        if ($result = $mysqli->query("SELECT id_pantalla FROM pantallas_".$tipo." where nombre='$nombre_pantalla_2'")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_pantalla_2=$row->id_pantalla;
            }
          }
        }
    $archivos = array("index.php", "evento_largo.php","evento_corto.php", "default.php", "completa.php");
    while($i<4){
    $archivo = "../$tipo/pantallas/$nombre_pantalla/$archivos[$i]";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"$nombre_pantalla\";$id_p=\"$id_pantalla\";$id_p_2=\"$id_pantalla_2\";?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
      }
    }
//vertical (promociones)
if($formato=="vertical_promo"){
    $archivo = "../$tipo/pantallas/$nombre_pantalla/index.php";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    ////imagen
      $target_file = "../$tipo/imagenes/" . basename($_FILES["miArchivo"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      ///filtro de peso de imagen
      if ($_FILES["miArchivo"]["size"] > 500000000) {
        echo "<br><div class='w3-row w3-red '><h2>Lo sentimos, asegurate que tu archvio pese menos de 500 MB.</h2></div> <br>";
        $uploadOk = 0;
      }
      //filtro archivo existente
      if (file_exists($target_file)) {
          echo "Lo sentimos ya existe un archivo con ese nombre. <br>";
          $uploadOk = 0;
      }
      //verificador
      if ($uploadOk == 0) {
        echo "<br><div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu imagen.</h2></div>";
      } else {
        if (move_uploaded_file($_FILES["miArchivo"]["tmp_name"], $target_file)) { ////1
        $imagen = basename( $_FILES["miArchivo"]["name"]);
      }
      }
    //fin imagen
    $contenido[0] = "<?php $nombre_p=\"$nombre_pantalla\";$id_p=\"$id_pantalla\";$baner=\"$imagen\" ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
    }
    //Inserta en el historial
    if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','editó',(Select CURRENT_TIMESTAMP),' Pantalla ".$nombre_pantalla."','N/A')")){
              echo "<div class='w3-row w3-light-green w3-center'><h4>Hay nuevos cambios en el historial</h4></div>";             
    }
?>
<a href="index.php"><div class='w3-row w3-black '><h2>Regresar</h2></div></a>
          </center>
      </body>
</html>
