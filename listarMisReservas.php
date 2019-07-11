<?php
   session_start();
   if (isset($_SESSION['nombre'])) {
      if (($_SESSION['rol']=='ESTANDAR') or ($_SESSION['rol']=='PREMIUM')){
          include "conexion.php";
          $link=conexion();
          ?>
          <head>
            <style>
            table {font-family: arial, sans-serif;border-collapse: collapse;}
            td, th {text-align: center;padding: 5px;}
            tr:nth-child(even) {background-color: #dddddd;}
            </style>

            <title> Mis Reservas</title>
            <left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a></left>
          </head>
          <body>
            <?php
            $query ="SELECT  reservas.estado,reservas.ID as ID_Reserva, reservas.ID_propiedad, reservas.fechaInicio, reservas.fechaFin, reservas.operacion,propiedades.nombre,propiedades.descripcion, propiedades.precio, propiedades.direccion, propiedades.pais,propiedades.provincia,propiedades.ciudad,propiedades.foto FROM `reservas` INNER JOIN propiedades on reservas.ID_propiedad = propiedades.ID WHERE `ID_usuario` = {$_SESSION['id']}";
            $reservas = mysqli_query($link,$query);
            if ($fila=mysqli_num_rows($reservas) > 0) {
            ?>
              <center><!-- centro la tabla -->
        				<table width="800"><!-- comienza la tabla -->
        					<caption>
        						<h3> Reservas </h3><!-- titulo -->
        					</caption>
                  <?php
        					while ($fila = mysqli_fetch_array($reservas)) {
                  ?>
                    <tr>
                        <td>
                          <br/>
                          <img src= <?php echo $fila["foto"] ?>  width=150 height="150" > <!--para lograr que funcione tuve que poner "" entre la url en la base de datos -->
                          <br/>
                        </td>
                        <td>
                          <strong><?php echo $fila["nombre"] ?></strong>
                          <br/> <!-- salto de linea -->
                          <br/>
                          <?php echo "Pais: ", $fila["pais"] ?>,
                          <br/>
                          <?php echo "Provincia: ",$fila["provincia"] ?>,
                          <br/>
                          <?php echo "Ciudad: ", $fila["ciudad"]; ?>
                          <br/><br/>
                          <a href="propiedad.php?id=<?php echo $fila["ID_propiedad"] ?>"> Ver detalles de propiedad</a>
                        </td>
                        <?php
                        $numeroDeSemana = $fila['fechaInicio'];
                        $numeroDeSemana = date('W',strtotime(date("$numeroDeSemana"))); ?>
                        <td>
                          </br>
                          <?php echo "Comiezo de estadia: ";
                          ?></br><?php
                          echo"lunes ", $fila['fechaInicio']; ?>
                          </br>
                          </br>
                          <?php echo "Fin de estadia: ";
                          ?></br><?php
                          echo"domingo ", $fila['fechaFin']; ?>
                          </br>
                          </td>
                        <td>
                          <?php
                          echo " Estado: ";
                          ?></br><?php
                          echo $fila['estado']; ?>
                        </td>
                        <?php
                        if ($fila['estado'] !== 'CANCELADO') {
                          $idReserva = $fila['ID_Reserva'];
                          $idPropiedad = $fila['ID_propiedad'];
                          //echo"reserv: ", $idReserva," prop: ";
                          //echo $idPropiedad; ?>
                          <td>
                            <a onclick="confirm('Estas seguro de cancelar la reserva?')" href="cancelarReserva.php?idReserva=<?php echo$idReserva?>&idProp=<?php echo$idPropiedad?>">Cancelar reserva</a>
                          </td>
                       <?php
                        }?>
                    </tr>

                  <?php } ?>
          </body>
        <?php }else {
          echo "<script> alert ('No tiene registro de reservas realizadas');</script>	";
          echo '<script> window.history.back()</script>';
        } ?>
<?php
      }
  }
  ?>
<?php
/* ESTE ES EL BOTON CONFIRM QUE EL CANCELAR FUNCIONA. PEERO NO PASA BIEN LOS PARAMETROS
PORQUE EJ: LE PASAS EL ID NUMERO 129 Y DEL OTRO LADO RECIBE  130. ASI QUE TOME LA DECICION
DE DEJAR EL ENLAZE CON <A HREF></A> 

                      <td>
                          <?php
                          $idReserva = $fila['ID_Reserva'];
                          $idPropiedad = $fila['ID_propiedad'];
                           echo"reserv: ", $idReserva," prop: ";
                           echo $idPropiedad; ?>
                        </td>
                        <?php
                        if ($fila['estado'] !== 'CANCELADO') { ?>
                          <td>
                            <button  type="button"  onclick="confirmacion ()" > Cancelar reserva </button>
                            <script>
                              function confirmacion (){
                                  var r = confirm('Estas seguro de cancelar la reserva?');
                                  if (r == true) {
                                     window.location="cancelarReserva.php?idReserva=<?php echo$idReserva?>&idProp=<?php echo$idPropiedad?>";
                                  }
                                }
                            </script>
                          </td>
                      <?php
                      }?>*/
 ?>
