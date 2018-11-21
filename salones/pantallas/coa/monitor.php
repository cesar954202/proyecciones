<?php
$mysqliMonitoreo = new mysqli("localhost","root","","check"); 

$ipCliente = "{$_SERVER['REMOTE_ADDR']}";

$date1 = new DateTime("now");
$fechactual = $date1->format('Y-m-d h:i:s');

$sqlquery = "UPDATE estado_pantallas SET hora_cliente = '$fechactual' WHERE ip = '$ipCliente' ";


if($result = $mysqliMonitoreo->query($sqlquery)){
  //echo "Se actualizo estado";
  
}else{
  //echo "ERROR";
}

?>
