<!DOCTYPE html>
<html>
<title>Tequila reposado </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">

<style type="text/css">
h1{font-size:60px;}
h2{font-size:50px;}
h3{font-size:40px;}
.w3-Courgette {font-family: "Courgette", serif;}
</style>
<?php
include('../../../conexion.php');
if(mysqli_connect_errno($mysqli)){
echo "Fallo conexion con el servidor por: ".mysqli_connect_error();
}
if($result = $mysqli->query("DELETE FROM `programacion_salones` WHERE (SELECT CURRENT_TIMESTAMP)>programacion_salones.fecha_fin"))
{
  //echo "Se borro con exito de programacion";
}else{

}
//carga datos
      if ($result = $mysqli->query("SELECT programacion_salones.id_archivo,archivos.nombre as 'imagen',eventos.nombre as 'evento',pantallas_salones.nombre,programacion_salones.fecha_inicio,eventos.tipo,eventos.texto,programacion_salones.nombre_salon
from programacion_salones 
INNER JOIN archivos ON archivos.id_archivo = programacion_salones.id_archivo
INNER JOIN eventos ON eventos.id_evento=programacion_salones.id_evento
INNER JOIN pantallas_salones on pantallas_salones.id_pantalla = programacion_salones.id_pantalla 
WHERE programacion_salones.fecha_transmision < (SELECT CURRENT_TIMESTAMP) 
AND (programacion_salones.id_pantalla=13 or programacion_salones.id_pantalla=14)
AND programacion_salones.fecha_fin > (SELECT CURRENT_TIMESTAMP)")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $nombre=$row->evento;
            $fecha_inicio=$row->fecha_inicio; 
            $test=new DateTime($fecha_inicio);
            $hora = $test->format('H:i a');
            $texto_salon=$row->texto;
            $tipo_evento=$row->tipo;
            $nombre_salon=$row->nombre_salon;
            $imagen="../../imagenes/".$row->imagen;
            }
          }
        }
////////
?>


<article class="w3-container w3-center" style="height: 1280px">
 
 <div class="w3-row w3-center">
   <br><img src=<?php echo $imagen;?> class="w3-center w3-card-4 w3-border w3-blue-gray w3-animate-top w3-round-xxlarge" style="height: 780px;width: 780px;padding:5px" >
 </div>

 <div class="w3-col  w3-left" style="width: 70%">

      <div class=" w3-container w3-bottombar w3-animate-left  w3-border-amber w3-text-dark-gray" style="text-shadow:1px 1px 0 #444 ">
        <h1 class=" w3-left text-shadow "  ><?php echo $nombre;?></h1> 
      </div>

        <div class=" w3-container  w3-bottombar w3-animate-left w3-border-dark-gray w3-text-dark-gray" style="text-shadow:1px 1px 0 #444">
          <h2 class=" w3-left text-shadow "><?php echo $tipo_evento;?></h2> 
        </div>

        <div class=" w3-container w3-animate-left " style="width: 1000px">
          <h3 class=" w3-left text-shadow "><?php echo $texto_salon;?></h3> 
        </div>
 </div>

 <div class="w3-col  w3-center w3-animate-right" style="width: 30%">
        <div class=" w3-container w3-center" style="text-shadow:1px 1px 0 #444">
          <br><br><h2><br><?php echo $hora;?></h2> 
        </div>
</div>
</article>



</body>
</html>