<?php $nombre_p="Sala_1_BC";$id_p="26"; ?>
<!DOCTYPE html>
<html>
<title><?php echo $nombre_p; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
<body BACKGROUND="../../imagenes/fondo.jpg">

<style type="text/css">
h1{font-size:80px;}
h2{font-size:50px;}
h3{font-size:30px;}
.w3-Courgette {font-family: "Courgette", serif;}
</style>
<?php
include('../../../conexion.php');


//carga datos
      if ($result = $mysqli->query("SELECT archivos.nombre from programacion_salones INNER JOIN archivos ON archivos.id_archivo = programacion_salones.id_archivo WHERE programacion_salones.fecha_transmision <= (SELECT CURRENT_TIMESTAMP) AND programacion_salones.id_pantalla=$id_p  AND programacion_salones.fecha_fin >= (SELECT CURRENT_TIMESTAMP)")){
        if ($result->num_rows > 0){
          while ($row = $result->fetch_object()){

            $imagen="../../imagenes/".$row->nombre;
            }
          }
        }
////////
?>


    				<img src=<?php echo $imagen;?> class="w3-left w3-card-4" style="height: 768px;width:1024px;padding:5px" >
  		
</body>
</html>