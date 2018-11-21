<?php
//variables
include('../check.php');        
include('../conexion.php');
$id_pantalla= $_GET["id_pantalla"];
$tipo= $_GET["tipo"];
$nombre_pantalla= $_GET["nombre"];

?>
 <!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body class="w3-white">
    <head>
      <title>Editar</title>
    </head>
       <body>
        <form class="w3-container w3-animate-zoom w3-white" action="editado.php" method="post" enctype="multipart/form-data" name="upsecundario">
        <div class="w3-container w3-white">

      <header class="w3-container w3-amber w3-border-bottom w3-border-teal"> 
        <center><h2>Editar</h2></center>
      </header>

      <div class="w3-panel w3-pale-yellow w3-leftbar w3-border-amber">
    <h4><b>Advertencia: </b>Al editar esta pantalla todo el contenido ligado a la pantalla ser&aacute; eliminado permanentemente</h4>
  </div>

      <div class="w3-container w3-white w3-third " style="height: 350px">
      <!-- panel de examinar video -->
      <br>              
        <div class="w3-row w3-white" >
          <label>Tipo de pantalla</label>
          <select  class="w3-select  w3-dark-gray  " onchange='cargarSelect2(this.value);' name="tipo" id="tipo" required>
              <option value="">Seleccione tipo de pantalla</option>
              <?php if($tipo=="salones"){
        echo "<option value='1' selected>Salones</option>
              <option value='2'>Promociones</option>";
              }else{
        echo "<option value='1' >Salones</option>
              <option value='2' selected>Promociones</option>"; 
              }
              ?>
              
            </select>
        </div>
      <br> 
        <input type="text" name="tipo_anterior" hidden <?php echo "value ='" . $tipo . "'";?>> 
        <input type="text" name="nombre_pantalla_anterior" hidden <?php echo "value ='" . $nombre_pantalla . "'";?>> 
        <input type="text" name="id_pantalla" hidden <?php echo "value ='" . $id_pantalla . "'";?> >
        <div class="w3-row w3-white">
          <label>Formato de pantalla</label>
          <select onchange="habilitar(this.value)" id="formato" class="w3-select  w3-dark-gray  "  name="formato" required>
              <option value="" >Seleccione formato de pantalla</option>
              <?php if($tipo=="salones"){
        echo "<option value='cuadrado'>Cuadrado</option>
              <option value='vertical'>Vertical</option>
              <option value='vertical_dividido'>Vertical dividido</option>";
              }else{
        echo "<option value='horizontal'>Horizontal</option>
              <option value='vertical_promo'>Vertical</option>"; 
              }
              ?>
            </select>
        </div>
        <br>
        <input class="w3-btn w3-block w3-amber  w3-hover-black w3-rest w3-center-align  w3-round-xlarge"  type="file" name="miArchivo" id="miArchivo"  accept="image/jpeg,image/png" disabled required></input>
        <br>
        <div class="w3-row w3-white" >
          <input class="w3-input w3-white w3-border-bottom w3-border-amber" type="text" maxlength="20" name="nombre_pantalla" value=<?php echo $nombre_pantalla;?> required>
          <label>Nombre de la pantalla</label><br><br>
        </div>
        

      </div>
<center>
      <div class="w3-container  w3-white w3-twothird w3-center" style="height: 350px">
        <div class="w3-col w3-twothird ">
          <div class="w3-row "><h4>Formatos de pantalla</h4></div>
  <img class="mySlides w3-center w3-twothird" src="imagenes/cuadrado.jpg" style="width:355px">
  <img class="mySlides w3-center w3-twothird" src="imagenes/vertical.jpg"  style="width:455px">
  <img class="mySlides w3-center w3-twothird" src="imagenes/horizontal.jpg" style="width:455px">
  <img class="mySlides w3-center w3-twothird" src="imagenes/vertical_promo.jpg"  style="width:455px">
  <img class="mySlides w3-center w3-twothird" src="imagenes/vertical_dividido.jpg" style="width:455px">
  </div>
  <br>
  <div class="w3-col w3-third w3-light-gray  " style="height: 300px">

  <div class="w3-row-padding w3-section">
    <div class="w3-row  s4">
      <img class="demo w3-opacity w3-hover-opacity-off w3-hover-sepia" src="imagenes/cuadrado.jpg" style="width:60px" onclick="currentDiv(1)">
    </div>
    <br>
    <div class="w3-row  s4">
      <img class="demo w3-opacity w3-hover-opacity-off w3-hover-sepia" src="imagenes/vertical.jpg" style="width:60px" onclick="currentDiv(2)">
    </div>
    <br>
    <div class="w3-row  s4">
      <img class="demo w3-opacity w3-hover-opacity-off w3-hover-sepia" src="imagenes/horizontal.jpg" style="width:60px" onclick="currentDiv(3)">
    </div>
    <br>
    <div class="w3-row  s4">
      <img class="demo w3-opacity w3-hover-opacity-off w3-hover-sepia" src="imagenes/vertical_promo.jpg" style="width:60px" onclick="currentDiv(4)">
    </div>
    <br>
    <div class="w3-row  s4">
      <img class="demo w3-opacity w3-hover-opacity-off w3-hover-sepia" src="imagenes/vertical_dividido.jpg" style="width:60px" onclick="currentDiv(5)">
    </div>
  </div>

      </div> 
</center>

 
      <footer class="w3-container w3-black">
        <br>
        
        <button class="w3-btn w3-block  w3-right w3-black w3-hover-blue w3-large w3-quarter w3-half"  >Guardar</button>
        </form>
        <form action="index.php"><button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large w3-quarter w3-half" >Regresar</button></form>
      </footer>

  
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
     tablinks[i].className = tablinks[i].className.replace(" w3-border-light-green", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-border-light-green";
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
      
        new Array(1,"cuadrado","Cuadrado"),
        new Array(1,"vertical","Vertical"),
        new Array(1,"vertical_dividido","Vertical dividido"),
        new Array(2,"horizontal","Horizontal"),
        new Array(2,"vertical_promo","Vertical")


    );
    if(valor==0){
        // desactivamos el segundo select
        document.getElementById("formato").disabled=true;
    }else{
        // eliminamos todos los posibles valores que contenga el select2
        document.getElementById("formato").options.length=0;
 
        // añadimos los nuevos valores al select2
        document.getElementById("formato").options[0]=new Option("Selecciona una Opción", "0");
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

function habilitar(id){
if(id=="vertical_promo"){
document.getElementById("miArchivo").disabled=false;
}else{
  document.getElementById("miArchivo").disabled=true;
}
}
</script>



      </body>
</html>
