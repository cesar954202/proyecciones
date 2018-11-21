<?php
   include("conexion.php"); // Monumental de la conexión a BD
   session_start(); // Varible de Sesión Iniciada

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // Usamos el nombre de usuario enviado de nuestro formulario

      $myusername = mysqli_real_escape_string($mysqli,$_POST['usuario_l']); // Nombre del usuario
      $mypassword = mysqli_real_escape_string($mysqli,$_POST['contrasena_l']); // Pdw del usuario 

     $sql = "SELECT * FROM usuario WHERE nombre = '$myusername' and contrasena = '$mypassword'";
     $result = mysqli_query($mysqli,$sql);
     $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
     #$active = $row['active'];

      $count = mysqli_num_rows($result);

      // Si el resultado combinado $myusername y $mypassword, fila de la tabla debe estar en 1 fila

      if($count == 1) {
        #session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         $_SESSION['loggedin'] = true; // Restrincción si la sessión esta activa 
         $_SESSION['username'] = $username; // usuario administrador
         $_SESSION['start'] = time(); // Variable para determinar el tiempo de la sesión
         $_SESSION['expire'] = $_SESSION['start']; //Duración de la sesión inactiva

         header("location: inicio.php");
      }else {
        echo "<script>";
        if($myusername == "alberto_figueroa" or $myusername == "Alberto_Figueroa" or $myusername == "Alberto_figueroa")
        {
          echo "alert ('Usuario O Contraseña Incorrecto Vuelve a intentarlo \\n Se creo un nuevo usuario daniel_rios \\n Mismo password que alberto_figueroa')";
        }
        else
        {
          echo "alert ('Usuario O Contraseña Incorrecto Vuelve a intentarlo')";
        }
        echo "</script>";
        echo"<script language='javascript'>window.location='index.php'</script>;";
        echo"<script language='javascript'>window.location='logout.php'</script>;"; // Truena la conexión a BD
      }
   }
?>

<!DOCTYPE html>
<html>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body  class="w3-blue-grey">
  <div class="w3-content w3-margin-top w3-card-4 " style="max-width:1000px;">
    <div class=" w3-row w3-center w3-white" style="width: 1000px"><img src="logo_p.png" style=" height:100px"></div>

  <div class="w3-row">
    <!--contenedor Principal-->
    <div class="w3-dark-gray w3-twothird " style="height:550px">
      <img src="fondo.jpg" style=" height:550px">
    </div>
    <div class="w3-container  w3-black w3-third" style="height:550px">

  <!--contenedor de login-->
    <form class="w3-container" action="" method="post" enctype="multipart/form-data" >
    <center><h2>Bienvenido</h2><br></center>
    <div class=" w3-row w3-center"><img src="logo1.png" style=" height:150px"></div>
    <input class="w3-input w3-black w3-border-bottom w3-border-amber" type="text" name="usuario_l" required>
    <label>Usuario</label><br><br>
    <input class="w3-input w3-black w3-border-bottom w3-border-amber" type="password" name="contrasena_l" required>
    <label>Password</label><br><br>
    <button class="w3-btn w3-block w3-amber w3-round-xxlarge w3-hover-orange" type="submit" name="Submit">Ingresar</button>
    </form>
  <!--fin contenedor de login-->


  </center>
  </div>
</div>
</div>
</body>
<div class="footer-copyright">
  <div class="container">
    <div align="right" ><font color="white">by Cesar Sanchez</font></div>
  </div>
</div>
</html>
