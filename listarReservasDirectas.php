<?php
session_start();
include 'conexion.php';
$link = conexion();
?>

<head>

  <title> Semanas disponibles </title>
</head>

<body>
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
    }

    td,
    th {
      text-align: center;
      padding: 5px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
  <script type="text/javascript">
    function ConfirmDemo(idPropiedad, idHotsales) {
      //Ingresamos un mensaje a mostrar
      var mensaje = confirm("¿Desea confirmar la compra del hotsale ?");
      //Detectamos si el usuario acepto el mensaje
      if (mensaje) {
        alert("¡Compra confirmada!");
        document.location = 'comprarHotsale.php?idProp=' + idPropiedad + '&idHot=' + idHotsales;
      }
      //Detectamos si el usuario denegó el mensaje
      else {
        alert("¡Haz denegado la compra de hotsale!");
      }
    }
  </script>
  <?php
  if ((isset($_SESSION['nombre']))) { // si la sesion esta iniciada muestra nombre, rol y el cerrar sesion
    ?>
    <?php echo "Bienvenido ", $_SESSION['nombre'], " ", $_SESSION['apellido']; ?>
    <?php echo " eres usuario ", $_SESSION["rol"]; ?>

    <div align="right">
      <?php
      if (($_SESSION["rol"] !== "ADMINISTRADOR")) { ?>
        <a href="perfilUsuario.php"> Mi perfil </a>
        &nbsp|&nbsp 
                  <?php}?> 
      <a href="cerrarSesion.php"> Cerrar sesion </a>
    </div>
    <center>
      <!-- esta es la imagen de la portada -->
      <div class='portada'><a href='index.php'><img src='imagenes/logoHomeSwitchHome.png' title="Home Switch Home" width="550" height="250"></a> </div>
    </center>

    </br>
        <div align='center'>
        <?php
        if($_SESSION['rol']== 'ADMINISTRADOR'){?>
  
          <a href="scripActualizarSemanas.php"> Script para actualizar ventana semanas </a>
          <hr style="color: #000000;" />
          &nbsp|&nbsp
                <a href="altapropiedad.php"> Agregar propiedad </a>
          &nbsp|&nbsp
                <a href="modificarTarifas.php"> Ver tarifas </a>
          &nbsp|&nbsp
                <a href="solicitudPaseUsuario.php"> Ver solicitud de pases de usuarios </a>
          &nbsp|&nbsp
                <a href="verClientes.php" > Ver Listado de Clientes </a>
          &nbsp|&nbsp 
                <a href="listarSubastasCerradas.php"> Lista de subastas Finalizadas </a>
          &nbsp|&nbsp 
               <a href="listarCancelaciones.php"> Listado de Cancelaciones </a>
          &nbsp|&nbsp   
                <a href="listarHotsalesEnEspera.php"> Listado de Hotsales en Espera </a>
          &nbsp|&nbsp   
           
    
          <?php
        }
      }
        if(isset($_SESSION['nombre'])){?>

        <a href="listarSubastas.php"> Lista de subastas vigentes </a>
        &nbsp|&nbsp 
          <a href="listarHotsalesVigentes.php"> Lista de Hotsales vigentes </a>
        &nbsp|&nbsp 
      </br>
      </br>
        <hr style="color: #000000;" />
      <?php } ?>
    </div>




  
    <?php
    if (isset($_GET['porFecha'])) { //en caso de que en se ingreso busqueda por Fecha
      $sem = date('W',  strtotime($_GET['porFecha']));
      //echo $sem, ' ';
      $anio = date('Y',  strtotime($_GET['porFecha']));
      //echo $anio;
      $query = "SELECT ventanadesemanas.ID as IDsemana ,ventanadesemanas.ID_propiedad AS ID ,ventanadesemanas.numeroDeSemana ,ventanadesemanas.ID_propiedad, ventanadesemanas.estado AS disponiblePara, nombre,descripcion,precio,direccion,pais,provincia,ciudad,foto,propiedades.estado AS estado
            FROM `propiedades` INNER JOIN ventanadesemanas ON propiedades.ID = ventanadesemanas.ID_propiedad
             WHERE (ventanadesemanas.numeroDeSemana = $sem) AND (ventanadesemanas.anio = $anio) AND (ventanadesemanas.estado = 'DISPONIBLE' OR ventanadesemanas.estado = 'SUBASTANDO' OR ventanadesemanas.estado = 'HOTSALE')";
      $consulta = mysqli_query($link, $query);
      if (mysqli_num_rows($consulta) > 0) { ?>
        <center>
          <!-- centro la tabla -->
          <table width="800">
            <!-- comienza la tabla -->
            <caption>
              <h2> Propiedades disponibles para reserva directa en la fecha ingresada <?php echo date('d-m-Y', strtotime($_GET['porFecha'])); ?> </h2>
            </caption><!-- titulo -->
            <tr>
              <th> </th>
            </tr>
            <?php
            while ($fila = mysqli_fetch_array($consulta)) {
              if ($fila["estado"] == "DISPONIBLE") { ?>
                <tr>
                  <!-- Abro una fila -->
                  <td>
                    <!--abro una columna muestro la FOTO-->
                    <br />
                    <img src=<?php echo $fila["foto"] ?> width=200 height="200">
                    <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
                    <br />
                  </td>
                  <td>
                    <!--abro una columna y muestro todos los demas datos -->
                    <strong><?php echo $fila["nombre"] ?></strong>
                    <br /> <!-- salto de linea -->
                    <br />
                    <?php echo "Pais: ", $fila["pais"] ?>,
                    <br />
                    <?php echo "Provincia: ", $fila["provincia"] ?>,
                    <br />
                    <?php echo "Ciudad: ", $fila["ciudad"]; ?>
                    <br />
                    <br />

                    <?php
                    if ($anio == '2019') { // determino la fecha de comienzo de la estadia
                      $comienzo = date("d-m-Y", strtotime(date("2018-12-31") . "+" . $fila['numeroDeSemana'] . " week"));
                    } else {
                      $comienzo = date("d-m-Y", strtotime(date("2019-12-23") . "+" . $fila['numeroDeSemana'] . " week"));
                    }
                    $fin = date("d-m-Y", strtotime(date("$comienzo") . "+ 6 day"));
                    ?>
                    <?php echo "Inicio: lunes ", $comienzo; ?>
                    <br />
                    <?php echo "Hasta: domingo", $fin;   ?>
                    <br />
                    <br />

                    <?php
                    if ($fila["disponiblePara"] == 'DISPONIBLE') {
                      echo "Disponible para: Reserva Directa";
                    } else {
                      if ($fila["disponiblePara"] == 'SUBASTANDO') {
                        echo "Disponible para: Subasta";
                      } else {
                        echo "Disponible para: Hotsale";
                      }
                    }
                    ?>
                    <br />
                  </td>
                  <!--cierro columna-->
                  <td>
                    <!--abro columna para mostrar el ver detalles -->
                    <a href="propiedad.php?id=<?php echo $fila["ID"] ?>"> Ver detalles</a> <!-- es una referencia a la vista de la propiedad -->
                  </td>
                  <?php
                  if ($_SESSION['rol'] == 'PREMIUM') { ?>
                    <td>
                      <?php
                      if ($fila["disponiblePara"] == 'DISPONIBLE') {  ?>
                        <!--<a onclick="confirm('Desea confirmar la reserva de la propiedad cuyo comienzo es el: lunes <?php echo $comienzo; ?> ')" href="reservar.php?sem=<?php echo $sem; ?> & anio= <?php echo $anio; ?>&id=<?php echo $fila['ID']; ?>&idsemana= <?php echo $fila['IDsemana']; ?>"> Reservar </a>-->
                        <button type="button" onclick="myFuncion ()"> Reservar </button>
                        <script>
                          function myFuncion() {

                            var r = confirm('Desea confirmar la reserva de la propiedad cuyo comienzo es el: lunes <?php echo $comienzo; ?> ');
                            if (r == true) {
                              window.location = "reservar.php?sem=<?php echo $sem; ?> & anio= <?php echo $anio; ?>&id=<?php echo $fila['ID']; ?>&idsemana= <?php echo $fila['IDsemana']; ?>";
                            }
                          }
                        </script>
                      <?php } ?>
                    </td>
                  <?php } ?>
                </tr>
              <?php } ?>

            <?php } ?>
          </table> <!-- fin de tabla -->
        </center>
      <?php
      } else { ?> <center>
          <caption>
            <h3> No hay propiedades con reserva directa para esa semana </h3>
          </caption><!-- titulo -->
        </center>
      <?php
      }



      # code... // Porque no hay reservas Lo busco en Hotsales
      $query = "SELECT hotsales.ID as idHotsale,hotsales.precio, hotsales.numeroSemana, hotsales.estado AS disponiblePara,propiedades.ID as idPropiedad, propiedades.nombre,propiedades.descripcion,propiedades.precio,propiedades.direccion,propiedades.pais,propiedades.provincia,propiedades.ciudad,propiedades.foto,propiedades.estado AS estado FROM `propiedades` INNER JOIN hotsales on hotsales.ID_propiedad=propiedades.ID WHERE hotsales.numeroSemana=$sem AND ( EXTRACT(year FROM hotsales.lunes)= $anio)";
      $consulta = mysqli_query($link, $query);
      if (mysqli_num_rows($consulta) > 0) { ?>
        <center>
          <!-- centro la tabla -->
          <table width="800">
            <!-- comienza la tabla -->
            <caption>
              <h2> Propiedades disponibles en hotsales para la fecha ingresada <?php echo date('d-m-Y', strtotime($_GET['porFecha'])); ?> </h2>
            </caption><!-- titulo -->
            <tr>
              <th> </th>
            </tr>
            <?php
            while ($fila = mysqli_fetch_array($consulta)) {

              if ($fila["disponiblePara"] == "HOTSALE") {
                $idHot = $fila["idHotsale"];
                $idProp = $fila["idPropiedad"]; ?>
                <tr>
                  <!-- Abro una fila -->
                  <td>
                    <!--abro una columna muestro la FOTO-->
                    <br />
                    <img src=<?php echo $fila["foto"] ?> width=200 height="200">
                    <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
                    <br />
                  </td>
                  <td>
                    <!--abro una columna y muestro todos los demas datos -->
                    <strong><?php echo $fila["nombre"] ?></strong>
                    <br /> <!-- salto de linea -->
                    <br />
                    <?php echo "Pais: ", $fila["pais"] ?>,
                    <br />
                    <?php echo "Provincia: ", $fila["provincia"] ?>,
                    <br />
                    <?php echo "Ciudad: ", $fila["ciudad"]; ?>
                    <br />
                    <br />

                    <?php
                    if ($anio == '2019') { // determino la fecha de comienzo de la estadia
                      $comienzo = date("d-m-Y", strtotime(date("2018-12-31") . "+" . $fila['numeroSemana'] . " week"));
                    } else {
                      $comienzo = date("d-m-Y", strtotime(date("2019-12-23") . "+" . $fila['numeroSemana'] . " week"));
                    }
                    $fin = date("d-m-Y", strtotime(date("$comienzo") . "+ 6 day"));
                    ?>
                    <?php echo "Inicio: lunes ", $comienzo; ?>
                    <br />
                    <?php echo "Hasta: domingo", $fin;   ?>
                    <br />
                    <?php echo "Precio: ", $fila["precio"];   ?>
                    <br />
                    <br />

                    <?php
                    if ($fila["disponiblePara"] == 'DISPONIBLE') {
                      echo "Disponible para: Reserva Directa";
                    } else {
                      if ($fila["disponiblePara"] == 'SUBASTANDO') {
                        echo "Disponible para: Subasta";
                      } else {
                        echo "Disponible para: Hotsale";
                      }
                    }
                    ?>
                    <br />
                  </td>
                  <!--cierro columna-->

                  <td>
                    <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>
                      <!--// aca va la linea de cerrar hotsale-->
                      <a href="aceptarHotsale.php?ID=<?php echo $idHot ?>"> Modificar... </a>

                    <?php } else {
                      if ($_SESSION['rol'] == 'ESTANDAR' or $_SESSION['rol'] == 'PREMIUM') { ?>
                        <input type="button" onclick="ConfirmDemo( <?php echo $idProp ?>, <?php echo $idHot ?>)" value="Comprar" />;
                      <?php }
                    } ?>
                  </td>
                </tr>
              <?php } ?>

            <?php } ?>

        </center>

      <?php

      } else {
        ?> <center>
          <caption>
            <h3> No hay propiedades con hotsales para esa semana </h3>
          </caption><!-- titulo -->
        </center>
      <?php
      }

      $query = "SELECT propiedades.nombre, propiedades.foto, propiedades.ciudad, propiedades.pais, propiedades.provincia, propiedades.direccion,subastas.ID as ID_subasta, subastas.estado, subastas.precioBase, subastas.ID_propiedad as ID_propiedad, subastas.semana FROM `propiedades` INNER JOIN subastas ON propiedades.ID = subastas.ID_propiedad WHERE 1=1"; //consulta a la base con solo datos q necesito
      $consulta = mysqli_query($link, $query);
      if ($fila = mysqli_num_rows($consulta) > 0) { ?>
        <!-- comparo el numero de filas que trajo la consulta con 0, si es 0 no trajo ningun dato-->
        <center>
          <!-- centro la tabla -->
          <table width="800">
            <!-- comienza la tabla -->

            <caption>
              <h2> Propiedades disponibles para subastas en la fecha ingresada <?php echo date('d-m-Y', strtotime($_GET['porFecha'])); ?> </h2>
            </caption><!-- titulo -->

            <?php
            while ($fila = mysqli_fetch_array($consulta)) { ?>
              <!--Mientras existan filas en la consulta, Muestro los datos de cada propiedad -->
              <!--Fetch array: devuelve un array datos de la fila recuperada, o FALSE si no hay más filas. trae una fila y avanza el puntero -->
              <?php if ($fila["estado"] == 'DISPONIBLE') { ?>
                <tr>
                  <!-- Abro una fila -->
                  <td>
                    <!--abro una columna muestro la FOTO-->
                    <br />
                    <img src=<?php echo $fila["foto"] ?> width="200" height="200">
                    <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
                    <br />
                  </td>
                  <td>
                    <!--abro una columna y muestro todos los demas datos -->
                    <strong><?php echo $fila["nombre"] ?></strong>
                    <br /> <!-- salto de linea -->
                    <br /> Pais:
                    <?php echo $fila["pais"] ?>
                    <br />
                    Provincia:
                    <?php echo $fila["provincia"] ?>
                    <br />Ciudad:
                    <?php echo $fila["ciudad"] ?>
                    <br /> Precio base: $
                    <?php echo $fila["precioBase"] ?>
                    <br /> Semana a subastar:
                    <?php echo $fila["semana"] ?>
                    <br />

                    <?php
                    $idSubasta = $fila['ID_subasta'];
                    $queryPujas = "SELECT max(pujas.monto) FROM pujas INNER JOIN subastas ON subastas.ID = pujas.ID_subasta WHERE pujas.ID_subasta =$idSubasta ";
                    $consultaPujas = mysqli_query($link, $queryPujas);
                    if (mysqli_num_rows($consultaPujas) > 0) {
                      $filaPujas = mysqli_fetch_array($consultaPujas);
                      if ($filaPujas["max(pujas.monto)"] != null) {
                        ?>
                        Puja mayor: $<?php echo $filaPujas["max(pujas.monto)"];
                                    }
                                  } ?>
                  </td>
                  <!--cierro columna-->

                  <td>
                    <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') { ?>
                      <!-- <a href="cerrarSubasta.php?id=<?php echo $fila["ID_subasta"] ?>"> Cerrar Subasta </a>  -->
                    <?php } else {
                      if ($_SESSION['rol'] == 'ESTANDAR' or $_SESSION['rol'] == 'PREMIUM') { ?>
                        <a href="pujar.php?idSub=<?php echo $fila["ID_subasta"] ?> & idProp= <?php echo $fila['ID_propiedad'] ?>"> Ver detalles ... </a>
                      <?php }
                    } ?>
                  </td>
                </tr>

              <?php }
            } ?>
            <!-- fin del while -->


          <?php } else { ?>
            <center>
              <caption>
                <h3> No hay propiedades con subastas para esa semana </h3>
              </caption><!-- titulo -->
            </center>

          <?php } ?>

        </table> <!-- fin de tabla -->
        <center> <br>

          <button type="button" onclick=" location.href='index.php' "> Volver </button> </center>


      <?php }
      
      // echo '<script> window.history.back()</script>';
    }

    ?>

</body>