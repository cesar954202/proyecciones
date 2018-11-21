<?php $nombre_p="TEQUILA_BLANCO";$id_p="37"; ?>
<!DOCTYPE html>
<html>
<title><?php echo $nombre_p; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body bgcolor="black">

  <center>
    <!--video default -->
    <video height="613"   src="../../videos/videoHI.mp4" autoplay loop></video>
  </center>
<footer class="w3-container w3-dark-gray w3-topbar w3-border-amber" style="height: 150px">
  <div class="w3-row">
  	<div class="w3-col w3-third w3-left">
  		<center><h3 class="w3-xxlarge">Sal&oacute;n <?php echo $nombre_p; ?></h3>
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