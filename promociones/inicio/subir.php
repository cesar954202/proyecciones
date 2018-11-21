
<html>
    <head>
      <title>Subir</title>
    </head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	     <body>
          <center>
            <?php
            include('../../conexion.php');
            include('../../check.php');
//variables
  $principal = $_POST["formato"];
  $diainicio = $_POST["diainicio"];
  $diafinal = $_POST["diafinal"];
  $horainicio = $_POST["horainicio"];
  $horafinal = $_POST["horafinal"];
  $date1 = new DateTime("now");
  $fechactual = $date1->format('Y-m-d H:i:s');
 //fin variables
  //destino
if($principal==2){
$principal=1;
}
///
$target_file = "../videos/" . basename($_FILES["miArchivo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);



if(isset($_POST["pantallas"])){
  $pantallas = $_POST["pantallas"];
  $count = count($pantallas);
}else {
  echo "<div class='w3-row w3-red '><h2>Debes seleccionar al menos una pantalla del menu para poder programar tu video.</h2></div>";
  $uploadOk = 0;
}
//conexion
//fin conexion
///fecha adecuada
if ($diainicio.$horainicio >= $diafinal.$horafinal){
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de inicio no debe ser mayor a la de termino.</h2></div>";
  $uploadOk = 0;
}
if ($diafinal.$horafinal <= $fechactual){
  echo "<div class='w3-row w3-red '><h2>La fecha y hora de termino es menor que la fecha actual.</h2></div>";
  $uploadOk = 0;
}
///fin fecha adecuada
// revisa si el archivo exiete
if (file_exists($target_file)) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos ya existe un archivo con ese nombre.</h2></div>";
    $uploadOk = 0;
}
//fin revisa si el archivo existe
// revisa si el tamaño es adecuado
if ($_FILES["miArchivo"]["size"] >= 500000000) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos, asegurate que tu archvio pese menos de 500 MB.</h2></div>";
    $uploadOk = 0;
}
// finrevisa si el tamaño es adecuado

  // se revisa la compatibilidad
if($imageFileType != "mp4" ) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos solo se pueden subir videos en formato MP4.</h2></div>";
    $uploadOk = 0;
}
// fin revisa la compatibilidad
//revisa si se subio con exito
if ($uploadOk == 0) {
    echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu video.</h2></div>";
// fin revisa si se subio con exito
} else {
    if (move_uploaded_file($_FILES["miArchivo"]["tmp_name"], $target_file)) {
      //se agregar el archivo a la carpeta
        //echo "El video ". basename( $_FILES["miArchivo"]["name"]). " fue agregado con exito. <br>";
        $archivo = basename( $_FILES["miArchivo"]["name"]);
        ///genera id para la imagen
        if ($result = $mysqli->query("SELECT MAX(id_archivo +1) as 'max' FROM archivos")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id=$row->max;
            }
          }
        }
        //////// remonbra la imagen
        $ruta=rename ( "../videos/".$_FILES["miArchivo"]["name"], "../videos/video_".$id.".mp4");
            $archivo="video_".$id.".mp4";
        //se inserta en la tabla archivo
        if(mysqli_query($mysqli,"INSERT INTO `archivos`( `nombre`) VALUES ('$archivo')")){
            echo"<div class='w3-row w3-green '><h2>Se guardado el video: <b>".basename( $_FILES["miArchivo"]["name"])."</b></h2></div>";
        }
        //fin de insertar en tabla archivo
        ////se inserta en la tabla programacion
            
        for ($i = 0; $i < $count; $i++) {
        //echo $sqlp;

            if(mysqli_query($mysqli,"INSERT INTO `programacion_promociones` (`id_pantalla`, `id_archivo`, `fecha_inicia`, `fecha_fin`, `principal`) VALUES ('$pantallas[$i]',(SELECT MAX(`id_archivo`) FROM `archivos`), '$diainicio.$horainicio','$diafinal.$horafinal', '$principal');")){
              echo"<div class='w3-row w3-green '><h2>Se program&oacute; con &eacute;xito en la pantalla </h2></div>";
            /////////historial

            if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','agregó',(Select CURRENT_TIMESTAMP),'$archivo',(select nombre from pantallas_promociones where id_pantalla=$pantallas[$i]))")){
              echo "<div class='w3-row w3-green'><h2>Hay nuevos cambios en el historial</h2></div>";
              }
            /////////historial
            }
             
          }     
        } else {echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu archivo. <br>Contacta el administardor y asegurate que este permitido subir archivos en el servidor.</h2></div>";}
      ////////////////////////////////
    }

?>
<a href="../index.php"><div class='w3-row w3-black '><h2>Regresar</h2></div></a>
          </center>
      </body>
</html>
<!--reserva-->


