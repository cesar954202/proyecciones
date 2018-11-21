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


   $i=0;
//cuadrado (salones)
if($formato=="cuadrado"){
    $archivos = array("index.php", "evento.php", "completa.php");
    while($i<3){
    $archivo = "../vista_previa/cuadrado/$archivos[$i]";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"Muestra\";$id_p=\"$id_programacion\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
    
      }
      echo"<script language='javascript'>window.location='../vista_previa/cuadrado/index.php'</script>;";
    }

       //vertical (salones)
if($formato=="vertical"){
    $archivos = array("index.php", "evento.php","completa.php");
    while($i<3){
    $archivo = "../vista_previa/vertical/$archivos[$i]";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"Muestra\";$id_p=\"$id_programacion\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
    
      }
      echo"<script language='javascript'>window.location='../vista_previa/vertical/index.php'</script>;";
    }

    //vertical dividido(salones)
if($formato=="vertical_dividido"){
    ////inserta la otra pantalla  
    $archivos = array("index.php","evento_corto.php", "completa.php");
    while($i<3){
    $archivo = "../vista_previa/vertical_dividido/$archivos[$i]";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $nombre_p=\"Muestra\";$id_p=\"$id_programacion\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
    
      }
      echo"<script language='javascript'>window.location='../vista_previa/vertical_dividido/index.php'</script>;";
    }

        
   


?>
