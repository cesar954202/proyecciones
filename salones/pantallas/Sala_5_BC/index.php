<?php $nombre_p="Sala_5_BC";$id_p="30"; ?>
<?php
include('../../../conexion.php');
//////////////eliminar automaticamente
if ($resultado = $mysqli->query("SELECT id_programacion,id_evento,programacion_salones.id_archivo,archivos.nombre from programacion_salones INNER join archivos on archivos.id_archivo=programacion_salones.id_archivo WHERE fecha_fin <= (select CURRENT_TIMESTAMP)")){
        if ($resultado->num_rows > 0){
          while ($row = $resultado->fetch_object()){
            if($result1 = $mysqli->query("DELETE FROM `programacion_salones` WHERE `programacion_salones`.`id_programacion` =".$row->id_programacion)){   
            //sin mensaje se elimina lo de programacion
              if($result2 = $mysqli->query("DELETE FROM `eventos` WHERE `id_evento` = ".$row->id_evento)){
                  //sin mensaje se elimina el evento
                $exists = file_exists( "../../imagenes/" . $row->nombre );
                if($exists){
                  if($result3 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = ".$row->id_archivo)){
                  unlink("../../imagenes/" . $row->nombre);
                 }
                }
              }
            }
          }
        }
      }
      ?>
<!DOCTYPE html>
<html>
<title><?php echo $nombre_p; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<script type="text/javascript">

function ping(){

   var pingserver = new Image();

   pingserver.src = "http://10.156.113.192/test.png";

 

   if (pingserver.height>0) {

      //alert("Online");

      window.location.replace('');

   } else {

      //alert("Offline");

      document.getElementById("estado").innerHTML = 'Esta offline ' + pingserver.height;

   }

}

window.onload = function() {

  setInterval(ping, 60000);

}
</script>

<style type="text/css">
h1{font-size:80px;}
h2{font-size:50px;}
h3{font-size:30px;}
.w3-Courgette {font-family: "Courgette", serif;}
</style>
<?php


////////////////////////////

//carga datos
      if ($result = $mysqli->query("SELECT programacion_salones.completo from programacion_salones WHERE programacion_salones.fecha_transmision < (SELECT CURRENT_TIMESTAMP) AND programacion_salones.id_pantalla=$id_p  AND programacion_salones.fecha_fin > (SELECT CURRENT_TIMESTAMP)")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $completo=$row->completo;
            }
            if($completo==false){
              echo "<iframe src=".'evento.php'." style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'1024px'." height=".'768px'." class=".'w3-left'."></iframe>";
            }else{
              echo "<iframe src=".'completa.php'." style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'1024px'." height=".'768'." class=".'w3-left'."></iframe>";
            }
          }else{
            echo "<iframe src=".'default.php'." style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'1024px'." height=".'768'." class=".'w3-left'."></iframe>";
          }
        }
////////
?>



</body>
</html>
<?php include('monitor.php');?>