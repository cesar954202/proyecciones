<!DOCTYPE html>
<html>
<title>Directorio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body bgcolor="white" >
  <?php
include('../../../conexion.php');

?>
  <?php
if ($result = $mysqli->query("SELECT COUNT(DISTINCT(eventos.id_evento)) as 'numero' from programacion_salones 
                              INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
                              WHERE  programacion_salones.fecha_fin >= (SELECT CURRENT_TIMESTAMP) 
                              AND fecha_inicio <= (select DATE_SUB(CURDATE(), INTERVAL -1 DAY))")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $numero=$row->numero;
            if($numero>12){
              echo "<META HTTP-EQUIV=".'REFRESH'." CONTENT=".'15;URL=frame3.php'.">";
            }else{
              echo "<META HTTP-EQUIV=".'REFRESH'." CONTENT=".'15;URL=frame1.php'.">";
            }
            
            }
          }else{
            
          }
        }

?>

<style type="text/css">
h1{font-size:80px;}
h2{font-size:70px;}
h3{font-size:50px;}
.mySlides {display:none;}
.w3-Courgette {font-family: "Courgette", serif;}
</style>




<?php
if ($result = $mysqli->query("SELECT DISTINCT(eventos.id_evento) as 'evento' from programacion_salones  
                              INNER JOIN eventos ON programacion_salones.id_evento=eventos.id_evento
                              WHERE programacion_salones.fecha_fin >= (SELECT CURRENT_TIMESTAMP) 
                              AND fecha_inicio <= (select DATE_SUB(CURDATE(), INTERVAL -1 DAY)) ORDER BY fecha_inicio limit 6,6")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $evento=$row->evento;
            //echo "evento: ".$evento;
            $cuadro="<iframe  class=".'w3-card-4'." style=".'display:block'." scrolling=".'no'." frameBorder=".'0'." width=".'100%'." height=".'220'." class=".'w3-center'." src="."evento.php?id_evento=". urlencode($evento) ."></iframe><br><br>";
            echo $cuadro;
            
            }
          }else{
            
          }
        }

?>
</body>


</html>

