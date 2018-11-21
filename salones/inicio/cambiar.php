
<html>
    <head>
      <title>subir</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
       <body>
          <center>
            <?php
  ///////////////////////////////////////
  include('../../check.php');        
  include('../../conexion.php');
  
  $nombre_evento = $_POST["nombre_evento"];
  $nombre_evento_anterior = $_POST["nombre_evento_anterior"];
  $tipo_evento = $_POST["tipo_evento"];
  $texto_salon= $_POST["texto_salon"];
  $nombre_salon= $_POST["nombre_salon"];
  $completo=$_POST["completo"];
  $horatrans = $_POST["horatrans"];
  $diatrans = $_POST["diatrans"];
  $diainicio = $_POST["diainicio"];
  $diafinal = $_POST["diafinal"];
  $horainicio = $_POST["horainicio"];
  $horafinal = $_POST["horafinal"];
  $date1 = new DateTime("now");
  $fechactual = $date1->format('Y-m-d H:i:s');
  $archivo_anterior=$_POST["archivo_anterior"];
  //echo $archivo=$_FILES["miArchivo"];
  $id_programacion= $_POST["id_programacion"];
  $id_evento=$_POST["id_evento"];
         ////////ID imagen anterior


        if ($result = $mysqli->query("SELECT programacion_salones.id_archivo, archivos.nombre from programacion_salones inner join archivos on archivos.id_archivo=programacion_salones.id_archivo where id_evento=$id_evento")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_imagen=$row->id_archivo;
            $nombre_imagen=$row->nombre;
            }
          }
        }



  ///////////////////////////////////////////////
 $uploadOk = 1;
  ///////filtro para pantallas nulas
  if(isset($_POST["pantallas"])){
  $pantallas = $_POST["pantallas"];
  $count = count($pantallas);
}else {
  echo "<div class='w3-row w3-red '><h2>Debes seleccionar al menos una pantalla del menu para poder programar tu evento. </h2></div>";
  $uploadOk = 0;
}

///////////////filtro para fechas erroneas
if ($diainicio.$horainicio >= $diafinal.$horafinal){
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de inicio no debe ser mayor a la de termino.</h2></div>";
  $uploadOk = 0;
}
if ($diafinal.$horafinal <= $fechactual){
  echo " <div class='w3-row w3-red '><h2>La fecha y hora de termino es menor que la fecha actual.</h2></div>";
  $uploadOk = 0;
}
if ($diatrans.$horatrans > $diainicio.$horainicio){
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de transmisi&oacute;n es mayor que la fecha de inicio.</h2></div>";
  $uploadOk = 0;
}
///////////////////////////////////////////////////////////////////evento a la misma hora
  ////////////////////////////filtro evento a la misma hora
  for ($i = 0; $i < $count; $i++) { 
        if ($result4 = $mysqli->query("SELECT DISTINCT(programacion_salones.id_evento) FROM programacion_salones INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento WHERE programacion_salones.id_pantalla=$pantallas[$i] and nombre <> '".$nombre_evento_anterior."';")){
        if ($result4->num_rows > 0){
          while ($row4 = $result4->fetch_object()){
            $id_evento_n=$row4->id_evento;
            ///////////////////////////////////////////////////

            if ($result5 = $mysqli->query("SELECT DISTINCT(eventos.nombre) as 'evento',fecha_transmision,fecha_fin
FROM programacion_salones
INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
WHERE '$diatrans.$horatrans ' BETWEEN (SELECT fecha_transmision WHERE programacion_salones.id_evento = $id_evento_n) 
AND (SELECT programacion_salones.fecha_fin WHERE programacion_salones.id_evento = $id_evento_n) 
OR '$diafinal.$horafinal' BETWEEN (SELECT fecha_transmision WHERE programacion_salones.id_evento = $id_evento_n) AND (SELECT programacion_salones.fecha_fin WHERE programacion_salones.id_evento = $id_evento_n) 
OR (SELECT fecha_transmision WHERE programacion_salones.id_evento = $id_evento_n) BETWEEN '$diatrans.$horatrans ' AND '$diafinal.$horafinal' OR (SELECT programacion_salones.fecha_fin WHERE programacion_salones.id_evento = $id_evento_n)  BETWEEN '$diatrans.$horatrans ' AND '$diafinal.$horafinal' and nombre <> '".$nombre_evento_anterior."';")){
              if ($result5->num_rows > 0){
                while ($row5 = $result5->fetch_object()){
                  $evento_n=$row5->evento;
                  echo "<div class='w3-row w3-red'><h2>El evento:<b>$evento_n</b> ya tiene un horario que interfiere, se transmite el:<b> $row5->fecha_transmision <b> y se termina el:</b> $row5->fecha_fin </b> </h2></div>";
                  $uploadOk = 0;
                }
              }else{///no hay eventos que choquen
                
              }//fin eventos que chocan
            }
            }//fin primer fetch
            
          }else{//echo "No hubo eventos que interfieran, todo bien";
        }
        }else{echo "<div class='w3-row w3-red '><h2>no fue posible ejecutar el query</h2></div>";}
      }
///////////////////////////////////filtro evento a la misma hora
/////////////////////////////////////////////////////////////////////evento a la misma hora
if($uploadOk == 0){
echo " <div class='w3-row w3-red '><h2>No se han podido realizar los cambios</h2></div>";
  }else{
        //////////filtro de remplazo de imagen
        $target_file = "../imagenes/".basename($_FILES["miArchivo"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $archivo = basename( $_FILES["miArchivo"]["name"]);
        if(empty($archivo)){
          $id_archivo="(SELECT `id_archivo`  FROM `archivos` where nombre='$archivo_anterior')";
        }else{
          if ($_FILES["miArchivo"]["size"] > 500000000) {
            echo "<div class='w3-row w3-red '><h2>Lo sentimos, asegurate que tu archvio pese menos de 500 MB.</h2></div>";
            }

            if($imageFileType == "jpg" || $imageFileType == "JPG" ||$imageFileType == "JPEG" ||$imageFileType == "jpeg" ||$imageFileType == "PNG" ||$imageFileType == "png" ||$imageFileType == "GIF" ||$imageFileType == "gif") {
              ///////elimina la antigua imagen de las tablas programacion, archivos y de la carpeta
                /////////////////////////////////////////////// Genera id para la imagen
                 if ($result = $mysqli->query("SELECT MAX(id_archivo +1) as 'max' FROM archivos")){
                  if ($result->num_rows > 0){
                    while ($row = $result->fetch_object()){
                      $id=$row->max;
                    }
                  }
                 }
                //////////////////////////////////////////
                 if(move_uploaded_file($_FILES["miArchivo"]["tmp_name"], $target_file)){
                 $ruta=rename ( "../imagenes/".$_FILES["miArchivo"]["name"], "../imagenes/imagen_".$id.".jpg");
                 $archivo="imagen_".$id.".jpg";
                  if(mysqli_query($mysqli,"INSERT INTO `archivos`( `nombre`) VALUES ('$archivo')")){
                    echo" <div class='w3-row w3-green '><h2> se subido con &eacute;xito la imagen: <b>imagen_".$id.".jpg<b></h2></div>";
                    $archivo_id_archivo="(SELECT MAX(`id_archivo`)  FROM `archivos`)";
                  }else{echo " <div class='w3-row w3-red '><h2>no se pudo insertar el dato</h2></div>";}
                /////////////////////////////////////////////// toma el id de la nueva imagen
                 if ($result = $mysqli->query("SELECT id_archivo  FROM archivos where nombre='".$archivo."'")){
                  if ($result->num_rows > 0){
                    while ($row = $result->fetch_object()){
                      $id_archivo=$row->id_archivo;
                    }
                  }else{echo "<div class='w3-row w3-red '><h2>no se pudieron encontrar registros</h2></div>";}
                 }else{echo " <div class='w3-row w3-red '><h2>no se pudo realizar la consulta</h2></div>";}
                //////////////////////////////////////////
                 }else{echo " <div class='w3-row w3-red '><h2>No se ha podido subir el archivo</h2></div>";}
              }else{echo " <div class='w3-row w3-red '><h2>Formato de archivo no compatible</h2></div>";}
            //////////////////////////////////
          }//else cuando carga nueva imagen
                           /////////////////////////////////////////inserta en tabla programacion
                
                  if($nombre_salon==null){
                    /////////modifica tabla eventos
                      if($result = $mysqli->query("UPDATE `eventos` SET `nombre` = '$nombre_evento' , `texto` = '$texto_salon' , `tipo` = '$tipo_evento' WHERE `eventos`.`id_evento` = $id_evento;")){
                        echo " <div class='w3-row w3-green '><h2>El evento: $nombre_evento_anterior fue ha editad&oacute; con &eacute;xito</h2></div>";
                      }else{echo " <div class='w3-row w3-red '><h2>no se pudo editar bien eventos</h2></div>";}
                      ////////////////////////////////////////////////// 
                    ///////////////////////elimina el evento de la tabla programacion para volver a insertar
                    if(mysqli_query($mysqli,"DELETE FROM `programacion_salones` WHERE `programacion_salones`.`id_evento` = $id_evento")){
                    echo " <div class='w3-row w3-green '><h2>se ha eliminado la antigua programación</h2></div>";
                    }else{echo " <div class='w3-row w3-red '><h2>No se pudo eliminar</h2></div>";}
                    //////////////////////////////////////////////////////////////////////////////////////////////////////////////  
            for ($i = 0; $i < $count; $i++) {    
              if(mysqli_query($mysqli,"INSERT INTO `programacion_salones`(`id_pantalla`, `id_evento`, `id_archivo`, `fecha_transmision`, `fecha_inicio`, `fecha_fin`, `completo`, `nombre_salon`) VALUES ('$pantallas[$i]','$id_evento',$id_archivo,'$diatrans.$horatrans','$diainicio.$horainicio','$diafinal.$horafinal','$completo',(SELECT nombre FROM pantallas_salones where id_pantalla=".$pantallas[$i]."));")){
            /////////historial
            if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','editó',(Select CURRENT_TIMESTAMP),(SELECT nombre from eventos where id_evento=$id_evento),(SELECT nombre from pantallas_salones where id_pantalla=$pantallas[$i]))")){
                        echo " <div class='w3-row w3-green '><h2>Hay nuevos cambios en el historial</h2></div>";
                      }
              /////////historial 
              echo" <div class='w3-row w3-green '><h2>Se program&oacute; con &eacute;xito </h2></div>";
            }
          }//fin de ciclo for

          }else{ 
                    /////////modifica tabla eventos

              if($result = $mysqli->query("UPDATE `eventos` SET `nombre` = '$nombre_evento' , `texto` = '$texto_salon' , `tipo` = '$tipo_evento' WHERE `eventos`.`id_evento` = $id_evento;")){
                echo " <div class='w3-row w3-green '><h2>Se edito bien eventos</h2></div>";
                }else{echo " <div class='w3-row w3-red '><h2>no se pudo editar bien eventos</h2></div>";}
                //////////elimina todo de programacion
                if(mysqli_query($mysqli,"DELETE FROM `programacion_salones` WHERE `programacion_salones`.`id_evento` = $id_evento")){
              echo " <div class='w3-row w3-green '><h2>Se ha eliminado la antigua programación</h2></div>";
              }else{echo "<div class='w3-row w3-red '><h2>no se pudo eliminar la programacion</h2></div>";} 
                      ////////////////////////////////////////////////// 
            for ($i = 0; $i < $count; $i++) {      
            if(mysqli_query($mysqli,"INSERT INTO `programacion_salones`(`id_pantalla`, `id_evento`, `id_archivo`, `fecha_transmision`, `fecha_inicio`, `fecha_fin`, `completo`, `nombre_salon`) VALUES ('$pantallas[$i]','$id_evento',$id_archivo,'$diatrans.$horatrans','$diainicio.$horainicio','$diafinal.$horafinal','$completo','$nombre_salon');")){
            /////////historial
            if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','editó',(Select CURRENT_TIMESTAMP),(SELECT nombre from eventos where id_evento=$id_evento),(SELECT nombre from pantallas_salones where id_pantalla=$pantallas[$i]))")){echo " <div class='w3-row w3-green '><h2>Hay nuevos cambios en el historial</h2></div>";}
              /////////historial 
              echo" <div class='w3-row w3-green '><h2>Se program&oacute; con &eacute;xito </h2></div>";
            }
          }//fin de ciclo for
          echo "<div class='w3-row w3-green '><h2>Inicia a transmitirse el: <b>" . $diatrans ."</b> a las <b>". $horatrans ."</b><br>Termina: <b>". $diafinal ."<b/> A las <b>". $horafinal ."</b></h2></div>";
        }
        /////////////Elimina archivo si ya no se usa
         if ($result2 = $mysqli->query("SELECT id_archivo FROM `programacion_salones` where programacion_salones.id_archivo=$id_imagen")){
            if ($result2->num_rows > 0){
              //no elimina nada
              }else{
                    if($result2 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = $id_imagen")){
                  unlink("../imagenes/" .  $nombre_imagen);
                  echo "<div class='w3-row w3-green '><h2>se elimin&oacute; el archivo:<b>$nombre_imagen</b></h2></div>"; 
                  }
              }
         }else{echo "<div class='w3-row w3-red '><h4>no fue posible ejecutar el query</h4></div> ";}
          /////////////
      }
          ///////////////////////////////////////////
?>
<a href="index.php"><div class='w3-row w3-black '><h2>Regresar</h2></div></a>
          </center>
      </body>
</html>
<!--reserva-->




