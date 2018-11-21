
<?php 
include('../check.php');
include('../conexion.php');
$id_pantalla=$_GET['id_pantalla'];
$tipo=$_GET['tipo'];
$nombre_pantalla=$_GET['nombre'];
   
?>
<!DOCTYPE html>
<html>
<title>Eliminar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<body class="w3-blue-gray">
  <!--modal elimina-->
    <form class="w3-container w3-center w3-animate-zoom " action="confirmacion.php" method="post" enctype="multipart/form-data" name="upsecundario" >
      <input type="text" name="id_pantalla" value=<?php echo $id_pantalla;?> hidden>
      <input type="text" name="tipo" value=<?php echo $tipo;?> hidden>
      <input type="text" name="nombre_pantalla" value=<?php echo $nombre_pantalla;?> hidden>
      <div class="w3-container w3-center" >
      <header class="w3-container w3-pink w3-border-bottom w3-border-black w3-center" > 
        <center><h2>¿Estas seguro de eliminar esta pantalla?</h2></center>
      </header>

      <?php  
      if($tipo=="salones"){
        $consulta= "SELECT eventos.nombre as 'info' 
  FROM programacion_salones 
INNER join eventos on eventos.id_evento=programacion_salones.id_evento 
INNER JOIN pantallas_salones on pantallas_salones.id_pantalla=programacion_salones.id_pantalla 
where programacion_salones.id_pantalla=$id_pantalla or pantallas_salones.nombre='$nombre_pantalla"."_2'";
      }else{
        $consulta= "SELECT archivos.nombre AS 'info' FROM programacion_promociones INNER JOIN archivos on archivos.id_archivo=programacion_promociones.id_archivo where id_pantalla=$id_pantalla ";
      }
       ////////colsulta de tabla
        if ($result = $mysqli->query($consulta)){
        if ($result->num_rows > 0){
          echo " <div class='w3-row w3-dark-gray'><h3 class='w3-center'>Algunos eventos o videos tambien se eliminar&aacute;n</h3></div>";
          while ($row = $result->fetch_object()){
            echo "<div class='w3-row w3-pale-red '><h4 class='w3-center'>$row->info</h4></div>";
            }
          }else{echo "<div class='w3-row w3-pale-blue '><h4 class='w3-center'>No hay eventos ni videos que dependan de esta pantalla</h4></div>";}
        }

      ?>

            
      <footer class="w3-container w3-black">
        <br>   
        <button class="w3-btn w3-block  w3-right w3-black w3-hover-green w3-large w3-quarter w3-half"  >Si</button>
        </form>
        <form action="index.php"><button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large w3-quarter w3-half" >No</button></form>
      </footer>
      
      </div>
  

</body>
</html>
    <!--fin modal nuevo-->