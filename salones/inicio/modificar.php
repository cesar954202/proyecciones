
<!DOCTYPE html>
<html>
<title>Modificar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-teal.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<body class="w3-blue-grey">
<!--conexion -->
<?php

include('../../conexion.php');
//$archivo = $_GET["archivo"];
//$id_evento = $_GET["id_evento"];
$id_programacion = $_GET["id_programacion"];
$id_evento = $_GET["id_evento"];
$date1 = new DateTime("now");
$fechactual = $date1->format('Y-m-d');
$date1 = new DateTime("now");
$horaactual = $date1->format('H:i');
?>
  <!-- Page Container -->
  <div id="modificar" class="w3-content w3-margin-top w3-white" style="max-width:90%;">
    <header class="w3-container w3-amber w3-border-bottom w3-border-amber"> 
    <form class="w3-container w3-animate-zoom" action="cambiar.php" method="post" enctype="multipart/form-data" name="upsecundario"> 
        <center><h2>Editar</h2></center>
      </header>
      <div class="w3-row w3-white">
      <div class="w3-container w3-white w3-third " >
        <br>
        <div class="w3-center ">Pantallas</div>
 <?php

                
    $result = $mysqli->query("SELECT pantallas_salones.id_pantalla FROM pantallas_salones 
INNER JOIN programacion_salones on programacion_salones.id_pantalla=pantallas_salones.id_pantalla
WHERE programacion_salones.id_evento=$id_evento");
    if ($result->num_rows > 0){       
    while ($row = $result->fetch_object()){        
        $id_pantalla=$row->id_pantalla;
    }
  }
      $sqlquery2 = "SELECT pantallas_salones.id_pantalla as 'id_pantalla',nombre FROM pantallas_salones";
      $sqlquery3 = "SELECT programacion_salones.id_pantalla as 'id_pantallas' FROM programacion_salones WHERE `id_evento` = $id_evento ";  
      
      if ($result2 = $mysqli->query($sqlquery2)){

        if ($result2->num_rows > 0){

          while ($row2 = $result2->fetch_object()){
            $seleccion_checkbox = "";

            if ($result3 = $mysqli->query($sqlquery3)){
              
              if ($result3->num_rows > 0){

                while ($row3 = $result3->fetch_object()){
                  
                  if($row3->id_pantallas == $row2->id_pantalla){
                    $seleccion_checkbox = "checked";}
                }
              }
            }
            echo "<input class=".'w3-check'." type='checkbox' name='pantallas[]' value=' $row2->id_pantalla ' $seleccion_checkbox > $row2->nombre <br>";
          }
        }
    }

     ?>

        <br>
      </div>
      <div class="w3-container w3-white w3-twothird">
        <br>
        
          <div class="w3-row ">
            <div class="w3-col w3-third">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
              <?php 
              $result = $mysqli->query("SELECT archivos.nombre as 'archivo',eventos.nombre as 'evento',eventos.tipo,eventos.texto,programacion_salones.completo,programacion_salones.nombre_salon as 'nombre_salon',programacion_salones.fecha_transmision,programacion_salones.fecha_inicio,programacion_salones.fecha_fin
FROM programacion_salones
INNER JOIN eventos on eventos.id_evento=programacion_salones.id_evento
INNER JOIN archivos on archivos.id_archivo=programacion_salones.id_archivo
WHERE id_programacion=$id_programacion");
                while ($row = $result->fetch_object()){
                  $evento = $row->evento;
                  $texto = $row->texto;
                  $nombre_salon=$row->nombre_salon;
                  $tipo=$row->tipo;
                  $completo=$row->completo;
                  $archivo=$row->archivo;
                  $fecha_tras =$row->fecha_transmision; 
                  $fecha_in = $row->fecha_inicio;
                  $fecha_fn = $row->fecha_fin;
                }
                
                echo "<input class="."w3-input w3-border-bottom w3-border-black ". "name=". "nombre_evento". " maxlength=". "30". " value='".$evento."'". " type=". "text"." required><label>Nombre del evento</label>";
              ?>
                <input type="text" name="nombre_evento_anterior" hidden <?php echo "value ='" . $evento . "'";?>>
              </div>
              <br>
            </div>

            <div class="w3-col w3-third">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
              <?php 
                echo "<input class=". "w3-input w3-border-bottom w3-border-black "." name="."texto_salon ". " maxlength="."20"." value='".$texto."'"." type="."text"." ><label >Texto del Sal&oacute;n</label>";
              ?>
            </div>
            </div>

            <div class="w3-col w3-third">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
                <?php 

                echo "<input class=". "w3-input w3-border-bottom w3-border-black "."name="."nombre_salon ". " maxlength="."20"." value='".$nombre_salon."'"." type="."text"." ><label >Nombre del Sal&oacute;n</label>";
              ?>
              </div>
              <br>
            </div>
          </div>

            <div class="w3-col w3-half">

              
              <div class="w3-panel w3-white w3-leftbar w3-border-white w3-left">
                <?php 


                echo "<input class=". "w3-input w3-border-bottom w3-border-black ". "name=". "tipo_evento". " type="."text"." required value='".$tipo."'"." type="."text"." maxlength='20'  ><label >Tipo de Evento</label>";
              ?>
                </div>
                <div class="w3-col ">
                   <div class="w3-panel w3-white w3-leftbar w3-border-white">
              <label >Pantalla Completa</label><br>
              <?php 
              
                
                if($completo == false){
                 echo "&nbsp;<input class="."w3-radio ". " type=". "radio". " name='". "completo". "'' value="."1"."><label >Si</label>&nbsp;&nbsp;";
                 echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="."w3-radio ". " type=". "radio"." name='". "completo". "' value='"."0"."' checked><label >No</label>";
                }else{
                 echo "&nbsp;<input class="."w3-radio ". " type=". "radio". " name='". "completo". "' value="."1"." checked><label >Si</label>&nbsp;&nbsp;";
                 echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="."w3-radio ". " type=". "radio"." name='". "completo". "' value="."0"." ><label >No</label>";
                }
                
              ?>

            </div>

                </div>

              </div>
                    <div class="w3-col w3-half w3-center"><div class="w3-panel  " style="height: 200px; width: 100%"><input class="w3-btn w3-block w3-black   w3-center-align  w3-round-xlarge"  type="file" name="miArchivo" id="miArchivo" value="mismo" accept="image/jpeg,image/png">
                    <?php echo " <img src="."../imagenes/".$archivo." class='w3-center'  style='height: 150px;width: 150px' >";?>
                    </div>
                  </div>
                  <input type="w3-input" name="archivo_anterior" hidden <?php echo "value ='" . $archivo . "'";?>>
       <div class="w3-panel w3-white w3-leftbar w3-border-blue w3-third">
          <p>Inicio transmisi&oacute;n</p>
             <?php 

                    $test = new DateTime($fecha_tras);
                    $test1 = new DateTime($fecha_tras);
                    $fecha_t = $test1->format('Y-m-d');
                    $hora_t = $test->format('H:i');

                    $test = new DateTime($fecha_in);
                    $test1 = new DateTime($fecha_in);
                    $fecha_i = $test1->format('Y-m-d');
                    $hora_i = $test->format('H:i');

                    $test = new DateTime($fecha_fn);
                    $test1 = new DateTime($fecha_fn);
                    $fecha_f = $test1->format('Y-m-d');
                    $hora_f = $test->format('H:i');
                
                
              ?>
          <input type="time" class=" w3-pale-blue w3-input w3-round" name="horatrans" <?php echo "value ='" . $hora_t . "'";?> required>
          <input type="date" class=" w3-pale-blue w3-input w3-round" name="diatrans" <?php echo "value ='" . $fecha_t . "'";?> required>
          <input name="imagen_anterior" <?php echo "value ='" .$archivo. "'";?> type="hidden">
          <input name="id_programacion" <?php echo "value ='" .$id_programacion. "'";?> type="hidden">
          <input name="id_evento" <?php echo "value ='" .$id_evento. "'";?> type="hidden">
          
        </div>

        <div class="w3-panel w3-white w3-leftbar w3-border-green w3-third">
          <p>Fecha inicio</p>
          <input type="time" class=" w3-pale-green w3-input w3-round" name="horainicio" <?php echo "value ='" . $hora_i . "'";?> required>
          <input type="date" class=" w3-pale-green w3-input w3-round" name="diainicio" <?php echo "value ='" . $fecha_i . "'";?> required>
        </div>

        <div class="w3-panel w3-white w3-leftbar w3-border-red w3-third">
          <p>Fecha termina</p>
          <input type="time" class=" w3-pale-red w3-input w3-round" name="horafinal" <?php echo "value ='" . $hora_f . "'";?> required>
          <input type="date" class=" w3-pale-red w3-input w3-round" name="diafinal" <?php echo "value ='" . $fecha_f . "'";?> required>
        </div>

      </div>
    </div><br><br>     
  <footer class="w3-container w3-black"><br>
 <!-- <button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large w3-quarter w3-half"  onclick="volver();">Cerrar</button>-->
        <button class="w3-btn w3-block  w3-right w3-black w3-hover-blue w3-large  w3-half" type="submit">Guardar</button>
        </form>
              <button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large w3-half "  onclick="volver();">Regresar</button>
        </div><br><br>
 </footer>
  
  </div>  
 </div>
 </div>
<script type="text/javascript">
  function volver(){
    history.back(); 
  }
</script>
</body>
</html>