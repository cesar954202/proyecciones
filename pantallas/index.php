 <?php
include('../check.php');
include('../conexion.php');
   header("Content-Type: text/html;charset=utf-8");
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
  <a onclick="closeRightMenu()" class="w3-bar-item w3-button w3-center w3-hover-red"><i class="w3-center fa fa-close"><h6>Cerrar</h6></i></a>
  <a href="../inicio.php" class="w3-bar-item w3-button w3-hover-light-green w3-center"><i class="w3-center fa fa-home"><h6>Inicio</h6></i></a> 
  <a href="../salones/inicio/index.php" class="w3-bar-item w3-button w3-center w3-hover-light-green"><i class="material-icons w3-center " style="font-size:40px;color:white">image</i><h6>Salones</h6></a> 
  <a href="../promociones/index.php" class="w3-bar-item w3-button w3-center w3-hover-light-green"><i class="material-icons w3-center " style="font-size:40px;color:white">movie</i><h6>Promociones</h6></a>  
  <a href="../historial/index.php"  class="w3-bar-item w3-button w3-center w3-hover-light-green"><i class="material-icons w3-center " style="font-size:50px;color:white">access_time</i><h6>Historial</h6></a>
  <a href="../logout.php" class="w3-bar-item w3-button w3-hover-light-green"><i class="w3-center fa fa-key"><h6>Cerrar sesi&oacute;n</h6></i></a>   
</div>
<!-- Page Content -->
  <center>
    <div class="w3-container w3-dark-gray">
      <button class="w3-button w3-dark-gray w3-hover-light-green w3-xlarge w3-left w3-animate-left" style="width: 30%" onclick="openRightMenu()">☰ <?php echo "Bienvenido ". $user_check ?></button>
    <label class="w3-row w3-block w3-dark-gray w3-center-align w3-xxlarge  w3-border-white">Pantallas</label>
    <div class="w3-container w3-light-green">
      <button  class="w3-btn w3-block  w3-center-align  w3-light-green w3-hover-green w3-xlarge w3-animate-zoom" onclick="document.getElementById('nuevo').style.display='block'">Nuevo</button>
  </div>
  </div>
</center>

<div class="w3-container">

    <div class="w3-row">
    <a href="javascript:void(0)" onclick="openCity(event, 'salones');">
      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-border-light-green w3-padding"><h3>Salones</h3></div>
    </a>
    <a href="javascript:void(0)" onclick="openCity(event, 'promociones');">
      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-padding"><h3>Promociones</h3></div>
    </a>
    </div>

    <!--salones-->
      <div id="salones" class="w3-container city" style="display:block;">      
         <center>
          <div class="w3-panel w3-card-4">
            <h3>Pantallas de salones</h3>
            <?php
            $salones="salones";
            if ($result = $mysqli->query("SELECT * FROM `pantallas_salones` where nombre NOT LIKE '%_2%' ORDER BY nombre ASC;")){
              if ($result->num_rows > 0){
                while ($row = $result->fetch_object()){
                  echo "<div class='w3-row w3-card-4 w3-border-black w3-left-alig w3-leftbar w3-hover-gray' style='height: 50px'>
            <h4 class='w3-half w3-col w3-left-alig' style='width: 70%;height: 100%'>".$row->nombre."</h4>
            <a href='modificar.php? id_pantalla=".$row->id_pantalla."&tipo=$salones&nombre=".$row->nombre." '><button class='w3-btn w3-col w3-hover-amber w3-black' style='width: 15%;height: 50px'><i class='fa w3-xlarge fa-pencil'></i> Editar</button></a>
            <a href='eliminar.php? id_pantalla=".$row->id_pantalla."&tipo=$salones&nombre=".$row->nombre." '><button class='w3-btn w3-col w3-hover-red w3-black' style='width: 15%;height: 50px'><i class='fa w3-xlarge fa-trash'></i> Eliminar</button></a>
          </div><br>";
                  }
                }
              }
            ?>
            </div>
          </div>

        <!--promociones-->
        <div id="promociones" class="w3-container city" style="display:none;"> 
         <center>
          <div class="w3-panel w3-card-4"  >
            <h3>Pantallas de promociones</h3>
            <?php
            $promociones="promociones";
            if ($result = $mysqli->query("SELECT * FROM `pantallas_promociones` ORDER BY nombre ASC;")){
              if ($result->num_rows > 0){
                while ($row = $result->fetch_object()){
                  echo "<div class='w3-row w3-card-4 w3-border-black w3-left-alig w3-leftbar w3-hover-gray' style='height: 50px'>
            <h4 class='w3-half w3-col w3-left-alig' style='width: 70%;height: 100%'>".$row->nombre."</h4>
            <a href='modificar.php? id_pantalla=".$row->id_pantalla."&tipo=$promociones&nombre=".$row->nombre." '><button class='w3-btn w3-col w3-hover-amber w3-black' style='width: 15%;height: 50px'>Editar</button></a>
            <a href='eliminar.php? id_pantalla=".$row->id_pantalla."&tipo=$promociones&nombre=".$row->nombre." '><button class='w3-btn w3-col w3-hover-red w3-black' style='width: 15%;height: 50px'>Eliminar</button></a>
          </div><br>";
                  }
                }
              }
            ?>
          
            </div>
          </div>
        
     

        <!--modal nuevo-->
    <form class="w3-container w3-animate-zoom w3-white" action="subir.php" method="post" enctype="multipart/form-data" name="upsecundario">
      <div id="nuevo" class="w3-modal w3-animate-opacity " >
        <div class="w3-modal-content w3-white">

      <header class="w3-container w3-light-green w3-border-bottom w3-border-teal"> 
        <center><h2>Nuevo</h2></center>
      </header>


      <div class="w3-container w3-white " style="height: 650px">
      <!-- panel de examinar video -->
      <div class="w3-row w3-white ">
      <br> 

        <div class="w3-col w3-white w3-third w3-center" >
          <label>Tipo de pantalla</label>
          <select  class="w3-select  w3-dark-gray  " onchange='cargarSelect2(this.value);' name="tipo" id="tipo" required>
              <option value="">Seleccione tipo de pantalla</option>
              <option value="1">Salones</option>
              <option value="2">Promociones</option>
            </select>
        </div>

        <div class="w3-col w3-white w3-third w3-center" >
          <label>Formato de pantalla</label>
          <select onchange="habilitar(this.value)" id="formato" class="w3-select  w3-dark-gray  "  name="formato" required>
              <option value="">Seleccione formato de pantalla</option>
            </select>
        </div>

        <div class="w3-col w3-white w3-third w3-center" >
        <br>
          <input class="w3-input w3-white w3-border-bottom w3-border-green " type="text" name="nombre_pantalla" maxlength="20"  required>
          <label>Nombre de la pantalla</label>
        </div>
      </div>

        <div class="w3-row ">
         <input class="w3-btn w3-block w3-light-green w3-twothird w3-hover-black    w3-round-xlarge "  type="file" name="miArchivo" id="miArchivo"  accept="image/jpeg,image/png" disabled required>
         </input>  
        </div>
        <br>
        <div class="w3-row ">

          <div class="w3-row w3-white" >
            <h2 class="w3-row w3-black w3-text-amber w3-center">Formatos para salones</h2>
              <img class=" w3-center w3-third w3-col" src="imagenes/cuadrado.jpg" style="width:225px">
              <img class=" w3-center w3-third w3-col" src="imagenes/vertical.jpg"  style="width:300px">
              <img class=" w3-center w3-third w3-col" src="imagenes/vertical_dividido.jpg" style="width:300px">
          </div>
          <div class="w3-row w3-white" >
            <h2 class="w3-row w3-black w3-text-amber w3-center">Formatos para promociones</h2>
            <img class=" w3-center w3-half w3-col w3-left" src="imagenes/horizontal.jpg" style="width:350px">
            <img class=" w3-center w3-half w3-col w3-right" src="imagenes/vertical_promo.jpg"  style="width:350px">
          </div>

        </div>
    </div>
      <br>
        <footer class="w3-container w3-black">
        <br>
        <button class="w3-btn w3-block  w3-right w3-black w3-hover-blue w3-large w3-quarter w3-half" onclick="valoresNulos()" >Guardar</button>
        </form>
        <form action=""><button class="w3-btn w3-block  w3-left w3-black w3-hover-red w3-large w3-quarter w3-half"  onclick="document.getElementById('nuevo').style.display='none'">Cerrar</button></form>
      </footer>
    </div>  
    <!--fin modal nuevo-->


    
    
<script>
  //abre el panel de la izquierda
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
    document.getElementById("mySidebar").style.width = "100%";
}
//cierra el panel de la izquierda
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
//abre las opciones de salones o promociones
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



//carga el contenido de los combobox
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
//habilita el input de la imagen 
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