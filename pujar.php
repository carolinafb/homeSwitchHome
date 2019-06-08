<?php
    session_start();
    include "conexion.php";
    $link=conexion();
   
    if(isset($_SESSION['login'])){
        if ($_SESSION['rol']== 'USUARIO'){        
            $idSubasta= $_GET["idSub"];
            $idPropiedad = $_GET["idProp"];
            ?>

            <html>
            <head>
 			<title>Puja</title>
	 		<left><a href="index.php"> <img src='imagenes/HSH-Logo.svg' title="Home Switch Home" width="150" height="50" > </a></left>
 			</br>
            </head>
            <body>
						<form name='ingresarPuja' action='ValidarPuja.php' method="POST">
						<fieldset>
                        <legend> <h1> Ingresar monto de puja:</h1>	</legend>
	    	 			<table>
    		  		    <tr>
	    	  			    <td>Monto: </td>
    	  			        <td><input type= 'number' min='0' name='montoPuja' id='montoPuja' required/></td>
    	  			    </tr>
                            <td><input type="hidden" value="<?php echo $idSubasta ?>" name="idSubasta" id="idSubasta"></td>   
                            <td><input type="hidden" value="<?php echo $idPropiedad ?>" name="idPropiedad" id= "idPropiedad"></td>                    
                      	</table>
							<input type="submit" value="Pujar"> <!--boton-->
							</fieldset>
						</form>

            </html>



<?php	
    }
	}else{
		 echo '<script> window.location="index.php"</script>';
    }	
?>