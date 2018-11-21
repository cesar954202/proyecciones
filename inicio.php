<?php
include('check.php');
	 header("Content-Type: text/html;charset=utf-8");
 ?>
<!DOCTYPE html>
<html>
<title>Inicio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-metro.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Courgette">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<body  class="w3-dark-gray"> 
	<style type="text/css">
	h1{font-size:70px;}
  .w3-oro {color:#000 !important; background-color:#c9a83f !important}
  .w3-plata {color:#000 !important; background-color:#333333 !important}
  .w3-Courgette {font-family: "Courgette", serif;}
</style>

	<div class="w3-content w3-margin-top w3-card-4 w3-metro-light-blue" style="width:1200px ;height:650px">

    <div class="w3-row w3-black">
    <a href="logout.php" class="w3-black w3-col w3-bar-item w3-button w3-hover-red" style="width: 20%;height: 60px"><i class="w3-center w3-xxlarge fa fa-key"></i>Cerrar sesi&oacute;n</a>
		<div class="w3-col w3-amber w3-center w3-half w3-Courgette w3-text-black" style="width: 80%;" ><h2>Inicio</h2></div>
		</div>

	<div class="w3-row">

		

    <div class="w3-col w3-half w3-animate-left" >
      <div class="w3-panel " style="width:100%;height: 250px">
        <form action="Promociones/index.php"><button type="submit" class="w3-btn w3-block w3-hover-amber w3-plata w3-right-align" style="width:100%;height: 250px">
          <h1 class="w3-Courgette w3-center w3-text-white w3-hover-text-black " style="width:100%;height: 250px"><br>Promociones</h1>
        </button></form>
      </div>
    </div>

		<div class="w3-col w3-half w3-animate-top" >
			<div class="w3-panel " style="width:100%;height: 250px">
				<form action="salones/inicio/index.php"><button class="w3-btn w3-block w3-hover-amber w3-plata w3-center" style="width:100%;height: 250px">
					<h1 class="w3-Courgette w3-center w3-text-white w3-hover-text-black " style="width:100%;height: 250px"><br>Salones</h1>
				</button></form>
			</div>
		</div>  
	</div>


	<div class="w3-row">
		
    <div class="w3-col w3-third w3-animate-bottom" >
      <div class="w3-panel " style="width:100%;height: 250px">
        <form action="historial/index.php"><button type="submit" class="w3-btn w3-block w3-hover-amber w3-plata  w3-center" style="width:100%;height: 250px">
          <br><i class="material-icons w3-center " style="font-size:150px;color:white">access_time</i><h2 class="w3-Courgette w3-center w3-text-white w3-hover-text-black " style="width:100%;height: 250px">Historial</h2>
        </button></form>
      </div>
    </div>

    <div class="w3-col w3-third w3-animate-opacity" >
      <div class="w3-panel " style="width:100%;height: 250px">
        <form action="Pantallas/index.php"><button type="submit" <?php if($user_check != 'admin'){echo "disabled";}?> class="w3-btn w3-block w3-hover-amber w3-plata  w3-center" style="width:100%;height: 250px">
          <br><i class="material-icons w3-center " style="font-size:150px;color:white">tv</i><h2 class="w3-Courgette w3-center w3-text-white w3-hover-text-black"  style="width:100%;height: 250px">Pantallas</h2>
        </button></form>
      </div>
    </div>

    <div class="w3-col w3-third " >
      <div class="w3-panel " style="width:100%;height: 250px">
        <div class="w3-col w3-half w3-animate-zoom"  style="height:125px">
          <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-block w3-hover-green w3-plata w3-center-align "  <?php if($user_check != 'admin'){echo "disabled";}?> style="height:125px" >
            <i class="material-icons" onclick="document.getElementById('id01').style.display='block'" style="font-size:48px;color:green">person_add</i>
          <h4 class="w3-Courgette w3-center w3-text-white w3-hover-text-black"  onclick="document.getElementById('id01').style.display='block'" >Crear usuario</h4>
        </button>
        </div>

        <div class="w3-col w3-half w3-animate-zoom"  style="height:125px">
          <button onclick="document.getElementById('id02').style.display='block'" class="w3-btn w3-block w3-hover-amber w3-plata w3-center-align " style="height:125px">
            <i class="material-icons" onclick="document.getElementById('id02').style.display='block'" style="font-size:48px;color:yellow">edit</i>
          <h4 class="w3-Courgette w3-center w3-text-white w3-hover-text-black"  onclick="document.getElementById('id02').style.display='block'"  >Editar usuario</h4>
        </button>
        </div>

        <div class="w3-col w3-half w3-animate-zoom"  style="height:125px">
          <button onclick="document.getElementById('id03').style.display='block'" class="w3-btn w3-block w3-hover-pink w3-plata w3-center-align " <?php if($user_check != 'admin'){echo "disabled";}?> style="height:125px">
            <i class="material-icons"  onclick="document.getElementById('id03').style.display='block'" style="font-size:48px;color:red">delete</i>
          <h4 class="w3-Courgette w3-center w3-text-white w3-hover-text-black"  onclick="document.getElementById('id03').style.display='block'"  >Borrar usuario</h4>
        </button>
        </div>

        <div class="w3-col w3-half w3-animate-zoom"  style="height:125px">
          <button onclick="document.getElementById('id04').style.display='block'" class="w3-btn w3-block w3-hover-blue w3-plata w3-center-align " <?php if($user_check != 'admin'){echo "disabled";}?> style="height:125px">
            <i class="material-icons" onclick="document.getElementById('id04').style.display='block'" style="font-size:48px;color:cyan">person</i>
          <h4 class="w3-Courgette w3-center w3-text-white w3-hover-text-black"  onclick="document.getElementById('id04').style.display='block'"  >Ver usuario</h4>
        </button>
        </div>
      </div>
    </div>
	</div>

	<br>
	<br>

	<!--modal crear-->
	  <div id="id01" class="w3-modal w3-animate-opacity ">
    <div class="w3-modal-content w3-round-large" style="width: 20%">
      <header class="w3-container w3-green"> 
        <h2 class="w3-center ">Crear usuario</h2>
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright w3-red">&times;</span>
      </header>
      <div class="w3-container">
          <!--contenedor de login-->
    <form class="w3-container" action="usuarios/crear.php" method="post" enctype="multipart/form-data" >
    <br>
    <input class="w3-input w3-white w3-border-bottom w3-border-green" type="text" name="usuario_nuevo" placeholder="Inserte el nombre del usuario" required>
    <label>Usuario</label><br><br>
    <input class="w3-input w3-white w3-border-bottom w3-border-green" type="password" name="contrasena_nuevo"  placeholder="Inserte el password del usuario" required>
    <label>Password</label><br><br>
    <br>   
  <!--fin contenedor de login-->
      </div>
      <footer class="w3-container w3-plata">
      	<br> 
        <button class="w3-btn w3-block w3-light-green w3-round-xxlarge w3-hover-green " type="submit" name="Submit">Crear</button>
        <br>
      </footer>

      </form>
    </div>
  </div>
</div>
<!--modal-->
	<!--modal editar-->
	  <div id="id02" class="w3-modal w3-animate-opacity ">
    <div class="w3-modal-content w3-round-large" style="width: 20%">
      <header class="w3-container w3-amber"> 
        <h2 class="w3-center ">Editar usuario</h2>
        <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-display-topright w3-red">&times;</span>
      </header>
      <div class="w3-container">
          <!--contenedor de login-->
    <form class="w3-container" action="usuarios/editar.php" method="post" enctype="multipart/form-data" >
    <br>

    <?php
            include('conexion.php');

              if ($result2 = $mysqli->query("SELECT * FROM usuario where nombre='".$user_check."'")){
                if ($result2->num_rows > 0){
                  while ($row2 = $result2->fetch_object()){
                    if($user_check != 'admin'){$disponibilidad= "disabled";}
                    echo "<input class='w3-input w3-white w3-border-bottom w3-border-amber' type='text' name='nombre_E' value='$row2->nombre' $disponibilidad>";
                    echo "<label class='w3-text-black'>Usuario</label><br><br>";
                    echo "<input class='w3-input w3-white w3-border-bottom w3-border-amber' type='password' name='contrasena_E' value='$row2->contrasena' required>";
                    echo "<label class='w3-text-black'>Password</label><br><br>";
                      } 
                    }
                  }
                ?>
    <br> 
  <!--fin contenedor de login-->
      </div>
      <footer class="w3-container w3-plata">
      	<br> 
        
        <button class="w3-btn w3-block w3-amber w3-round-xxlarge w3-hover-orange " type="submit" name="Submit">Editar</button>
        <br>
        <br>
      </footer>

      </form>
    </div>
  </div>
</div>
<!--modal-->
<!--modal eliminar-->
	  <div id="id03" class="w3-modal w3-animate-opacity " >
    <div class="w3-modal-content w3-round-large" style="width: 20%">
      <header class="w3-container w3-pink"> 
        <h2 class="w3-center ">Borrar usuario</h2>
        <span onclick="document.getElementById('id03').style.display='none'" class="w3-button w3-display-topright w3-dark-gray">&times;</span>
      </header>
      <div class="w3-container">
          <!--contenedor de login-->

    <form class="w3-container w3-text-black" action="usuarios/eliminar.php" method="post" enctype="multipart/form-data" >
    	<h3 class="w3-center ">Usuarios</h3>
    	<?php
            include('conexion.php');
              if ($result2 = $mysqli->query("SELECT * FROM usuario where nombre<>'admin'")){
                if ($result2->num_rows > 0){
                  while ($row2 = $result2->fetch_object()){
                    echo "<div class='w3-row w3-hover-gray'><input class=".'w3-check w3-text-black'." type='checkbox' name='usuarios[]' value=' $row2->id_usuario' > <label >$row2->nombre </label></div><br>";
                      }
                    }
                  }
                ?>

     <br> 
  <!--fin contenedor de login-->
      </div>
      <footer class="w3-container w3-plata">
      	<br> 
        <button class="w3-btn w3-block w3-red w3-round-xxlarge w3-hover-pink " type="submit" name="Submit">Borrar</button>
        <br>
        <br>
      </footer>

      </form>
    </div>
  </div>
</div>
<!--modal-->
<!--modal eliminar-->
	  <div id="id04" class="w3-modal w3-animate-opacity " >
    <div class="w3-modal-content w3-round-large" style="width: 20%">
      <header class="w3-container w3-blue"> 
        <h2 class="w3-center ">Ver usuario</h2>
      </header>
      <div class="w3-container">
          <!--contenedor de login-->

    <form class="w3-container w3-text-black" action="" method="post" enctype="multipart/form-data" >
    	<h3 class="w3-center ">Usuarios</h3>
    	<center><table id ='lista' border='0' cellpadding='10' align-items='center' class="w3-table-all" style = "font-size:12px">
                 <tr class="w3-dark-gray">
                 <td >Nombre del usuario</td>
                 <td >Contrase&ntilde;a</td>
                 </tr>
    	<?php
    	
            include('conexion.php');
              if ($result2 = $mysqli->query("SELECT * FROM usuario order by nombre asc")){
                if ($result2->num_rows > 0){
                  while ($row2 = $result2->fetch_object()){
                echo "<tr class=".'w3-pale-blue'.">";
                echo "<td>" . $row2->nombre . "</td>";
                echo "<td>" . $row2->contrasena . "</td>";
                //echo "<td class="w3-dark-gray w3-hover-blue"  ><a href='mostrar.php?nombre=" . $row->nombre . "'>Mostrar_ahora</a></td>";
                echo "</tr>";
                      }
                    }
                  }
                ?>
</table>
     <br> 
  <!--fin contenedor de login-->
      </div>
      <footer class="w3-container w3-plata">
      	<br> 
        <button class="w3-btn w3-block w3-blue w3-round-xxlarge w3-hover-cyan " onclick="document.getElementById('id04').style.display='none'" >Cerrar</button>
        <br>
      </footer>

      </form>
    </div>
  </div>
</div>
<!--modal-->
</div>
</body>

<div class="footer-copyright">
  <div class="container">
    <div align="right" ><font color="white">by Cesar Sanchez</font></div>
  </div>
</div>
</html>
