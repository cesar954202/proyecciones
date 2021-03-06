<!DOCTYPE html>
<html>
<title>Barrica</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body BACKGROUND="../../imagenes/fondo.jpg">
<style type="text/css">

h1{font-size:70px;}
h2{font-size:60px;}
h3{font-size:50px;}
h4{font-size:40px;}
.w3-Courgette {font-family: "Courgette", serif;}
  .w3-oro {color:#000 !important; background-color:#c9a83f !important}
  .w3-plata {color:#000 !important; background-color:#333333 !important}
</style>
<?php
include('../../../conexion.php');
if(mysqli_connect_errno($mysqli)){
echo "Fallo conexion con el servidor por: ".mysqli_connect_error();
}

//carga datos
      if ($result = $mysqli->query("SELECT programacion_salones.id_archivo,archivos.nombre as 'imagen',eventos.nombre AS 'evento',programacion_salones.nombre_salon,programacion_salones.fecha_inicio,eventos.tipo, eventos.texto 
        from programacion_salones 
        INNER JOIN archivos ON archivos.id_archivo = programacion_salones.id_archivo
        INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
        WHERE programacion_salones.fecha_transmision <= (SELECT CURRENT_TIMESTAMP) 
        AND programacion_salones.id_pantalla=6 
        AND programacion_salones.fecha_fin >= (SELECT CURRENT_TIMESTAMP)")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            $evento=$row->evento;
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

<header class="w3-container w3-dark-gray w3-bottombar w3-border-amber w3-card-4 " style=" height: 150px " >
  <div class="w3-col w3-third w3-left">
    <img src="../../imagenes/logo_hi.png" class="w3-left " style="height: 144px" >
  </div>
  <div class="w3-col w3-twothird w3-right">
    <?php 
        //echo strlen($nombre);
        if(strlen($nombre_salon)<12){
        echo "<h1 class='w3-right w3-Courgette'>Sal&oacute;n ".$nombre_salon."</h1>";
        }else{
          if(strlen($nombre_salon)<20){
        echo "<h2 class='w3-right w3-Courgette'>Sal&oacute;n ".$nombre_salon."</h2>";
        }else{
         if(strlen($nombre_salon)<31){
        echo "<h3 class='w3-right w3-Courgette'>Sal&oacute;n ".$nombre_salon."</h3>";
        } 
        }
        }
        ?>
  </div>
  
</header>

<article class="w3-container" style="height: 468px">

  <div class="w3-row ">

  <div class="w3-row" >
    <div class=" w3-container ">

        <?php 
        //echo strlen($nombre);
        if(strlen($evento)<12){
        echo "<h1 class=" .'w3-left'.  ">".$evento."</h1>";
        }else{
          if(strlen($evento)<20){
        echo "<h2 class=" .'w3-left'.  ">".$evento."</h2>";
        }else{
         if(strlen($evento)<31){
        echo "<h3 class=" .'w3-left'.  ">".$evento."</h3>";
        } 
        }
        }
        ?>
        
      </div>
  		</div>
  		<br>
  	<div class="w3-row" >
  		<div class="w3-col w3-third" >
			<div class=" w3-container "  style="height: 280px; max-width: 300px"><br>
    				<img src=<?php echo $imagen;?> class="w3-left w3-card-4 w3-border w3-blue-gray w3-round-xxlarge" style="height: 250px;width: 300px;padding:5px" >
  			</div>
  		</div>

  		<div class="w3-col w3-twothird" >
  			
        <div class=" w3-container w3-rest w3-bottombar w3-border-gray w3-text-amber" style="text-shadow:1px 1px 0 #444">
    			<h2><?php echo $tipo_evento;?></h2> 
  			</div>

  			<div class=" w3-container w3-rest" style="text-shadow:1px 1px 0 #444">
    			<h2><?php echo $hora;?></h2> 
  			</div>

        <div class=" w3-container w3-rest " >
          <h3><?php echo $texto_salon;?></h3> 
        </div>

  		</div>

	</div>

		
	

	</div>

	

	</div>

</article>

<footer class="w3-container w3-dark-gray w3-topbar w3-border-amber" style="height: 150px">
  <div class="w3-row">
  	<div class="w3-col w3-third w3-left">
  		<center><h3 class="w3-xxlarge">Sal&oacute;n Barrica</h3>
  		<h3 class="w3-topbar w3-border-amber w3-xxlarge">Bienvenido</h3></center>
  	</div>
  	<div class="w3-col w3-third w3-center" ><br>
  		<img src="../../imagenes/fumar.png" class="w3-center" style="height: 110px" >
  	</div>
  	<div class="w3-col w3-third w3-right">
  		<iframe src="../../reloj.php" style="overflow:hidden;" scrolling="no" frameBorder="0" width="340px" height="139" class="w3-center"></iframe>
  	</div>
  </div>
</footer>

</body>
</html>