<?php
    session_start();
   include 'conexion.php';
   $link=conexion();
?>
<head>

  <title> Semanas disponibles </title>
</head>
<body>
  <style>
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
      </div>
          <center> <!-- esta es la imagen de la portada -->
              <div class='portada'><a href='index.php'><img  src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250" ></a> </div>
          </center>

          <table align ='center'>
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
           </table>
<?php
          if(isset($_GET['porFecha'])){ //en caso de que en se ingreso busqueda por Fecha
            $sem = date ('W',  strtotime ($_GET['porFecha']));
            //echo $sem, ' ';
            $anio =date ('Y',  strtotime ($_GET['porFecha']));
            //echo $anio;
            $query="SELECT ventanadesemanas.ID as IDsemana ,ventanadesemanas.ID_propiedad AS ID ,ventanadesemanas.numeroDeSemana ,ventanadesemanas.ID_propiedad, ventanadesemanas.estado AS disponiblePara, nombre,descripcion,precio,direccion,pais,provincia,ciudad,foto,propiedades.estado AS estado
            FROM `propiedades` INNER JOIN ventanadesemanas ON propiedades.ID = ventanadesemanas.ID_propiedad
             WHERE (ventanadesemanas.numeroDeSemana = $sem) AND (ventanadesemanas.anio = $anio) AND (ventanadesemanas.estado = 'DISPONIBLE' OR ventanadesemanas.estado = 'SUBASTANDO' OR ventanadesemanas.estado = 'HOTSALE')";
            $consulta=mysqli_query($link, $query);
            if (mysqli_num_rows($consulta)>0) { ?>
              <center><!-- centro la tabla -->
                <table width="800"> <!-- comienza la tabla -->
                  <caption><h2> Propiedades disponibles para la fecha ingresada <?php echo date ('d-m-Y', strtotime ($_GET['porFecha'])); ?> </h2></caption><!-- titulo -->
                    <tr>
                      <th>   </th>
                    </tr>
                    <?php
                    while ($fila=mysqli_fetch_array($consulta)){
                      if( $fila["estado"]=="DISPONIBLE"){ ?>
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
                            <?php echo "Ciudad: ", $fila["ciudad"]; ?>
                            <br/>
                            <br/>

                            <?php
                            if($anio == '2019'){ // determino la fecha de comienzo de la estadia
                                  $comienzo= date("d-m-Y",strtotime(date("2018-12-31")."+".$fila['numeroDeSemana']." week"));
                            }else {
                                $comienzo= date("d-m-Y",strtotime(date("2019-12-23")."+".$fila['numeroDeSemana']." week"));
                            }
                            $fin= date("d-m-Y",strtotime(date("$comienzo")."+ 6 day"));
                            ?>
                            <?php echo "Inicio: lunes ", $comienzo;?>
                            <br/>
                            <?php echo "Hasta: domingo", $fin ;   ?>
                            <br/>
                            <br/>

                           <?php
                            if ($fila["disponiblePara"] == 'DISPONIBLE'){
                              echo "Disponible para: Reserva Directa";

                            }else {
                              if($fila["disponiblePara"] == 'SUBASTANDO'){
                                echo "Disponible para: Subasta";
                              }else {
                                  echo "Disponible para: Hotsale";
                              }
                          }
                          ?>
                            <br/>
                          </td> <!--cierro columna-->
                          <td><!--abro columna para mostrar el ver detalles -->
                            <a href="propiedad.php?id=<?php echo $fila["ID"] ?>"> Ver detalles</a> <!-- es una referencia a la vista de la propiedad -->
                          </td>
                          <?php
                          if ($_SESSION['rol']=='PREMIUM') { ?>
                          <td>
                            <?php
                            if ($fila["disponiblePara"] == 'DISPONIBLE'){  ?>
                              <!--<a onclick="confirm('Desea confirmar la reserva de la propiedad cuyo comienzo es el: lunes <?php echo $comienzo; ?> ')" href="reservar.php?sem=<?php echo $sem; ?> & anio= <?php echo $anio ;?>&id=<?php echo $fila['ID'];?>&idsemana= <?php echo $fila['IDsemana']; ?>"> Reservar </a>-->
                                <button  type="button"  onclick="myFuncion ()" > Reservar </button>
                                <script>
                                  function myFuncion (){

                                      var r = confirm('Desea confirmar la reserva de la propiedad cuyo comienzo es el: lunes <?php echo $comienzo; ?> ');
                                      if (r == true) {
                                         window.location="reservar.php?sem=<?php echo $sem; ?> & anio= <?php echo $anio ;?>&id=<?php echo $fila['ID'];?>&idsemana= <?php echo $fila['IDsemana']; ?>";
                                      }
                                  }
                                </script>
                            <?php } ?>
                          </td>
                        <?php } ?>
                        </tr>
                    <?php }?>

                    <?php } ?>
                </table> <!-- fin de tabla -->
              </center>
            <?php }else {
              echo "<script> alert ('No hay semanas disponibles para la fecha ingresada');</script>";
              echo '<script> window.history.back()</script>';
            }
          } ?>
<?php }?>
</body>
