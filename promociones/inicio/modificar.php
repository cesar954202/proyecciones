
<!DOCTYPE html>
<html>
<title>modificar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<body class="w3-blue-grey">
<!--conexion --> 
<?php

include('../../conexion.php');
$archivo = $_GET["archivo"];
$id = $_GET["id_archivo"];
$id_programa = $_GET["id_programa"];
$date1 = new DateTime("now");
$fechactual = $date1->format('Y-m-d');
$date1 = new DateTime("now");
$horaactual = $date1->format('H:i');
?>
  <!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:60%;">

  <!-- The Grid -->
  <div class="w3-row-padding w3-card-4 w3-white">

   <!-- panel subir -->
    <!-- formulario -->
    
    <form class="w3-container w3-animate-zoom" action="cambiar.php" method="post" enctype="multipart/form-data" name="upsecundario">   

                  	<input type="text" name="id_archivo" value=<?php echo $id;?> hidden ></input>
                    <div class="w3-panel w3-white " ><br>
                    	<center><h3>Modificando <?php echo $archivo ?></h3></center>
                      <input type="text" name="archivo" value=<?php echo $archivo;?> hidden ></input>
                      <div class="w3-panel  w3-white  w3-left" style="width:25%" >
                      <center><h5>Pantallas</h5></center>
                      <table class="w3-table" >
                        <?php
                
    $result = $mysqli->query("SELECT pantallas_promociones.id_pantalla,principal,pantallas_promociones.formato FROM pantallas_promociones 
INNER JOIN programacion_promociones on programacion_promociones.id_pantalla=pantallas_promociones.id_pantalla
WHERE programacion_promociones.id_programacion=$id_programa");
    if ($result->num_rows > 0){       
    while ($row = $result->fetch_object()){        
        $id_pantalla=$row->id_pantalla;
        $principal=$row->principal;
        $formato=$row->formato;
    }
  }

      $sqlquery2 = "SELECT pantallas_promociones.id_pantalla as 'id_pantalla',nombre FROM pantallas_promociones";
      $sqlquery3 = "SELECT programacion_promociones.id_pantalla as 'id_pantallas' FROM programacion_promociones WHERE `id_archivo` = $id ";  
      
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
                    </table>
                  </div>
                  <div class="w3-panel w3-col  w3-white  w3-left" style="width:75%" >
                    <br>
                       
                      <!-- panel de examinar video -->
                      <select class="w3-select  w3-dark-gray w3-hover-cyan w3-half w3-round-xlarge " onchange='cargarSelect2(this.value);' name="tipo" id="tipo"  required>
                      <option value="">Seleccione el tipo de pantalla</option>
                      
                      <option value="1" <?php if($formato=="horizontal"){echo "selected";}?>>Horizontal</option>
                      <option value="2" <?php if($formato=="vertical_promo"){echo "selected";}?>>Vertical</option>
                      </select>
                      <!-- panel de resolucion de video -->
                      <select onchange="javascript: pagina(value)" class="w3-select w3-half w3-dark-gray w3-hover-cyan w3-round-xlarge "  name="formato" id="formato" required>
                      <option value="">Seleccione resoluci&oacute;n del video</option>
                      <?php if($formato=="horizontal"){
                        $principal1="";
                        $principal2="";
                        if($principal=="1"){$principal1="selected";}else{$principal2="selected";}
                        echo "<option value='1' $principal1>Principal(1280 X 720)</option>";
                        echo "<option value='0' $principal2>Promociones (420 X 720)</option>";
                        }else{
                        echo "<option value='2' selected>vertical (592 X 720)</option>";
                        }
                        ?>
                      </select>
                      <br>
                      <br>
                      <br>
                      <input class="w3-btn w3-block w3-black  w3-rest w3-center-align  w3-round-xlarge"  type="file" name="miArchivo" id="miArchivo" accept="video/mp4" ></input>
                    <br>
                    <br>

                     <?php 
              $result = $mysqli->query("SELECT programacion_promociones.fecha_inicia,programacion_promociones.fecha_fin
FROM programacion_promociones INNER JOIN archivos on archivos.id_archivo = programacion_promociones.id_archivo WHERE id_programacion=$id_programa");

                while ($row = $result->fetch_object()){
                  $fecha_in = $row->fecha_inicia;
                  $fecha_fn = $row->fecha_fin;

                    $test = new DateTime($fecha_in);
                    $test1 = new DateTime($fecha_in);
                    $fecha_i = $test1->format('Y-m-d');
                    $hora_i = $test->format('H:i');

                    $test = new DateTime($fecha_fn);
                    $test1 = new DateTime($fecha_fn);
                    $fecha_f = $test1->format('Y-m-d');
                    $hora_f = $test->format('H:i');
                }
                ?>
                    <!-- panel de fechas -->
                    <div class="w3-half w3-left">
                      <div class="w3-panel w3-white w3-leftbar w3-border-green">
                        <p>Fecha de inicio</p>
                        <input type="time" class=" w3-pale-green w3-input w3-round" name="horainicio" <?php echo "value ='" . $hora_i . "'";?> required>
                      <input type="date" class=" w3-pale-green w3-input w3-round" name="diainicio" <?php echo "value ='" . $fecha_i . "'";?> required>
                      </div>
                    </div>

                    <div class="w3-half w3-right">
                      <div class="w3-panel w3-white w3-leftbar w3-border-red">
                        <!-- panel de fechas -->
                        <p>Fecha de terminaci&oacute;n</p>
                        <input type="time" class=" w3-pale-red w3-input w3-round" name="horafinal" <?php echo "value ='" . $hora_f. "'";?> required>
                      <input type="date" class=" w3-pale-red w3-input w3-round" name="diafinal" <?php echo "value ='" . $fecha_f . "'";?> required>
                      </div>
                    </div>
                  </div>
                    <center><input class="w3-button w3-round-xlarge w3-blue w3-right w3-third"  type="submit" value="Guardar cambios" name="submit"></input></center><br>
                    </form>

                    <form action="../index.php"><button class="w3-button   w3-center w3-round-xlarge w3-black w3-hover-red  w3-third w3-left" >Regresar</button></form>
                    <label class="w3-button w3-round-xlarge w3-third w3-black w3-hover-gray w3-border w3-left" disabled id="descargar"  onclick="descargar()">Descargar plantilla</label>
                    </div>
                  </div>

                </div>
                <!-- fin panel subir -->



<!-- fin row -->

  <!-- fin page container -->
</div>

<script>
  function volver(){
    history.back(); 
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