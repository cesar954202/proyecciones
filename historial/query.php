
<?php
include('../conexion.php');
include('../check.php');
    //Obligatorio selección.
    //Obtenemos el dato del option seleccionado.
    //$locatario = trim($_POST['locatario']);
   $query="$"."query";
  $accion = $_POST["accion"];
   $usuario = $_POST["usuario"];
  $diainicio = $_POST["diainicio"];
  $diafinal = $_POST["diafinal"];
  $horainicio = $_POST["horainicio"];
  $horafinal = $_POST["horafinal"];
  $queryFecha=" where fecha_accion between '".$diainicio." ".$horainicio.":00' and ('".$diafinal." ".$horafinal.":00' + interval 1 minute)";
  $queryAccion="";
  $queryUsuario="";
  if($accion=="1"){$queryAccion=" and accion='agregó'";}
  if($accion=="2"){$queryAccion=" and accion='editó'";}
  if($accion=="3"){$queryAccion=" and accion='eliminó'";}
  if(!(empty($usuario))){$queryUsuario=" and usuario like '".$usuario."%'";}
  

   $archivo = "tabla.php";
    $abrir = fopen($archivo, 'r+');
    $contenido = fread($abrir, filesize($archivo));
    fclose($abrir);
    $contenido = explode("\r\n", $contenido);
    $contenido[0] = "<?php $query=\"SELECT usuario,accion,fecha_accion,evento,pantalla from historial $queryFecha $queryAccion $queryUsuario order by fecha_accion desc\"; ?>"; 
    $contenido = implode("\r\n", $contenido);
    $abrir = fopen($archivo, 'w');
    fwrite($abrir, $contenido);
    fclose($abrir);


        echo"<script language='javascript'>window.location='index.php'</script>;";
   


?>