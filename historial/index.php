<?php
include('../conexion.php');
include('../check.php');
   header("Content-Type: text/html;charset=utf-8");
 ?>
<!DOCTYPE html>  
<html>
<title>Inicio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<body class="w3-blue-grey">
<!--conexion -->
<?php
  ////////genera id para la imagen
  if ($result = $mysqli->query("SELECT min(fecha_accion) as 'min',max(fecha_accion) as 'max' from historial")){
    if ($result->num_rows > 0){
      while ($row = $result->fetch_object()){
      $max=$row->max;
      $min=$row->min;
        }
      }
    }


$test = new DateTime($min);
$test1 = new DateTime($min);
$fecha_min = $test1->format('Y-m-d');
$hora_min = $test->format('H:i');

$test = new DateTime($max);
$test1 = new DateTime($max);
$fecha_max = $test1->format('Y-m-d');
$hora_max = $test->format('H:i');
////


?>
  <!-- tabla de contenido del historial -->
<div class="w3-content w3-margin-top w3-center" style="width:100%;">

            <div class="w3-container w3-white" style="height: 100%;">
              <header class="w3-panel w3-flat-green-sea">
           <div class="w3-col "> <h2>Historial</h2></div>
          </header>
          <form class="w3-container " action="query.php" method="post" enctype="multipart/form-data" name="upsecundario"> 
              <div class="w3-quarter w3-left">
                      <div class="w3-panel w3-white w3-topbar w3-border-green">
                        <p>Fecha de inicio</p>
                        <input type="time" class=" w3-pale-green w3-input w3-round" name="horainicio" <?php echo "value ='" . $hora_min . "'";?> required>
                      <input type="date" class=" w3-pale-green w3-input w3-round" name="diainicio" <?php echo "value ='" . $fecha_min . "'";?> required>
                      </div>
                    </div>

                    <div class="w3-quarter w3-left">
                      <div class="w3-panel w3-white w3-topbar w3-border-red">
                        <!-- panel de fechas -->
                        <p>Fecha de terminaci&oacute;n</p>
                        <input type="time" class=" w3-pale-red w3-input w3-round" name="horafinal" <?php echo "value ='" . $hora_max. "'";?> required>
                      <input type="date" class=" w3-pale-red w3-input w3-round" name="diafinal" <?php echo "value ='" . $fecha_max . "'";?> required>
                      </div>
                    </div>
                    
                    <div class="w3-half w3-left">
                      <div class="w3-panel w3-white w3-topbar w3-border-blue">  
                      <br>              
                        <input class="w3-row w3-half w3-input w3-border-blue" type="text" name="usuario" placeholder="Buscar usuario...">

                        <select class="w3-select w3-row w3-half w3-blue " name="accion" id="tipo"  required>
                      <option value="4" selected>Todas las acciones</option>
                      <option value="1">Solo agregar</option>
                      <option value="2">Solo editar</option>
                      <option value="3">Solo eliminar</option>
                      </select>
                      <br>
                      <br>
                      <br>
                        <button class="w3-row  w3-btn w3-block w3-round-xxlarge w3-right w3-black w3-hover-blue w3-large  " type="submit">Buscar</button>
                      </div>
                    </div>
                </form>
            <?php
            //trae la tabla de otro archivo
              echo "<iframe  class='w3-card-4 w3-white w3-animate-zoom' style=".'display:block'." scrolling=".'yes'." frameBorder=".'0'." width=".'100%'." height=".'500'." class=".'w3-center'." src="."tabla.php?></iframe>";
            ?>
            <br>
            <form action="../inicio.php"><button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large " >Volver</button></form>
            <br>
            </div>
            <br>
          </div>

            
</body>
</html>