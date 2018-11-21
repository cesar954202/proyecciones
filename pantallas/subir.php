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
            include('../check.php');        
            include('../conexion.php');

  $nombre_pantalla = $_POST["nombre_pantalla"];
  $nombre_pantalla= str_replace(' ','_',$nombre_pantalla);
  $tipo = $_POST["tipo"];
  $formato= $_POST["formato"];

if($tipo==1){
  $tipo="salones";
}else{
  $tipo="promociones";
}

  if(mysqli_query($mysqli,"INSERT INTO `pantallas_".$tipo."` (nombre,formato) VALUES ('$nombre_pantalla','$formato');")){
           echo"<div class='w3-row w3-green '><h2>Se ha creado la pantalla: <b>$nombre_pantalla</b></h2></div>";}
  ////////id de la pantalla creada
        if ($result = $mysqli->query("SELECT id_pantalla FROM pantallas_".$tipo." where nombre='$nombre_pantalla'")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_pantalla=$row->id_pantalla;
            }
          }
        }
 ///////////////crear carpeta
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
$resultado=0;
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
    $resultado=1;
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
    $resultado=1;
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
    $resultado=1;
      }
    }
    //vertical dividido(salones)
if($formato=="vertical_dividido"){
    ////inserta la otra pantalla  
  $nombre_pantalla_2=$nombre_pantalla."_2";
  if(mysqli_query($mysqli,"INSERT INTO `pantallas_".$tipo."`(`nombre`) VALUES ('$nombre_pantalla_2');")){
           echo"<div class='w3-row w3-green '><h2>Se ha creado la pantalla: <b>$nombre_pantalla_2</b></h2></div>";}
  ////////id de la pantalla creada
        if ($result = $mysqli->query("SELECT id_pantalla FROM pantallas_".$tipo." where nombre='$nombre_pantalla_2'")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $id_pantalla_2=$row->id_pantalla;
            }
          }
        }
    /////
    $archivos = array("index.php", "evento_largo.php","evento_corto.php", "default.php", "completa.php");
    while($i<5){
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
    $resultado=1;
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
      $target_file = "../$tipo/pantallas/$nombre_pantalla/" . basename($_FILES["miArchivo"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      ///filtro de peso de imagen
      if ($_FILES["miArchivo"]["size"] > 500000000) {
        echo "<br><div class='w3-row w3-red '><h2>Lo sentimos, asegurate que tu archvio pese menos de 500 MB.</h2></div>";
        $uploadOk = 0;
      }
      //filtro archivo existente
      if (file_exists($target_file)) {
          echo "<br><div class='w3-row w3-red '><h2>Lo sentimos ya existe un archivo con ese nombre.</h2></div>";
          $uploadOk = 0;
      }
      //verificador
      if ($uploadOk == 0) {
        echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu imagen.</h2></div>";
      } else {
        if (move_uploaded_file($_FILES["miArchivo"]["tmp_name"], $target_file)) { ////1
        $imagen = basename( $_FILES["miArchivo"]["name"]);
      }else{echo "<div class='w3-row w3-red '><h2>Lo sentimos un error inesperado ocasiono que no subieramos tu imagen.</h2></div>";}
      }
    //fin imagen
    $contenido[0] = "<?php $nombre_p=\"$nombre_pantalla\";$id_p=\"$id_pantalla\";$baner=\"$imagen\" ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);
    $i++;
    $resultado=1;
    }

    if($resultado==1){
      if($result = $mysqli->query("INSERT INTO `historial`(`usuario`, `accion`, `fecha_accion`, `evento`, `pantalla`) VALUES ('$user_check','agregó',(Select CURRENT_TIMESTAMP),' Pantalla ".$nombre_pantalla."','N/A')")){
              echo "<div class='w3-row w3-green'><h2>Hay nuevos cambios en el historial</h2></div>";
              }
    }
?>
<a href="index.php"><div class='w3-row w3-black '><h2>Regresar</h2></div></a>
          </center>
      </body>
</html>
