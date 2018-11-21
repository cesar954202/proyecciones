<!DOCTYPE html>
<html>
<title>Directorio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body>

<style type="text/css">
h1{font-size:25px;}
h2{font-size:20px;}
h3{font-size:60px;}
.w3-Courgette {font-family: "Courgette", serif;}
</style>
<?php
include('../../../conexion.php');



//////// 
$id_evento=$_GET['id_evento'];
//echo "Evento_evento: ".$nombre_evento;
if ($result = $mysqli->query("SELECT programacion_salones.id_archivo,archivos.nombre as 'imagen',eventos.nombre as 'evento',GROUP_CONCAT(pantallas_salones.nombre SEPARATOR ', ')                           as 'nombre_salon' ,programacion_salones.fecha_inicio,eventos.tipo, eventos.texto 
                              from programacion_salones 
                              INNER JOIN archivos ON archivos.id_archivo = programacion_salones.id_archivo 
                              INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
                              INNER JOIN pantallas_salones on pantallas_salones.id_pantalla=programacion_salones.id_pantalla 
                              WHERE eventos.id_evento=$id_evento 
                              AND (select DATE_SUB(CURDATE(), INTERVAL -1 DAY)) > programacion_salones.fecha_inicio  
                              AND programacion_salones.fecha_fin > (SELECT CURRENT_TIMESTAMP)  order by fecha_inicio")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $nombre_evento=$row->evento;
            $fecha_inicio=$row->fecha_inicio; 
            $test=new DateTime($fecha_inicio);
            $hora = $test->format('H:i a');
            $tipo_evento=$row->tipo;
            $salon= str_replace('_',' ',$row->nombre_salon);
            $imagen="../../imagenes/".$row->imagen;
            }
          }
        }


?>


<article class="w3-container w3-animate-left " >

	<div class="w3-row ">

    <div class=" w3-col w3-left " style="width:20%">
        <img src=<?php echo $imagen ?> class="w3-left w3-card-4 w3-border w3-blue-gray w3-round-xxlarge" style="height: 200px;width: 200px;padding:5px" >
    </div>

		<div class=" w3-col w3-center " style="width:50%;height: 200px" >
    		<div class="w3-row w3-rest w3-bottombar w3-border-amber"><h1 class=" w3-left text-shadow" style="text-shadow:1px 1px 0 #444 "  > <?php echo $nombre_evento ?></h1></div>
        <div class="w3-row w3-rest w3-bottombar w3-border-gray"><h1 class=" w3-left text-shadow" style="text-shadow:1px 1px 0 #444 "  ><?php echo $tipo_evento ?></h1></div>
        <h1 class=" w3-left text-shadow" style="text-shadow:1px 1px 0 #444 "  ><?php echo $salon ?></h1>
  	</div>

      <div class=" w3-col w3-right " style="width:30%;height: 200px" >
        <br><br><h3 class=" w3-center text-shadow "  style="text-shadow:1px 1px 0 #444"  ><?php echo $hora ?></h3>
      </div>


	</div>

</article>



</body>
</html>