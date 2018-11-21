 <?php
include('../check.php');
include('../conexion.php');
   header("Content-Type: text/html;charset=utf-8");
//////////////eliminar automaticamente
if ($resultado = $mysqli->query("SELECT id_programacion,programacion_promociones.id_archivo,archivos.nombre from programacion_promociones INNER join archivos on archivos.id_archivo=programacion_promociones.id_archivo WHERE fecha_fin <= (select CURRENT_TIMESTAMP)")){
        if ($resultado->num_rows > 0){
          while ($row = $resultado->fetch_object()){
            if($result1 = $mysqli->query("DELETE FROM `programacion_promociones` WHERE `programacion_promociones`.`id_programacion` =".$row->id_programacion)){   
            //sin mensaje se elimina lo de programacion
                $exists = file_exists( "videos/" . $row->nombre );
                if($exists){
                  if($result3 = $mysqli->query("DELETE FROM `archivos` WHERE `id_archivo` = ".$row->id_archivo)){
                  unlink("videos/" . $row->nombre);
                }
              }
            }
          }//ciclo
        }
      }

      ?>

 <!DOCTYPE html>
<html>
<title>Pantallas</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<body class="w3-white">
  <style>
.mySlides {display:none}
.demo {cursor:pointer}
</style>
  <!--conexion -->
<?php
$date1 = new DateTime("now");
$fechactual = $date1->format('Y-m-d');
$date1 = new DateTime("now");
$horaactual = $date1->format('H:i');
?>

<script>
function openRightMenu() {
    document.getElementById("rightMenu").style.display = "block";
}
function closeRightMenu() {
    document.getElementById("rightMenu").style.display = "none";
}
</script>
<div class="w3-sidebar w3-bar-block w3-black w3-xxlarge w3-right w3-animate-left" style="width:130px;display:none" id="rightMenu">
  <a onclick="closeRightMenu()" class="w3-bar-item w3-button w3-hover-red w3-center"><i class="w3-center fa fa-close"><h6>Cerrar</h6></i></a>
  <a href="../inicio.php" class="w3-bar-item w3-button w3-hover-cyan w3-center"><i class="w3-center fa fa-home"><h6>Inicio</h6></i></a> 
  <a href="../salones/inicio/index.php" class="w3-bar-item w3-button w3-center w3-hover-cyan"><i class="material-icons w3-center " style="font-size:40px;color:white">image</i><h6>Salones</h6></a> 
  <?php if($user_check == 'admin'){
    echo "<a  href='../pantallas/index.php' class='w3-bar-item w3-button w3-center w3-hover-cyan' ><i class='material-icons w3-center '' style='font-size:50px;color:white' hidden>tv</i><h6>Pantallas</h6></a>";
  }
    ?>  
  <a href="../historial/index.php"  class="w3-bar-item w3-button w3-center w3-hover-cyan"><i class="material-icons w3-center " style="font-size:50px;color:white">access_time</i><h6>Historial</h6></a>
  <a href="../logout.php" class="w3-bar-item w3-button w3-hover-cyan"><i class="w3-center fa fa-key"><h6>Cerrar sesi&oacute;n</h6></i></a>   
</div>
<!-- Page Content -->


  <center>
    <div class="w3-container w3-dark-gray">
      <button class="w3-button w3-dark-gray w3-hover-cyan w3-xlarge w3-left w3-animate-left" style="width: 30%" onclick="openRightMenu()">☰ <?php echo "Bienvenido ". $user_check ?></button>
    <label class="w3-row w3-block w3-dark-gray w3-center-align w3-xxlarge  w3-border-white">Promociones</label>
    <div class="w3-container w3-cyan">
      <button  class="w3-btn w3-block  w3-center-align w3-half w3-cyan w3-hover-blue w3-xlarge w3-animate-zoom" onclick="document.getElementById('nuevo').style.display='block'">Nuevo</button>
      <button  class="w3-btn w3-block  w3-center-align w3-half w3-cyan w3-hover-blue w3-xlarge w3-animate-zoom" onclick="document.getElementById('vista').style.display='block'">Vista previa</button>
  </div>
  </div>
</center>

<div class="w3-container">

    <div class="w3-row">
    <a href="javascript:void(0)" onclick="openCity(event, 'principales');">
      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-border-cyan w3-padding"><h3>En Reproducci&oacute;n</h3></div>
    </a>
    <a href="javascript:void(0)" onclick="openCity(event, 'promociones');">
      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-padding"><h3>Programados</h3></div>
    </a>
    </div>

      <div id="principales" class="w3-container city" style="display:block;">
         <!--salones--> 
         <center>
          <div class="w3-panel w3-card-4">
            <h3>Pantallas de salones</h3>
            <?php
            if ($result = $mysqli->query("SELECT programacion_promociones.id_programacion,pantallas_promociones.id_pantalla,pantallas_promociones.formato ,archivos.id_archivo  , pantallas_promociones.nombre as 'pantalla', archivos.nombre as 'archivo', programacion_promociones.fecha_inicia,programacion_promociones.fecha_fin
              FROM `programacion_promociones` 
              INNER JOIN `archivos` ON programacion_promociones.id_archivo = archivos.id_archivo 
              INNER JOIN `pantallas_promociones` ON programacion_promociones.id_pantalla = pantallas_promociones.id_pantalla 
              WHERE (SELECT CURRENT_TIMESTAMP )>= programacion_promociones.fecha_inicia 
              AND (SELECT CURRENT_TIMESTAMP ) <= programacion_promociones.fecha_fin ORDER by fecha_inicia ASC"))

            {
              if ($result->num_rows > 0)
              {
                echo "<table border='0' cellpadding='10' align-items='center' class=".'w3-table-all'." style = 'font-size:12px;'>";
                echo "<tr class=".'w3-dark-gray'.">";
                echo "<td >Pantalla</td>";
                echo "<td >Nombre de video</td>";
                echo "<td >Formato</td>";
                echo "<td>Fecha de inicio</td>";
                echo "<td>Fecha de termino</td>";
                echo "<td>Vista</td>";
                echo "<td>Eliminar</td>";
                echo "<td>Editar</td>";
                echo "</tr>";
                while ($row = $result->fetch_object())
                {
                echo "<tr class='w3-pale-green w3-hover-gray'>";
                echo "<td>" . $row->pantalla ."</td>";
                echo "<td>" . $row->archivo . "</td>";
                echo "<td>" . $row->formato . "</td>";
                echo "<td>" . $row->fecha_inicia . "</td>";
                echo "<td>" . $row->fecha_fin . "</td>";
                echo "<td class=".'w3-hover-blue'."><a target='_blank' href='inicio/previa.php?id_programacion=".$row->id_programacion."&formato=".$row->formato."'><i class='fa w3-xlarge fa-eye'></i></a></td>";
                echo "<td class=".'w3-hover-red'." ><a href='inicio/eliminar.php?id_programa=".$row->id_programacion."&& archivo=".$row->archivo." && pantalla=".$row->id_pantalla." && id_archivo=".$row->id_archivo."' ><i class='fa w3-xlarge fa-trash'></i></a></td>";
                echo "<td class=".'w3-hover-amber'."><a href='inicio/modificar.php?id_programa=".$row->id_programacion."&& archivo=".$row->archivo." && pantalla=".$row->id_pantalla." && id_archivo=".$row->id_archivo."'><i class='fa w3-xlarge fa-pencil'></i></a></td>";
                echo "</tr>";
                }
                echo "</table><br></center>";
              }
              else
              {
                echo "<center>No hay vídeos en reproducción</center>";
              }
            }
            else
            {
            echo "Error: " . $mysqli->error;
            }
            ?>
          
            </div>
          </div>
        <!--promociones-->
        <div id="promociones" class="w3-container city" style="display:none;">
         <!--salones--> 
         <center>
          <div class="w3-panel w3-card-4"  >
            <h3>Pantallas de promociones</h3>
            <?php
            if ($result = $mysqli->query("SELECT programacion_promociones.id_programacion,pantallas_promociones.id_pantalla ,archivos.id_archivo,pantallas_promociones.formato  , pantallas_promociones.nombre as 'pantalla', archivos.nombre as 'archivo', programacion_promociones.fecha_inicia,programacion_promociones.fecha_fin 
              FROM `programacion_promociones` 
              INNER JOIN `archivos` ON programacion_promociones.id_archivo = archivos.id_archivo 
              INNER JOIN `pantallas_promociones` ON programacion_promociones.id_pantalla = pantallas_promociones.id_pantalla 
              WHERE (SELECT CURRENT_TIMESTAMP ) <= programacion_promociones.fecha_inicia  ORDER by fecha_inicia ASC"))

            {
              if ($result->num_rows > 0)
              {
                echo "<table border='0' cellpadding='10' align-items='center' class=".'w3-table-all'." style = 'font-size:12px;'>";
                echo "<tr class=".'w3-dark-gray'.">";
                echo "<td >Pantalla</td>";
                echo "<td >Nombre de video</td>";
                echo "<td>Fecha de inicio</td>";
                echo "<td>Fecha de termino</td>";
                echo "<td>Vista</td>";
                echo "<td>Editar</td>";
                echo "<td>Eliminar</td>";
                echo "</tr>";
                while ($row = $result->fetch_object())
                {
                echo "<tr class='w3-pale-red w3-hover-gray'>";
                echo "<td>" . $row->pantalla ."</td>";
                echo "<td>" . $row->archivo . "</td>";
                echo "<td>" . $row->fecha_inicia . "</td>";
                echo "<td>" . $row->fecha_fin . "</td>";
                echo "<td class=".'w3-hover-blue'."><a target='_blank' href='inicio/previa.php?id_programacion=".$row->id_programacion."&formato=".$row->formato."'><i class='fa w3-xlarge fa-eye'></i></a></td>";
                echo "<td class=".'w3-hover-red'." ><a href='inicio/eliminar.php?id_programa=".$row->id_programacion."&& archivo=".$row->archivo." && pantalla=".$row->id_pantalla." && id_archivo=".$row->id_archivo."' '><i class='fa w3-xlarge fa-trash'></i></a></td>";
                echo "<td class=".'w3-hover-amber'."><a href='inicio/modificar.php?id_programa=".$row->id_programacion."&& archivo=".$row->archivo." && pantalla=".$row->id_pantalla." && id_archivo=".$row->id_archivo."'><i class='fa w3-xlarge fa-pencil'></i></a></td>";
                echo "</tr>";
                }
                echo "</table><br></center>";
              }
              else
              {
                echo "<center>No hay vídeos en reproducción</center>";
              }
            }
            else
            {
            echo "Error: " . $mysqli->error;
            }
            ?>
          
            </div>
          </div>
        </center>
      </div>
        <!--fin videos programados-->
    <!--modal vista-->
      <div id="vista" class="w3-modal w3-animate-opacity " >
        <div class="w3-modal-content" style="width: 500px">

      <header class="w3-container w3-blue w3-border-bottom w3-border-indigo"> 
        <center><h2>Vista Previa</h2></center>
      </header>

      <div class="w3-row w3-center w3-dark-gray">
        <br>
       <br>
       <?php 
        if ($result = $mysqli->query("SELECT * FROM pantallas_promociones order by nombre asc")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){
            echo "<a href='pantallas/$row->nombre/index.php' target='_blank' class='w3-bar-item w3-button w3-hover-cyan w3-third'><h5>$row->nombre</h5></a>";
            }
          }
        }
    ?>
      <footer class="w3-container w3-black">
        <button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large  w3-round-xlarge"  onclick="document.getElementById('vista').style.display='none'">Cerrar</button>
      </footer>
      </div>
    </div>
  </div>
    <!--fin modal vista--> 

        <!--modal nuevo-->
    <form class="w3-container w3-animate-zoom" action="inicio/subir.php" method="post" enctype="multipart/form-data" name="upsecundario">
      <div id="nuevo" class="w3-modal w3-animate-opacity " >
        <div class="w3-modal-content w3-white" style="width: 1000px">

      <header class="w3-container w3-cyan w3-border-bottom w3-border-teal"> 
        <center><h2>Nuevo</h2></center>
      </header>

      <div class="w3-panel w3-pale-yellow w3-leftbar w3-border-amber">
    <h4><b>Advertencia: </b>Si sube un video en el formato equivocado, el contenido no podr&aacute; verse de buena calidad</h4>
  </div>
    <!-- formulario --> 
                  
                    <div class="w3-panel w3-white " ><br>
                      <div class="w3-panel  w3-white  w3-left" style="width:25%" >
                      <center><h5>Pantallas</h5></center>
                      <table class="w3-table" >
                        <?php
                            //$mysqli = new mysqli("localhost","root","","player");
                              if ($result2 = $mysqli->query("SELECT * FROM pantallas_promociones order by nombre asc")){
                                if ($result2->num_rows > 0){
                                  while ($row2 = $result2->fetch_object())
                                  {

                                    echo "<input  class=".'w3-check'." type='checkbox' name='pantallas[]' value=' $row2->id_pantalla ' onclick='validar()'> $row2->nombre <br>";
                                  }
                                }
                              }
                        ?>
                      <br>
                    </table>
                  </div>
                  <div class="w3-panel w3-col  w3-white  w3-left" style="width:75%" >
                    <br>
                    <!-- panel tipo de pantalla -->
                       <select class="w3-select w3-half w3-dark-gray w3-hover-cyan w3-round-xlarge " onchange='cargarSelect2(this.value);' name="tipo" id="tipo"  required>
                      <option value="">Seleccione el tipo de pantalla</option>
                      <option value="1">Horizontal</option>
                      <option value="2">Vertical</option>
                      </select>
                      <!-- panel de resolucion de video -->
                      <select onchange="javascript: pagina(value)"  class="w3-select w3-half w3-dark-gray w3-hover-cyan w3-round-xlarge "  name="formato" id="formato" disabled required>
                      <option value="">Seleccione resoluci&oacute;n del video</option>
                      </select>
                    
                      <br><br><br>
                      <input class="w3-btn w3-block w3-black  w3-rest w3-center-align  w3-round-xlarge"  type="file" name="miArchivo" id="miArchivo" accept="video/mp4" required></input>

                    <br>
                    <!-- panel de fechas -->
                    <div class="w3-half w3-left">
                      <div class="w3-panel w3-white w3-leftbar w3-border-green">
                        <p>Fecha de inicio</p>
                        <input type="time" class=" w3-pale-green w3-input w3-round" name="horainicio" <?php echo "value ='" . $horaactual . "'";?> required>
                      <input type="date" class=" w3-pale-green w3-input w3-round" name="diainicio" <?php echo "value ='" . $fechactual . "'";?> required>
                      </div>
                    </div>

                    <div class="w3-half w3-right">
                      <div class="w3-panel w3-white w3-leftbar w3-border-red">
                        <!-- panel de fechas -->
                        <p>Fecha de terminaci&oacute;n</p>
                        <input type="time" class=" w3-pale-red w3-input w3-round" name="horafinal" <?php echo "value ='" . $horaactual . "'";?> required>
                      <input type="date" class=" w3-pale-red w3-input w3-round" name="diafinal" <?php echo "value ='" . $fechactual . "'";?> required>
                      </div>
                    </div>
                  </div>
                    </div>
                  <footer class="w3-container w3-black">
                    <br>
                    <button class="w3-btn w3-right w3-black w3-hover-blue w3-round-xlarge  w3-third" type="submit" name="submit">Subir</button>
                    </form>
                    <form action=""><button class="w3-btn   w3-left w3-black w3-hover-red  w3-round-xlarge w3-third"  onclick="document.getElementById('nuevo').style.display='none'">Cerrar</button></form>
                    <label class="w3-button w3-round-xlarge w3-third w3-black w3-hover-gray " disabled id="descargar"  onclick="descargar()">Descargar plantilla</label>
                    
                    </footer>
                      </div>
                    
    <!--fin modal nuevo-->
  
       

    
    
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
     tablinks[i].className = tablinks[i].className.replace(" w3-border-cyan", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-border-cyan";
}

var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-opacity-off", " ");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";
}

function cargarSelect2(valor){

    var arrayValores=new Array(
      
        new Array(1,"1","Principal (1280 X 720)"),
        new Array(1,"0","Promociones (420 X 720)"),
        new Array(2,"2","Vertical (592 X 720)")

    );
    if(valor==0){
        // desactivamos el segundo select
        document.getElementById("formato").disabled=true;
    }else{
        // eliminamos todos los posibles valores que contenga el select2
        document.getElementById("formato").options.length=0;
 
        // añadimos los nuevos valores al select2
        document.getElementById("formato").options[0]=new Option("Selecciona una Opción", "");
        for(i=0;i<arrayValores.length;i++){
            // unicamente añadimos las opciones que pertenecen al id seleccionado
            // del primer select
            if(arrayValores[i][0]==valor){
                document.getElementById("formato").options[document.getElementById("formato").options.length]=new Option(arrayValores[i][2], arrayValores[i][1]);
            }
        }
 
        // habilitamos el segundo select
        document.getElementById("formato").disabled=false;
    }
}

function habilitar(){
  document.getElementById("descargar").disabled=false;
}

var x=null;
function pagina(archivo){
  if (archivo=='1') {
    x='inicio/descarga_principal.php';
    habilitar();
  }
    if(archivo=='0'){
      x='inicio/descarga_promociones.php';
      habilitar();
    }
      if(archivo=='2'){
      x='inicio/descarga_vertical.php';
      habilitar();
    }

    if(archivo==null){
      alert("No ha seleccionado ninguna plantilla");
   }
return x;
}

function descargar(){
  if (x==null) {
    alert('Debe eligir una opción');
  }else{
    window.open(x);
  } 
}

</script>


          
</body>
</html>