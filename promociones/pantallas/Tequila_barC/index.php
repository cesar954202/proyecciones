<?php $nombre_p="Tequila_barC";$id_p="4"; ?>
<!DOCTYPE html>
<html>
<title><?php echo $nombre_p; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-khaki.css">
<body class="w3-black">
<!-- aqui -->
<style type="text/css">
  .w3-oro {color:#000 !important; background-color:#c9a83f !important}
  .w3-plata {color:#000 !important; background-color:#333333 !important}
</style>
<?php
include('../../../conexion.php');
if ($resultado = $mysqli->query("SELECT id_programacion,programacion_promociones.id_archivo,archivos.nombre from programacion_promociones INNER join archivos on archivos.id_archivo=programacion_promociones.id_archivo WHERE fecha_fin <= (select CURRENT_TIMESTAMP)")){
        if ($resultado->num_rows > 0){
          while ($row = $resultado->fetch_object()){
            if($result1 = $mysqli->query("DELETE FROM `programacion_promociones` WHERE `programacion_promociones`.`id_programacion` =".$row->id_programacion)){   
            //sin mensaje se elimina lo de programacion
                $exists = file_exists( "../../videos/" . $row->nombre );
                if($exists){
                  if($result3 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = ".$row->id_archivo)){
                  unlink("../../videos/" . $row->nombre);
                }
              }
            }
          }
        }
      }

?>


<script type="text/javascript">
function playlist(){
        var reproductor = document.getElementById("reproductor"),
        videos = [
          <?php
          //Codigo para mostrar solo los eventos programados
          $date1 = new DateTime("now");
          $fechactual = $date1->format('Y-m-d H:i:s');
          $result = mysqli_query($mysqli,"SELECT nombre 
          FROM `archivos` 
          INNER JOIN `programacion_promociones` on programacion_promociones.id_archivo=archivos.id_archivo
          WHERE programacion_promociones.principal =0
          and programacion_promociones.id_pantalla=$id_p
          and  (SELECT CURRENT_TIMESTAMP)<programacion_promociones.fecha_fin
          and  (SELECT CURRENT_TIMESTAMP) > programacion_promociones.fecha_inicia");
          if(mysqli_num_rows($result)>0){
              while($row = mysqli_fetch_assoc($result)){
                echo "\"../../videos/" . $row["nombre"] . "\",";
                
               }
           }

          else{
                  echo "\"../../videos/promociones.mp4\"";
             }

          ?>],


    info = document.getElementById("info");

    info.innerHTML = "Vídeo: " + videos[0];
    reproductor.src = videos[0];
    reproductor.play();

    reproductor.addEventListener("ended", function() {
         var nombreActual = info.innerHTML.split(": ")[1];
         var actual = videos.indexOf(nombreActual);
         actual = actual == videos.length - 1 ? 0 : actual + 1;
         this.src = videos[actual];
         info.innerHTML = "Vídeo: " + videos[actual];
         this.play();
    }, false);
}

function playlist2(){
        var reproductor2 = document.getElementById("reproductor2"),
        videos = [
          <?php
          //Codigo para mostrar solo los eventos programados
          $date1 = new DateTime("now");
          $fechactual = $date1->format('Y-m-d H:i:s');
          $result = mysqli_query($mysqli,"SELECT nombre 
          FROM `archivos` 
          INNER JOIN `programacion_promociones` on programacion_promociones.id_archivo=archivos.id_archivo
          WHERE programacion_promociones.principal =1
          and programacion_promociones.id_pantalla=$id_p
          and  (SELECT CURRENT_TIMESTAMP)<programacion_promociones.fecha_fin
          and  (SELECT CURRENT_TIMESTAMP) > programacion_promociones.fecha_inicia");
          if(mysqli_num_rows($result)>0){
              while($row = mysqli_fetch_assoc($result)){
                echo "\"../../videos/" . $row["nombre"] . "\",";
                
               }
           }

          else{
                  echo "\"../../videos/principal.mp4\"";
             }

          ?>],


    info2 = document.getElementById("info2");

    info2.innerHTML = "Vídeo: " + videos[0];
    reproductor2.src = videos[0];
    reproductor2.play();

    reproductor2.addEventListener("ended", function() {
         var nombreActual = info2.innerHTML.split(": ")[1];
         var actual = videos.indexOf(nombreActual);
         actual = actual == videos.length - 1 ? 0 : actual + 1;
         this.src = videos[actual];
         info2.innerHTML = "Vídeo: " + videos[actual];
         this.play();
    }, false);
}

function inicio(){
  playlist();
  playlist2();
}

window.onload = inicio;
</script>


<!--aqui-->
<meta http-equiv="refresh" content="600">
<div class="w3-row w3-oro">

  <div class="w3-container w3-left w3-plata" style="width: 25%;height: 186px">
    <br>
    <!--clima-->
    <div id="cont_6bf1383dc1c8b94f10e8f50bf8f50a85"><script type="text/javascript" async src="https://www.meteored.mx/wid_loader/6bf1383dc1c8b94f10e8f50bf8f50a85"></script></div>
  </div>
<!--imagen central-->
    <div class="w3-center w3-plata w3-third" >
      <img src="../../imagenes/baner.jpg" >
    </div>
<!--Reloj-->
  <div class="w3-container w3-right  w3-oro " style="width: 25%"> 
    <iframe src="../../reloj.php" style="overflow:hidden;" scrolling="no" frameBorder="0" width="327px" height="186" class="w3-left"></iframe>
  </div>

</div>
<!--video principal-->
<div class="w3-row w3-black" ><br>
  <div class="w3-container w3-twothird w3-black w3-animate-zoom" >
    <center>
      <label id="info2" hidden></label>
      <video height="500px"  id="reproductor2" class="w3-left" autoplay></video>
    </center>
  </div>
<div class="w3-container w3-third w3-black w3-animate-zoom" >
    <!--video promocion-->
    <center>
      <label id="info" hidden></label>
      <video height="500px"  class="w3-right" id="reproductor" autoplay></video>
    </center>
  </div>

</div>
  
<!--tercera parte-->


</body>
</html>

<?php include('monitor.php');?>