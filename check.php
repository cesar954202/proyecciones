<?php
   include('conexion.php');
   session_start();
   $conectar = $mysqli;
   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($mysqli,"select nombre from usuario where nombre = '$user_check' ");

   #$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

  # $login_session = $row['username'];

   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }

   

?>
