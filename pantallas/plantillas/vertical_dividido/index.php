<?php $nombre_p="";$id_p1="";  $id_p_="";?>
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
<body >

<style type="text/css">
h1{font-size:80px;}
h2{font-size:40px;}
h3{font-size:30px;}
.w3-Courgette {font-family: "Courgette", serif;}
  .w3-oro {color:#000 !important; background-color:#c9a83f !important}
  .w3-plata {color:#000 !important; background-color:#333333 !important}

</style>
<header class="w3-container w3-plata w3-bottombar w3-border-amber w3-card-4 " style=" height: 640px " >

  <div class="w3-row w3-rest w3-center w3-bottombar w3-border-gray">
    <img src="../../imagenes/logo_hi.png" class="w3-center " style="height: 230px" >
  </div>
  
  
  <div class="w3-col w3-third " style="height: 398px">
    <div class="w3-panel"><h2 class="w3-text-white w3-center">Eventos del d&iacute;a</h2><br>
      <h2 class="w3-text-white w3-center w3-border-amber w3-bottombar w3-topbar ">Sal&oacute;n <?php echo $nombre_p; ?></h2></div>
  </div>

  <div class="w3-row w3-rest" style="height: 230px">
   <div class="w3-col w3-half w3-plata w3-center">
    <br><img src="../../imagenes/fumar.png" class="w3-center" style="height: 180px" >
  </div>

   <div class="w3-col w3-half  w3-center">
    <br><br><iframe src="../../reloj_tequila.php" style="overflow:hidden;" scrolling="no" frameBorder="0" width="350px" height="230" class="w3-center"></iframe>
  </div>
  </div>

    <div class="w3-row w3-rest">
   <div class="w3-col w3-threequarter w3-plata ">
    <div id="cont_04615d4bcc523aff55b427a2b2710cd1"><script type="text/javascript" async src="https://www.meteored.mx/wid_loader/04615d4bcc523aff55b427a2b2710cd1"></script></div>
  </div>
  </div>

</header>
<?php
include('../../../conexion.php');

//carga datos
      if ($result = $mysqli->query("SELECT programacion_salones.completo from programacion_salones WHERE programacion_salones.fecha_transmision <= (SELECT CURRENT_TIMESTAMP) AND (programacion_salones.id_pantalla=$id_p OR programacion_salones.id_pantalla=$id_p_2) AND programacion_salones.fecha_fin > (SELECT CURRENT_TIMESTAMP)")){
        if ($result->num_rows > 0){
          if($result->num_rows == 2){
            //carga los frame de ambas pantallas
            echo "<iframe src=".'evento_corto.php'."?pantalla='".$id_p."' style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'620'." class=".'w3-center'."></iframe><br>";
            echo "<iframe src=".'evento_corto.php'."?pantalla='".$id_p_2."' style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'620'." class=".'w3-center'."></iframe>";
          }else{
            while ($row = $result->fetch_object()){
            $completo=$row->completo;
              if($completo==false){
                ///carga solo un frame
              echo "<iframe src=".'evento_largo.php'." style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'1260'." class=".'w3-center'."></iframe>";
            }else{
              //carga un frame completo
              echo "<iframe src=".'completa.php'." style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'1260'." class=".'w3-center'."></iframe>";
            }
            }
          }      
          }else{
            //carga default
            echo "<iframe src=".'default.php'." style=".'overflow:hidden;'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'1275'." class=".'w3-center'."></iframe>";
          }
        }
////////
?>



</body>
</html>
<?php include('monitor.php');?>