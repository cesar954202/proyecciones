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
          }//ciclo/////////////////////
        }
      }
      ?>
<!DOCTYPE html>
<html>
<title>Directorio</title>
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
<body bgcolor="white" >


<style type="text/css">
h1{font-size:80px;}
h2{font-size:70px;}
h3{font-size:50px;}
.mySlides {display:none;}
.w3-Courgette {font-family: "Courgette", serif;}
</style>


<header class="w3-container w3-dark-gray w3-bottombar w3-border-amber w3-card-4 " style=" height: 150px " >
  
  <div class="w3-col w3-third w3-left w3-dark-gray">
    <img src="../../imagenes/logo_hi.png" class="w3-center " style="height: 144px" >
  </div>

  <div class="w3-col w3-third w3-center w3-dark-gray">
    <iframe src="../../reloj.php" style="overflow:hidden;" scrolling="no" frameBorder="0" width="300px" height="139" class="w3-center"></iframe>
  </div>

  <div class="w3-col w3-third w3-right w3-dark-gray">
    <h2 class="w3-center text-shadow  w3-Courgette " style="text-shadow:1px 1px 0 #444">Bienvenido </h2>
  </div>
 
</header>

<div class="w3-panel w3-rest w3-center w3-topbar w3-bottombar w3-dark-gray w3-border-amber w3-card-4">
    <h3 class="w3-center text-shadow  w3-Courgette " style="text-shadow:1px 1px 0 #444">Eventos del d&iacute;a </h3>
  </div>

<?php



if ($result = $mysqli->query("SELECT COUNT(DISTINCT(eventos.id_evento)) as 'numero' from programacion_salones 
INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
WHERE  programacion_salones.fecha_fin >= (SELECT CURRENT_TIMESTAMP) AND fecha_inicio <= (select DATE_SUB(CURDATE(), INTERVAL -1 DAY)) order by fecha_inicio")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
               $numero=$row->numero; 
               //echo $numero;    
            }
            if($numero==0){
              echo "<iframe   style=".'display:block'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'1600'." class=".'w3-center'." src="."default.php></iframe>";
            }else{
              echo "<iframe   style=".'display:block'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'1600'." class=".'w3-center'." src="."frame1.php></iframe>";
            }
           
          }else{
            echo "<iframe   style=".'display:block'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'1600'." class=".'w3-center'." src="."default.php></iframe>";
        }
      }
        
?>
<div class="w3-row w3-dark-gray w3-border-amber w3-topbar" style="height: 30px"></div>
</body>


</html>
<?php include('monitor.php');?>

