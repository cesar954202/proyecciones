<?php $query="SELECT usuario,accion,fecha_accion,evento,pantalla from historial  where fecha_accion between '2018-03-20 09:51:00' and ('2018-10-25 08:53:00' + interval 1 minute)   order by fecha_accion desc"; ?>
<?php
//conexion 
include('../conexion.php'); 
include('../check.php');
   header("Content-Type: text/html;charset=utf-8");
 ?>
<!DOCTYPE html>
<html>
<title>Inicio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<body >


  <!-- tabla de contenido del historial -->

            <?php
            //consulta para la tabla
            if ($result = $mysqli->query($query)){
              if ($result->num_rows > 0){
                echo "<table border='0' cellpadding='10' align-items='center' class=".'w3-table-all'." style = 'font-size:12px;'>";
                echo "<tr class=".'w3-dark-gray'.">";
                echo "<td >Usuario</td>";
                echo "<td >Acci&oacute;n</td>";
                echo "<td>Objeto</td>";
                echo "<td>Pantalla</td>";
                echo "<td>Fecha de acci&oacute;n</td>";
                echo "</tr>";
                while ($row = $result->fetch_object()){
                  if($row->accion=="eliminó"){$color="w3-pale-red";}
                  if($row->accion=="editó"){$color="w3-pale-yellow";}
                  if($row->accion=="agregó"){$color="w3-pale-green";}
                echo "<tr class= '$color w3-hover-gray '>";
                echo "<td>" . $row->usuario ."</td>";
                echo "<td>" . $row->accion . "</td>";
                echo "<td>" . $row->evento . "</td>";
                echo "<td>" . $row->pantalla . "</td>";
                echo "<td>" . $row->fecha_accion . "</td>";
                echo "</tr>";
                }
                echo "</table><br></center>";
              }else{
                echo "<center><img src='error.png' width='700px' height='500px'></center>";
              }
            }else{
            echo "Error: " . $mysqli->error;
            }
            // close database connection
            $mysqli->close();
            ?>

            
</body>
</html>