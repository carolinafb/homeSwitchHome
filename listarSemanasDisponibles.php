<?php
    session_start();
   include 'conexion.php';
   $link=conexion();
?>
<head>

  <title> Semanas disponibles </title>
</head>
<body>
  <style> /*estilos*/
  table {font-family: arial, sans-serif;border-collapse: collapse;}
  td, th {text-align: center;padding: 5px;}
  tr:nth-child(even) {background-color: #dddddd;}
  </style>
    <?php
    if((isset($_SESSION['nombre']))&&($_SESSION['rol']!='ESTANDAR') ){// si la sesion esta iniciada muestra nombre, rol y el cerrar sesion?>
      <?php echo "Bienvenido ",$_SESSION['nombre']," ",$_SESSION['apellido']; ?>
      <?php echo " eres usuario ", $_SESSION["rol"]; ?>

      <div align="right">
      <?php
      if (($_SESSION["rol"] !== "ADMINISTRADOR")) {?>
        <a href="perfilUsuario.php"> Mi perfil </a>
        &nbsp|&nbsp <?php
      } ?>
      <a href="cerrarSesion.php"> Cerrar sesion </a>
      <?php
    }?>
      </div>
        <center> <!-- esta es la imagen de la portada -->
          <div class='portada'><a href='index.php'><img  src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" ></a> </div>
        </center>

        <table align ='center'>  <!-- Buscador por fecha -->
           <tr>
             <td>
               <form name='buscarPorFecha' action='listarReservasDirectas.php' method="GET" >
                 <fieldset><legend>Buscar por Fecha</legend>
                   <table>
                     <tr>
                       <?php
                       $semanaInicio= date("Y-m-d",strtotime(date("Y-m-d")."+ 24 week"));
                       $semanaFin=  date("Y-m-d",strtotime(date("Y-m-d")."+ 47 week")); ?>
                       <td><input type= 'date' name='porFecha' id='porFecha' style="width: 100%" min= "<?php echo $semanaInicio?>" max= "<?php echo $semanaFin?>" required/></td>
                       <td><button type="submit" > Buscar </button></td>
                     </tr>
                   </table>
                 </fieldset>
               </form>
             </td>
           </tr>
        </table>  <!-- fin del buscador por fecha -->
      <body>
<?php
    if(isset ($_GET['idProp'])){// si por parametro vino el id de una propiedad
      $idProp = $_GET['idProp'];
      $query ="SELECT ventanadesemanas.ID as IDsemana ,ventanadesemanas.anio,ventanadesemanas.ID_propiedad AS ID ,ventanadesemanas.numeroDeSemana ,ventanadesemanas.ID_propiedad, ventanadesemanas.estado AS disponiblePara, nombre,descripcion,precio,direccion,pais,provincia,ciudad,foto,propiedades.estado AS estado
      FROM `propiedades` INNER JOIN ventanadesemanas ON propiedades.ID = ventanadesemanas.ID_propiedad
      WHERE ventanadesemanas.estado = 'DISPONIBLE' AND ID_propiedad = $idProp";
      $consulta=mysqli_query($link, $query); // Consulata 1 (me traigo los datos de la propiedad
      if (mysqli_num_rows($consulta)>0) { ?>
        <center><!-- centro la tabla -->
          <table width="800"> <!-- comienza la tabla -->
            <caption><h2> Lista de semanas </h2></caption><!-- titulo -->
              <?php

              $fila=mysqli_fetch_array($consulta);
              if( $fila["estado"]=="DISPONIBLE"){//si el estado de la propiedad es disponible ?>
                  <tr> <!-- Abro una fila -->
                    <td> <!--abro una columna muestro la FOTO-->
                      <br/>
                      <img src= <?php echo $fila["foto"] ?>  width=200 height="200" > <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
                      <br/>
                    </td>
                    <td> <!--abro una columna y muestro todos los demas datos -->
                      <strong><?php echo $fila["nombre"] ?></strong>
                      <br/> <!-- salto de linea -->
                      <br/>
                      <?php echo "Pais: ", $fila["pais"] ?>,
                      <br/>
                      <?php echo "Provincia: ",$fila["provincia"] ?>,
                      <br/>
                      <?php echo "Ciudad: ", $fila["ciudad"];?>
                      <br/>
                      </br>
                      <a href="propiedad.php?id=<?php echo $fila["ID"] ?>"> Ver detalles</a>
                      </br>

                    </td>
                  </tr>
                </table>
                <table><!-- Comienzo de tabla para semanas -->
                  <tr>
                      <th>numeroDeSemana:</th>
                      <th>Comienzo de estadia:</th>
                      <th>final:</th>
                      <th> </th>
                  </tr>
                  <?php
                  $consulta2=mysqli_query($link, $query);
                  while ($fila2=mysqli_fetch_array($consulta2)){?>
                  <tr>
                    <td>
                    <?php
                    $sem=$fila2['numeroDeSemana'];
                    $anio=$fila2['anio'];
                    echo $sem; ?>
                    </td>
                    <td>
                      <?php
                      if($fila2['anio']== '2019'){
                        $comienzo= date("d-m-Y",strtotime(date("2018-12-24")."+".$fila2["numeroDeSemana"]." week"));
                      }else {
                        $comienzo= date("d-m-Y",strtotime(date("2019-12-23")."+".$fila2["numeroDeSemana"]." week"));
                      }
                      echo "lunes ".$comienzo;
                      $fin= date("d-m-Y",strtotime(date("$comienzo")."+ 6 day"));
                      ?>
                    </td>
                    <td>
                      <?php
                      echo " domingo ".$fin;
                      ?>
                      </td>
                      <?php
                      if ($_SESSION['rol']=='PREMIUM') { ?>
                      <td>
                        <?php
                        if( $fila2["estado"]=="DISPONIBLE"){  ?>
                          <a onclick="confirm('Desea confirmar la reserva de la propiedad cuyo comienzo es el: lunes <?php echo $comienzo; ?> ')" href="reservar.php?sem=<?php echo $sem; ?> & anio= <?php echo $anio ;?>&id=<?php echo $fila2['ID'];?>&idsemana= <?php echo $fila2['IDsemana']; ?>"> Reservar </a>
                          <?php
                        }?>
                      </td>
                      <?php
                     } ?>
                  </tr>
                  <?php
                 } ?>
                </table>
      <?php }
    }else {
      echo "<script> alert ('No hay semanas disponibles para la propiedad ingresada');</script>";
      echo '<script> window.history.back()</script>';

    }
    }
  ?>
</body>
