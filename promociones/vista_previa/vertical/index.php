<?php $nombre_p="Muestra";$id_p="3"; ?>
<!DOCTYPE html>
<html>
<title><?php echo $nombre_p;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-khaki.css">
<body class="w3-black">
<!-- aqui -->
<style type="text/css">
  .w3-oro {color:#000 !important; background-color:#c9a83f !important}
  .w3-plata {color:#000 !important; background-color:#333333 !important}
</style>
<?php
include('../../../conexion.php');


?>


<script type="text/javascript">
function playlist2(){
        var reproductor2 = document.getElementById("reproductor2"),
        videos = [
          <?php
          //Codigo para mostrar solo los eventos programados
          $date1 = new DateTime("now");
          $fechactual = $date1->format('Y-m-d H:i:s');
          $result = mysqli_query($mysqli,"SELECT nombre 
          FROM `archivos` 
          INNER JOIN `programacion_promociones` on programacion_promociones.id_archivo=archivos.id_archivo
          WHERE programacion_promociones.id_programacion=$id_p");
          if(mysqli_num_rows($result)>0){
              while($row = mysqli_fetch_assoc($result)){
                echo "\"../../videos/" . $row["nombre"] . "\",";
                
               }
           }

          else{
                  echo "\"../../videos/default.mp4\"";
             }

          ?>],


    info2 = document.getElementById("info2");

    info2.innerHTML = "Vídeo: " + videos[0];
    reproductor2.src = videos[0];
    reproductor2.play();

    reproductor2.addEventListener("ended", function() {
         var nombreActual = info2.innerHTML.split(": ")[1];
         var actual = videos.indexOf(nombreActual);
         actual = actual == videos.length - 1 ? 0 : actual + 1;
         this.src = videos[actual];
         info2.innerHTML = "Vídeo: " + videos[actual];
         this.play();
    }, false);
}

function inicio(){
  playlist2();
}

window.onload = inicio;
</script>


<!--aqui-->
<style type="text/css">
h1{font-size:80px;}
h2{font-size:40px;}
h3{font-size:30px;}
.w3-Courgette {font-family: "Courgette", serif;}
  .w3-oro {color:#000 !important; background-color:#c9a83f !important}
  .w3-plata {color:#000 !important; background-color:#333333 !important}

</style>
<header class="w3-container w3-plata w3-bottombar w3-border-amber w3-card-4 " style=" height: 640px " >

  <div class="w3-row w3-rest w3-center w3-white w3-bottombar w3-border-amber">
    <?php echo "<img src='../../imagenes/logogp.png' class='w3-center' style='height: 230px' >"?> 
  </div>
  
  <div class="w3-row">
    <div class="w3-col w3-third w3-center" style="height: 398px">
    <br>
    <br>
    <br>
    <!--Imagen-->
    <img src="../../imagenes/logo_hi.png" class="w3-center " style="height: 140px" >
    <div class="w3-row w3-rest w3-center  w3-bottombar w3-topbar w3-border-gray w3-text-amber">
    <h3 class="w3-center"><?php echo $nombre_p;?></h3>
  </div>
  </div>

<div class="w3-col w3-center w3-twothird">
  <div class="w3-row  w3-center">
    <!--Reloj-->
   <br><br><iframe src="../../reloj_bar.php" style="overflow:hidden;" scrolling="no" frameBorder="0" width="650px" height="180" class="w3-left"></iframe>
  </div>

  <div class="w3-row w3-center">
    <!--Clima-->
    <div id="cont_fcd1cc64c3c5cc1fa5a517cf3a98ab22"><script type="text/javascript" async src="https://www.meteored.mx/wid_loader/fcd1cc64c3c5cc1fa5a517cf3a98ab22"></script></div>
  </div>
</div>
  </div>
  


  </header>

    

<!--segunda parte-->
<div class="w3-row w3-center w3-black" ><br>
  <div class="w3-container w3-black w3-animate-zoom" >
    <center>
      <label id="info2" hidden></label>
      <video height="1250px"  id="reproductor2" class="w3-center" autoplay ></video>
    </center>
  </div>

</div>
  
<!--tercera parte-->


</body>
</html>

