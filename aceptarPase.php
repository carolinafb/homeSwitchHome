<?php
session_start();
include 'conexion.php';
$link = conexion();
$userID = $_GET['idUser'];
$solicitudID= $_GET['idPase'];
?>

<head> </head>
<title>Home Switch Home </title>
</head>

<body>
    <left>
        <a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50"> </a>
    </left>
    <?php
      if (isset($_SESSION['nombre'])) { // si la sesion es un admin 
        if ($_SESSION['rol'] == 'ADMINISTRADOR') {
            echo "entro";
            echo "id user, ",$userID, " id PAse: ", $solicitudID;
            $queryTipoUser = "SELECT ID, rol FROM usuario WHERE ID=$userID ";
            $consultaTipoUser = mysqli_query($link, $queryTipoUser);
            $queryPase = "SELECT ID FROM solicitupases WHERE ID=$solicitudID ";
            $consultaPase = mysqli_query($link, $queryPase);
            if (mysqli_num_rows($consultaTipoUser) > 0) {
                $fila = mysqli_fetch_array($consultaTipoUser);
              //  echo "entro en el if para ver si devolvio algo la consulta del usuario, el ROL del usuairo es: ",$fila["rol"];
                
                if ($fila["rol"] == "ESTANDAR") {
                    $queryPremium = "UPDATE `usuario` SET `rol` = 'PREMIUM' WHERE `usuario`.`ID` = $userID";
                    mysqli_query($link, $queryPremium);
                    echo '<script> alert ("Usuario ESTANDAR pasado a PREMIUM correctamente")</script>';
                    
                } else {
                    $queryEstandar = "UPDATE `usuario` SET `rol` = 'ESTANDAR' WHERE `usuario`.`ID` = $userID;";
                    mysqli_query($link, $queryEstandar);
                    echo '<script> alert ("Usuario PREMIUM pasado a ESTANDAR correctamentee")</script>';
                }
                $queryActualizarPase = "UPDATE `solicitudpases` SET `estado` = 'HABILITADA' WHERE `solicitudpases`.`ID` = $solicitudID";
                mysqli_query($link, $queryActualizarPase);
            }
       }
   }
   echo '<script> window.location="solicitudPaseUsuario.php"</script>'; ?>
</body>