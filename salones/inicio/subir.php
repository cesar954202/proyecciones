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
//variables
            include('../../check.php');        
            include('../../conexion.php');
  $nombre_evento = $_POST["nombre_evento"];
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
 //fin variables
///imagen subida
$target_file = "../imagenes/" . basename($_FILES["miArchivo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


//filtro de pantallas nulas
if(isset($_POST["pantallas"])){
  $pantallas = $_POST["pantallas"];
  $count = count($pantallas);
}else {
  echo "<div class='w3-row w3-red '><h2>Debes seleccionar al menos una pantalla del menu para poder programar tu evento. </h2></div>";
  $uploadOk = 0;
}
//filtro para fecha erronea
if ($diainicio.$horainicio >= $diafinal.$horafinal)
{
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de inicio no debe ser mayor a la de termino.</h2></div> ";
  $uploadOk = 0;
}
if ($diafinal.$horafinal <= $fechactual)
{
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de termino es menor que la fecha actual.</h2></div> ";
  $uploadOk = 0;
}
if ($diatrans.$horatrans > $diainicio.$horainicio)
{
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de transmisi&oacute;n es mayor que la fecha de inicio.</h2></div>";
  $uploadOk = 0;
}

// revisa si el tamaño es adecuado
if ($_FILES["miArchivo"]["size"] > 500000000) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos, asegurate que tu archvio pese menos de 500 MB.</h2></div>";
    $uploadOk = 0;
}

  ////////////////////////////filtro evento a la misma hora
  for ($i = 0; $i < $count; $i++) { 
        if ($result = $mysqli->query("(SELECT DISTINCT(id_evento) FROM programacion_salones WHERE programacion_salones.id_pantalla=$pantallas[$i])")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_evento=$row->id_evento;
            ///////////////////////////////////////////////////
            if ($result2 = $mysqli->query("SELECT DISTINCT(eventos.nombre) as 'evento',fecha_transmision,fecha_fin
FROM programacion_salones
INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
WHERE '$diatrans.$horatrans ' BETWEEN (SELECT fecha_transmision WHERE programacion_salones.id_evento = $id_evento) 
AND (SELECT programacion_salones.fecha_fin WHERE programacion_salones.id_evento = $id_evento) 
OR '$diafinal.$horafinal' BETWEEN (SELECT fecha_transmision WHERE programacion_salones.id_evento = $id_evento) AND (SELECT programacion_salones.fecha_fin WHERE programacion_salones.id_evento = $id_evento) 
OR (SELECT fecha_transmision WHERE programacion_salones.id_evento = $id_evento) BETWEEN '$diatrans.$horatrans ' AND '$diafinal.$horafinal' OR (SELECT programacion_salones.fecha_fin WHERE programacion_salones.id_evento = $id_evento)  BETWEEN '$diatrans.$horatrans ' AND '$diafinal.$horafinal';")){
              if ($result2->num_rows > 0){
                while ($row2 = $result2->fetch_object()){
                  $evento=$row2->evento;
                  echo "<div class='w3-row w3-red'><h2>El evento:<b>$evento</b> ya tiene un horario que interfiere, se transmite el:<b> $row2->fecha_transmision <b> y se termina el:</b> $row2->fecha_fin </b> </h2></div>";
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
  // se revisa la compatibilidad
if($imageFileType == "jpg" || $imageFileType == "JPG" ||$imageFileType == "JPEG" ||$imageFileType == "jpeg" ||$imageFileType == "PNG" ||$imageFileType == "png" ||$imageFileType == "GIF" ||$imageFileType == "gif") {

if ($uploadOk == 0) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu imagen.</h2></div>";
// fin revisa si se subio con exito
} else {
          //copia la imagen a la carpeta
            if (move_uploaded_file($_FILES["miArchivo"]["tmp_name"], $target_file)) { ////1
        $archivo = basename( $_FILES["miArchivo"]["name"]);
        ////////genera id para la imagen
        if ($result = $mysqli->query("SELECT MAX(id_archivo +1) as 'max' FROM archivos")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id=$row->max;
            }
          }
        }
        /// remonbra la imagen
        $ruta=rename ( "../imagenes/".$_FILES["miArchivo"]["name"], "../imagenes/imagen_".$id.".jpg");
            $archivo="imagen_".$id.".jpg";
        //se inserta en la tabla archivo
        if(mysqli_query($mysqli,"INSERT INTO `archivos`( `nombre`) VALUES ('$archivo')")){
            echo"<div class='w3-row w3-green '><h2>Se guardado la imagen: <b>".basename( $_FILES["miArchivo"]["name"])."</b></h2></div>";
        }
        //inserta el evento 
        if(mysqli_query($mysqli,"INSERT INTO `eventos`(`nombre`, `tipo`, `texto`) VALUES ('$nombre_evento','$tipo_evento','$texto_salon');")){
                echo"<div class='w3-row w3-green '><h2>Se ha creado el evento: <b>$nombre_evento</b></h2></div>";
            }
            ////////genera id para la imagen
        if ($result = $mysqli->query("SELECT MAX(id_evento) as 'max' FROM eventos")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_evento=$row->max;
            }
          }
        }
        //////// remonbra la imagen     

            if($nombre_salon==null){
              ////se inserta en la tabla programacion
            for ($i = 0; $i < $count; $i++) {         
            if(mysqli_query($mysqli,"INSERT INTO `programacion_salones`(`id_pantalla`, `id_evento`, `id_archivo`, `fecha_transmision`, `fecha_inicio`, `fecha_fin`, `completo`, `nombre_salon`) VALUES ('$pantallas[$i]','$id_evento',(Select id_archivo from archivos where nombre='$archivo'),'$diatrans.$horatrans','$diainicio.$horainicio','$diafinal.$horafinal','$completo',(SELECT nombre FROM pantallas_salones where id_pantalla=".$pantallas[$i]."));")){
                echo"<div class='w3-row w3-green '><h2>Se program&oacute; con &eacute;xito</h2></div>";
            }else{echo "<div class='w3-row w3-red '><h2>No fue posible insertar en la tabla programacion</h2></div>";}
               /////////historial
                      if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','agregó',(Select CURRENT_TIMESTAMP),(SELECT nombre from eventos where id_evento=$id_evento),(SELECT nombre from pantallas_salones where id_pantalla=$pantallas[$i]))")){
                        echo "<div class='w3-row w3-green '><h2>Hay nuevos cambios en el historial</h2></div>";
                      }else{echo "<div class='w3-row w3-red '><h2>No fue posible insertar en historial</h2></div>";}
   
          }//fin del for

          }else{
            for ($i = 0; $i < $count; $i++) {         
            if(mysqli_query($mysqli,"INSERT INTO `programacion_salones`(`id_pantalla`, `id_evento`, `id_archivo`, `fecha_transmision`, `fecha_inicio`, `fecha_fin`, `completo`, `nombre_salon`) VALUES ('$pantallas[$i]','$id_evento',(Select id_archivo from archivos where nombre='$archivo'),'$diatrans.$horatrans','$diainicio.$horainicio','$diafinal.$horafinal','$completo','$nombre_salon');")){
                echo"<div class='w3-row w3-green '><h2>Se program&oacute; con &eacute;xito</h2></div>";
            }else{echo "<div class='w3-row w3-red '><h2>No fue posible insertar en la tabla programacion</h2></div>";}
               /////////historial
                      if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','agregó',(Select CURRENT_TIMESTAMP),(SELECT nombre from eventos where id_evento=$id_evento),(SELECT nombre from pantallas_salones where id_pantalla=$pantallas[$i]))")){
                        echo "<div class='w3-row w3-green '><h2>Hay nuevos cambios en el historial</h2></div>";
                      }else{echo "<div class='w3-row w3-red '><h2>No fue posible insertar en historial</h2></div>";}   
          }
                  echo "<div class='w3-row w3-green '><h2>Inicia a transmitirse el: <b>" . $diatrans ."</b> a las <b>". $horatrans ."</b><br>Termina: <b>". $diafinal ."</b> A las <b>". $horafinal ."</b></h2></div>";


          }///fin insertar
         

        } else {echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu archivo. <br>Contacta el administardor y asegurate que este permitido subir archivos en el servidor.<h2></div>";}
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    }
    }else{echo "<div class='w3-row w3-red '><h2>Lo sentimos solo se pueden subir imagenes en este formato.</h2></div>";}

?>
<a href="index.php"><div class='w3-row w3-black '><h2>Regresar</h2></div></a>
          </center>
      </body>
</html>
<!--reserva-->




