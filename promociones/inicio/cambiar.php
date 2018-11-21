
<html>
    <head>
    </head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	     <body>
          <center>
            <?php
            include('../../conexion.php');
            include('../../check.php');
//variables
  $principal = $_POST["formato"];
  $id_archivo_anterior = $_POST["id_archivo"];
  $diainicio = $_POST["diainicio"];
  $diafinal = $_POST["diafinal"];
  $horainicio = $_POST["horainicio"];
  $horafinal = $_POST["horafinal"];
  $date1 = new DateTime("now");
  $fechactual = $date1->format('Y-m-d H:i:s');
  $archivo_anterior=$_POST['archivo'];
 //fin variables
  $uploadOk = 1;

if($principal==2){
$principal=1;
}

if(isset($_POST["pantallas"])){
  $pantallas = $_POST["pantallas"];
  $count = count($pantallas);
}else {
  echo "<div class='w3-row w3-red '><h2>Debes seleccionar al menos una pantalla del menu para poder programar tu video.</h2></div>";
  $uploadOk = 0;
}    

      $target_file = "../videos/".basename($_FILES["miArchivo"]["name"]);
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//conexion
//fin conexion
///fecha adecuada
if ($diainicio.$horainicio > $diafinal.$horafinal)
{
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de inicio no debe ser mayor a la de termino.</h2></div>";
  $uploadOk = 0;
}
if ($diafinal.$horafinal < $fechactual)
{
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de termino es menor que la fecha actual.</h2></div>";
  $uploadOk = 0;
}
// revisa si el tamaño es adecuado
if ($_FILES["miArchivo"]["size"] > 500000000) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos, asegurate que tu archvio pese menos de 500 MB.</h2></div>";
    $uploadOk = 0;
}
// revisa si se subio con exito
if ($uploadOk == 0) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu video.</h2></div>";
} else {

    $archivo = basename( $_FILES["miArchivo"]["name"]);
    ///revisa si la variable archivo esta vacia, esto para subir nueva imagen o mantener la misma
    if (empty($archivo)) {
      $video=$_POST['archivo'];
      $id_archivo=$_POST['id_archivo'];
    }else{

    if (move_uploaded_file($_FILES["miArchivo"]["tmp_name"], $target_file)) {
      
        if($imageFileType != "mp4" ) {
          echo "<div class='w3-row w3-red '><h2>Lo sentimos solo se pueden subir videos en formato MP4.</h2></div>";
          }else{
        if ($result = $mysqli->query("SELECT MAX(id_archivo +1) as 'max' FROM archivos")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id=$row->max;
            } 
          }
        }
        //renombra la imagen
        $ruta=rename ( "../videos/".$_FILES["miArchivo"]["name"], "../videos/video_".$id.".mp4");
      $video="video_".$id.".mp4";
      $id_archivo="(SELECT id_archivo FROM `archivos` where nombre='$video')";
      }
        
        //se inserta en la tabla archivo
        if(mysqli_query($mysqli,"INSERT INTO `archivos`( `nombre`) VALUES ('$video')")){
            echo"<div class='w3-row w3-green '><h2>Se guardado el video: <b>".basename( $_FILES["miArchivo"]["name"])."</b></h2></div>";
            ///////////////////////////////////////////////////////////////////// inserta en tabla programacion y archivo
              if($result = $mysqli->query("SELECT * FROM `programacion_promociones` WHERE id_archivo=".$id_archivo_anterior)){
                if ($result->num_rows > 0){
                  echo "<div class='w3-row w3-green '><h2>Se ha eliminado con &eacute;xito el video:<b>$archivo_anterior</b></h2></div>";
                    unlink("../videos/" . $archivo_anterior);
                    if($result = $mysqli->query("DELETE FROM `archivos` WHERE `archivos`.`id_archivo` = ".$id_archivo_anterior)){ 
                      echo "<div class='w3-row w3-green '><h2>Se borr&oacute; con &eacute;xito la programaci&oacute;n</h2></div>";
                    }else{echo "<div class='w3-row w3-red'><h2>No se pudo borrar</h2></div>";}    
                  }
                }else{echo "<div class='w3-row w3-red '><h2>No fue posible consultar las programaciones del archivo</h2></div>";}
            
          //////////////////////////////////////////////////////////////
            
        }

          } else {echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu archivo. <br>Contacta el administardor y asegurate que este permitido subir archivos en el servidor.</h2></div>";} 
          } 
          
          if(mysqli_query($mysqli,"DELETE FROM `programacion_promociones` WHERE  id_archivo=$id_archivo_anterior")){
              echo "<div class='w3-row w3-green '><h2>se ha eliminado la antigua programaci&oacute;n</h2></div>";
              }else{echo "<div class='w3-row w3-red'><h2>No se pudo eliminar la programaci&oacute;</h2></div>";}

        for ($i = 0; $i < $count; $i++) {

            if(mysqli_query($mysqli,"INSERT INTO `programacion_promociones` (`id_pantalla`, `id_archivo`, `fecha_inicia`, `fecha_fin`, `principal`) VALUES ('$pantallas[$i]', $id_archivo, '$diainicio.$horainicio','$diafinal.$horafinal', '$principal');")){
              echo"<div class='w3-row w3-green '><h2>Se program&oacute; con &eacute;xito en la pantalla </h2></div>";
            /////////historial
            if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','editó',(Select CURRENT_TIMESTAMP),'$video',(select nombre from pantallas_promociones where id_pantalla=$pantallas[$i]))")){
              echo "<div class='w3-row w3-green'><h2>Hay nuevos cambios en el historial</h2></div>";
              }
            /////////historial

            }    
          }//fin del for     

      ////////////////////////////////
    }

?>
<a href="../index.php"><div class='w3-row w3-black '><h2>Regresar</h2></div></a>
          </center>
      </body>
</html>
<!--reserva-->


