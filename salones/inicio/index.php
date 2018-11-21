 <?php
include('../../check.php');
include('../../conexion.php');
   header("Content-Type: text/html;charset=utf-8");
 ?>
 <!DOCTYPE html>
<html>
<title>Inicio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<body class="w3-white">
  <!--conexion -->
<?php
$date1 = new DateTime("now");
$fechactual = $date1->format('Y-m-d');
$date1 = new DateTime("now");
$horaactual = $date1->format('H:i');
//////////////eliminar automaticamente
if ($resultado = $mysqli->query("SELECT id_programacion,id_evento,programacion_salones.id_archivo,archivos.nombre from programacion_salones INNER join archivos on archivos.id_archivo=programacion_salones.id_archivo WHERE fecha_fin <= (select CURRENT_TIMESTAMP)")){
        if ($resultado->num_rows > 0){
          while ($row = $resultado->fetch_object()){
            if($result1 = $mysqli->query("DELETE FROM `programacion_salones` WHERE `programacion_salones`.`id_programacion` =".$row->id_programacion)){   
            //sin mensaje se elimina lo de programacion
              if($result2 = $mysqli->query("DELETE FROM `eventos` WHERE `id_evento` = ".$row->id_evento)){
                  //sin mensaje se elimina el evento
                $exists = file_exists( "../imagenes/" . $row->nombre );
                if($exists){
                  if($result3 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = ".$row->id_archivo)){
                  unlink("../imagenes/" . $row->nombre);
                 }
                }
              }
            }
          }//ciclo
        }
      }
?>

<script>
function openRightMenu() {
    document.getElementById("rightMenu").style.display = "block";
}
function closeRightMenu() {
    document.getElementById("rightMenu").style.display = "none";
}
</script>
<div class="w3-sidebar w3-bar-block w3-center w3-black w3-xxlarge w3-right w3-animate-left" style="width:130px;display:none" id="rightMenu">
  <a onclick="closeRightMenu()" class="w3-bar-item w3-button w3-hover-red"><i class="w3-center fa fa-close"><h6>Cerrar</h6></i></a>
  <a href="../../inicio.php" class="w3-bar-item w3-button w3-hover-amber w3-center"><i class="w3-center fa fa-home"><h6>Inicio</h6></i></a>   
  <a href="../pantallas/directorio/index.php" target="_blank" class="w3-bar-item w3-button w3-hover-amber w3-center"><i class="w3-center fa fa-book"><h6>Directorio</h6></i></a>
  <?php if($user_check == 'admin'){
    echo "<a  href='../../pantallas/index.php' class='w3-bar-item w3-button w3-center w3-hover-amber' ><i class='material-icons w3-center '' style='font-size:50px;color:white' hidden>tv</i><h6>Pantallas</h6></a>";
  }
    ?>
  
  <a href="../../promociones/index.php" class="w3-bar-item w3-button w3-center w3-hover-amber"><i class="material-icons w3-center " style="font-size:40px;color:white">movie</i><h6>Promociones</h6></a> 
  <a href="../../historial/index.php" class="w3-bar-item w3-button w3-center w3-hover-amber"><i class="material-icons w3-center " style="font-size:50px;color:white">access_time</i><h6>Historial</h6></a>
  <a href="../../logout.php" class="w3-bar-item w3-button w3-hover-amber"><i class="w3-center fa fa-key"><h6>Cerrar sesi&oacute;n</h6></i></a>   
</div>
<!-- Page Content -->


  <center>
    <div class="w3-container w3-dark-gray">
      <button class="w3-button w3-dark-gray w3-hover-amber w3-xlarge w3-left w3-animate-left" style="width: 30%" onclick="openRightMenu()">☰ <?php echo "Bienvenido ". $user_check ?></button>
    <label class="w3-row w3-block w3-dark-gray w3-center-align w3-xxlarge  w3-border-white">Salones</label>
    <div class="w3-container w3-amber">
      <button  class="w3-btn w3-block  w3-center-align w3-half w3-amber w3-hover-orange w3-xlarge w3-animate-zoom" onclick="document.getElementById('nuevo').style.display='block'">Nuevo</button>
    <button  onclick="document.getElementById('vista').style.display='block'" class="w3-btn w3-block w3-animate-zoom w3-center-align w3-half w3-amber w3-hover-orange w3-xlarge">Vista previa</button>
  </div>
  </div>
</center>

<div class="w3-container">


  <div class="w3-row">
    <a href="javascript:void(0)" onclick="openCity(event, 'reproduccion');">
      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-border-amber w3-padding"><h3>En Reproducci&oacute;n</h3></div>
    </a>
    <a href="javascript:void(0)" onclick="openCity(event, 'programados');">
      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-padding"><h3>Programados</h3></div>
    </a>
    </div>

         <!--Eventos en curso--> 
         <div id="reproduccion" class="w3-container city" style="display:block;">
         <center>
          <div class="w3-panel w3-card-4"  >
            <h2>Eventos en transmisión</h2>
            <?php
            
            if ($result = $mysqli->query("SELECT programacion_salones.id_evento,pantallas_salones.formato,programacion_salones.id_programacion,pantallas_salones.id_pantalla,archivos.id_archivo,eventos.tipo,eventos.nombre as 'evento',pantallas_salones.nombre as 'pantalla',archivos.nombre as 'imagen', programacion_salones.fecha_transmision,programacion_salones.fecha_inicio,programacion_salones.fecha_fin
                FROM `programacion_salones` 
                INNER JOIN eventos ON programacion_salones.id_evento=eventos.id_evento 
                INNER JOIN pantallas_salones on pantallas_salones.id_pantalla=programacion_salones.id_pantalla 
                INNER JOIN archivos on archivos.id_archivo=programacion_salones.id_archivo
                WHERE programacion_salones.fecha_transmision <= (SELECT CURRENT_TIMESTAMP) 
                AND programacion_salones.fecha_fin >= (SELECT CURRENT_TIMESTAMP)  
                order BY programacion_salones.fecha_inicio ASC;")){
              if ($result->num_rows > 0)
              {
                echo "<center><table id ='lista' border='0' cellpadding='10' align-items='center' class=".'w3-table-all'." style = 'font-size:12px;'>";
                echo "<tr class=".'w3-dark-gray'.">";
                echo "<td >Nombre del evento</td>";
                echo "<td >tipo de evento</td>";
                echo "<td >Pantalla</td>";
                echo "<td >Imagen</td>";
                echo "<td >Inicio de transmici&oacute;n</td>";
                echo "<td>Fecha inicio</td>";
                echo "<td>Fecha termina</td>";
                echo "<td>Vista</td>";
                echo "<td>Editar</td>";
                echo "<td>Eliminar</td>";
                echo "</tr>";
                //echo "<td>Fecha de alta</td>";
                echo "</tr>";
                while ($row = $result->fetch_object())
                {
                  $color ="";
                  if($row->fecha_fin <= $fechactual)
                  {$color = "bgcolor= '#aaaaaa'";}
                  if($row->fecha_inicio < $fechactual && $row->fecha_fin > $fechactual )
                  {$color = "hidden";}
                echo "<tr class='w3-pale-green  w3-hover-gray'>";
                echo "<td>" . $row->evento . "</td>";
                echo "<td>" . $row->tipo . "</td>";
                echo "<td>" . $row->pantalla . "</td>";
                echo "<td>" . $row->imagen . "</td>";
                echo "<td>" . $row->fecha_transmision . "</td>";
                echo "<td>" . $row->fecha_inicio . "</td>";
                echo "<td>" . $row->fecha_fin . "</td>";
                //echo "<td>" . $row->fechaalta . "</td>";
                echo "<td class=".'w3-hover-blue'."><a target='_blank' href='previa.php? id_programacion=".$row->id_programacion."&formato=".$row->formato."'><i class='fa w3-xlarge fa-eye'></i></a></td>";
                echo "<td class=".'w3-hover-amber'."><a href='modificar.php? id_programacion=".$row->id_programacion."&id_evento=".$row->id_evento."'><i class='fa w3-xlarge fa-pencil'></i></a></td>";
                echo "<td class=".' w3-hover-red'." ><a href='eliminar.php? id_programacion=".$row->id_programacion."&id_evento=".$row->id_evento."'><i class='fa w3-xlarge fa-trash'></i></a></td>";
                
                //echo "<td class="w3-dark-gray w3-hover-blue"  ><a href='mostrar.php?nombre=" . $row->nombre . "'>Mostrar_ahora</a></td>";
                echo "</tr>";
                }
                echo "</table><br></center>";
              }
              else
              {
                echo "<center>No hay eventos en curso</center>";
              }
            }
            else
            {
            echo "Error: " . $mysqli->error;
            }
            // close database connection
            //$mysqli->close();
            ?>
          
          </div>
        </center>
      </div>
        <!--proximamente-->
        <div id="programados" class="w3-container city" style="display:none;">
        <center>
          <div class="w3-panel w3-card-4" scrolling=yes >
            <h2>Pr&oacute;ximos eventos</h2>
            <?php
            include('../../conexion.php');
            if ($result = $mysqli->query("SELECT programacion_salones.id_evento, pantallas_salones.formato ,programacion_salones.id_programacion,pantallas_salones.id_pantalla,archivos.id_archivo,eventos.tipo,eventos.nombre as 'evento',pantallas_salones.nombre as 'pantalla',archivos.nombre as 'imagen', programacion_salones.fecha_transmision,programacion_salones.fecha_inicio,programacion_salones.fecha_fin
                FROM `programacion_salones` 
                INNER JOIN eventos ON programacion_salones.id_evento=eventos.id_evento 
                INNER JOIN pantallas_salones on pantallas_salones.id_pantalla=programacion_salones.id_pantalla 
                INNER JOIN archivos on archivos.id_archivo=programacion_salones.id_archivo
                WHERE programacion_salones.fecha_transmision >= (SELECT CURRENT_TIMESTAMP)   
                order BY programacion_salones.fecha_inicio ASC;")){
              if ($result->num_rows > 0)
              {
                echo "<center><table id ='lista' border='0' cellpadding='10' align-items='center' class=".'w3-table-all'." style = 'font-size:12px;'>";
                echo "<tr class='w3-dark-gray'>";
                echo "<td >Nombre del evento</td>";
                echo "<td >tipo de evento</td>";
                echo "<td >Pantalla</td>";
                echo "<td >Imagen</td>";
                echo "<td >Inicio de transmici&oacute;n</td>";
                echo "<td>Fecha inicio</td>";
                echo "<td>Fecha termina</td>";
                echo "<td>Vista</td>";
                echo "<td>Editar</td>";
                echo "<td>Eliminar</td>";
                echo "</tr>";
                //echo "<td>Fecha de alta</td>";
                echo "</tr>";
                while ($row = $result->fetch_object())
                {
                  $color ="";
                  if($row->fecha_fin <= $fechactual)
                  {$color = "bgcolor= '#aaaaaa'";}
                  if($row->fecha_inicio < $fechactual && $row->fecha_fin > $fechactual )
                  {$color = "hidden";}
                echo "<tr class='w3-pale-red w3-hover-gray'>";
                echo "<td>" . $row->evento . "</td>";
                echo "<td>" . $row->tipo . "</td>";
                echo "<td>" . $row->pantalla . "</td>";
                echo "<td>" . $row->imagen . "</td>";
                echo "<td>" . $row->fecha_transmision . "</td>";
                echo "<td>" . $row->fecha_inicio . "</td>";
                echo "<td>" . $row->fecha_fin . "</td>";
                //echo "<td>" . $row->fechaalta . "</td>";
                echo "<td class=".'w3-hover-blue'."><a target='_blank' href='previa.php?id_programacion=".$row->id_programacion."&formato=".$row->formato."'><i class='fa w3-xlarge fa-eye'></i></a></td>";
                echo "<td class=".'w3-hover-amber'."><a href='modificar.php? id_programacion=".$row->id_programacion."&id_evento=".$row->id_evento."'><i class='fa w3-xlarge fa-pencil'></i></a></td>";
                echo "<td class=".' w3-hover-red'." ><a href='eliminar.php? id_programacion=".$row->id_programacion."&id_evento=".$row->id_evento."'><i class='fa w3-xlarge fa-trash'></i></a></td>";
                //echo "<td class="w3-dark-gray w3-hover-blue"  ><a href='mostrar.php?nombre=" . $row->nombre . "'>Mostrar_ahora</a></td>";
                echo "</tr>";
                }
                echo "</table><br></center>";
              }
              else
              {
                echo "<center>No hay eventos programados</center>";
              }
            }
            else
            {
            echo "Error: " . $mysqli->error;
            }
            // close database connection
            //$mysqli->close();
            ?>
          
          </div>
        </center>
        <!--fin videos programados-->
      </div>
</div>
     

        <!--modal nuevo-->
    <form class="w3-container w3-animate-zoom" action="subir.php" method="post" enctype="multipart/form-data" name="upsecundario">
      <div id="nuevo" class="w3-modal w3-animate-opacity " >
        <div class="w3-modal-content">

      <header class="w3-container w3-green w3-border-bottom w3-border-teal"> 
        <center><h2>Nuevo</h2></center>
      </header>

      <div class="w3-row">
      <div class="w3-container w3-white w3-third " >
        <br>
        <div class="w3-center ">Pantallas</div>
        <?php
              
              if ($result2 = $mysqli->query("SELECT * FROM pantallas_salones order by nombre asc")){
                if ($result2->num_rows > 0){
                  while ($row2 = $result2->fetch_object()){
                    echo "<input class=".'w3-check'." type='checkbox' name='pantallas[]' value=' $row2->id_pantalla ' > $row2->nombre <br>";
                      }
                    }
                  }
                ?>

        <br>
      </div>
      <div class="w3-container w3-white w3-twothird">
        <br>
        
          <div class="w3-row ">

            <div class=" w3-half">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
                <input class="w3-input w3-border-bottom w3-border-black " name="nombre_evento" maxlength="30" type="text" required><label >Nombre del evento</label>
              </div>
              <br>
            </div>


            <div class=" w3-half">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
                <input class="w3-input w3-border-bottom w3-border-black " name="nombre_salon" maxlength="20" type="text" ><label >Nombre del sal&oacute;n</label>
              </div>
              <br>
            </div>

          </div> 

            <div class="w3-row ">
              
              <div class=" w3-half">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
                <input class="w3-input w3-border-bottom w3-border-black " name="texto_salon" maxlength="20" type="text" required><label >Texto del sal&oacute;n</label>
              </div>
              <br>
            </div>

              <div class=" w3-half">
              <div class="w3-panel w3-white w3-leftbar w3-border-white ">
                <input class="w3-input w3-border-bottom w3-border-black " name="tipo_evento" maxlength="20" type="text" required><label >Tipo de evento</label>
              </div>
              <br>
            </div>
            

            </div>

            <br>

            <div class="w3-row ">
              <div class="w3-panel w3-third w3-white w3-leftbar w3-border-white">
              <label >Pantalla completa</label><br>
            <input class="w3-radio " type="radio" name="completo" value="1" ><label >Si</label>
            <input class="w3-radio " type="radio" name="completo" value="0" checked><label >No</label>
            </div>

            <div class="w3-panel w3-twothird w3-white w3-leftbar w3-border-white ">
              <input class="w3-btn w3-block w3-black  w3-hover-black w3-rest w3-center-align  w3-round-xlarge"  type="file" name="miArchivo" id="miArchivo"  accept="image/jpeg,image/png"  required></input>
            </div>   
            </div>
            <div class="w3-row ">
          <div class="w3-panel w3-white w3-leftbar w3-border-blue w3-third">
          <p>Inicio transmisi&oacute;n</p>
          <input type="time" class=" w3-pale-blue w3-input w3-round" name="horatrans" <?php echo "value ='" . $horaactual . "'";?> required>
          <input type="date" class=" w3-pale-blue w3-input w3-round" name="diatrans" <?php echo "value ='" . $fechactual . "'";?> required>
        </div>
        <div class="w3-panel w3-white w3-leftbar w3-border-green w3-third">
          <p>Fecha inicio</p>
          <input type="time" class=" w3-pale-green w3-input w3-round" name="horainicio" <?php echo "value ='" . $horaactual . "'";?> required>
          <input type="date" class=" w3-pale-green w3-input w3-round" name="diainicio" <?php echo "value ='" . $fechactual . "'";?> required>
        </div>
        <div class="w3-panel w3-white w3-leftbar w3-border-red w3-third">
          <p>Fecha termina</p>
          <input type="time" class=" w3-pale-red w3-input w3-round" name="horafinal" <?php echo "value ='" . $horaactual . "'";?> required>
          <input type="date" class=" w3-pale-red w3-input w3-round" name="diafinal" <?php echo "value ='" . $fechactual . "'";?> required>
        </div>
      </div>

          </div>
        
          <br>
        <br>  
      </div>
      <footer class="w3-container w3-black">
        <br>
        <button class="w3-btn w3-block  w3-right w3-black w3-hover-blue w3-large w3-quarter w3-half"  >Guardar</button>
        </form>
        <form action=""><button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large w3-quarter w3-half"  onclick="document.getElementById('nuevo').style.display='none'">Cerrar</button> </form>
        </div><br><br>
      </footer>
      </div>
      
      

      </div>
    </div>
  
    <!--fin modal nuevo-->

    <!--modal vista-->

      <div id="vista" class="w3-modal w3-animate-opacity " >
        <div class="w3-modal-content" style="width: 600px">

      <header class="w3-container w3-blue w3-border-bottom w3-border-indigo"> 
        <center><h2>Vista Previa</h2></center>
      </header>
      <div class="w3-row w3-center w3-dark-gray">
        <br>
       <br>
       <?php 
          ////////genera id para la imagen
        if ($result = $mysqli->query("SELECT * FROM pantallas_salones where nombre NOT LIKE '%_2%' order by nombre asc")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            echo "<a href='../pantallas/$row->nombre/index.php' target='_blank' class='w3-bar-item w3-button w3-hover-amber w3-third'><h5>$row->nombre</h5></a>";
            }
          }
        }
    ?>
      <footer class="w3-container w3-black">
        <button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large  w3-round-xlarge"  onclick="document.getElementById('vista').style.display='none'">Cerrar</button>
      </footer>
      </div>
    </div>
    <!--fin modal vista-->
    
<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
    document.getElementById("mySidebar").style.width = "100%";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
     tablinks[i].className = tablinks[i].className.replace(" w3-border-amber", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-border-amber";
}


</script>
          
</body>
</html>