<?php
include('../../conexion.php');
include('../../check.php');
    //Obligatorio selección.
    //Obtenemos el dato del option seleccionado.
    //$locatario = trim($_POST['locatario']);
   $id_p="$"."id_p";
   $nombre_p="$"."nombre_p";
  $id_programacion = $_GET["id_programacion"];
   $formato = $_GET["formato"];


//horizontal
if($formato=="horizontal"){
    $archivo = "../vista_previa/horizontal/index.php";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"Muestra\";$id_p=\"$id_programacion\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
      echo"<script language='javascript'>window.location='../vista_previa/horizontal/index.php'</script>;";
    }

       //vertical (salones)
if($formato=="vertical_promo"){
    $archivo = "../vista_previa/vertical/index.php";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"Muestra\";$id_p=\"$id_programacion\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
      echo"<script language='javascript'>window.location='../vista_previa/vertical/index.php'</script>;";
    }


        
   


?>