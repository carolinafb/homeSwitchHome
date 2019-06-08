<?php
       $nombre = $_POST["nombre"];
       $apellido = $_POST["apellido"];
       $fechaNacimiento = $_POST["fechaNacimiento"];
       $email = $_POST["email"];
       $contrasena = $_POST["contrasena"];  
       $numerotarjeta = $_POST["numerotarjeta"];
       $pais = $_POST["pais"];
	   $ok = true;
       $mMay= false;/*variable para el match con mayusculas VALIDACION DE CONTRASENA*/
	   $mMin= false;/*variable para el match con minusculas*/
	   $mSim= false;/*variable para el match con simbolo*/

        if ( (empty(trim($nombre))) or (empty(trim($apellido))) or (empty(trim($fechaNacimiento))) or (empty(trim($numerotarjeta))) or (empty(trim($pais))) ) { /*me fijo ningun campo sea vacio que no es vacio*/

			$ok=false;
			
			}
		if 	(empty(trim($email))) { // si el mail es esta vacio
			$ok=false;
			}
			// si el mail no es vacio
		 	else if (!preg_match("/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/",$email)) { /*SE VALIDA QUE EL MAIL TENGA EL FORMATO DE MAIL--> combinacion de letras/numero/signos seguidos de @ seguido de convinacion + . algo */				
				$ok=false;
				echo '<script>  alert ("email incorrecto");</script>';
			}
		
		if (empty(trim($contrasena))) { /*me fijo que no es vacio*/
			$ok=false;
			}	
			else{
				if (strlen($contrasena)>=6){/* si la contraseña tinene 6 o mas digitos */
				    for($i=0;$i<strlen($contrasena);$i++){ 
        		         if ((preg_match("/^([a-z])+$/",$contrasena[$i]))){ // por lo menos 1 mininuscula 
		        		    $mMin= true;
	              			}
	            		 if (preg_match("/^([A-Z])+$/",$contrasena[$i])){ // por lo menos 1 mayuscula
		            		 $mMay= true;
	              			}
		         		if (preg_match("/^([0-9])+$/",$contrasena[$i])||(preg_match("/[\W]/",$contrasena[$i]))){ // por lo menos 1 numero
			          		$mSim= true;
		         			}
					}
		    		if (!$mMin){
		    			echo '<script>  alert ("Contraseña incorrecta,faltan por lo menos 1 minuscula");</script>';
		    			$ok=false;
		    		}
		    		if (!$mMay){
		    			echo '<script>  alert ("Contraseña incorrecta, faltan por lo menos 1 mayuscula  ");</script>';
		    			$ok=false;
		    		}
		    		if (!$mSim){ 
						echo '<script>  alert ("Contraseña incorrecta, falta por lo menos 1 simbolo o numero");</script>';
						$ok=false;
					}
				}else{ // si la contraseña tiene menos digitos
					$ok=false;
					echo '<script>  alert ("La contraseña debe contener minimo 6 digitos ");</script>';

				}
	
			}
		
		if ($ok===true){//OK ES VERDADERO PORQUE TODOS LOS DATOS SON LOS CORRECTOS 
			include "conexion.php";
       		$link=conexion();
       		$aux=mysqli_query($link,"SELECT * FROM usuario WHERE email = '$email'");// me fijo si existe el mail 
      		if(mysqli_num_rows($aux) == 0){ // obtengo el numero de filas de la variable, si es 0 es porque el mail no esta registrado. 
				mysqli_query ($link,"INSERT INTO `usuario`(`nombre`, `apellido`, `email`,`contrasena`,`pais`,`numeroTarjeta`,`fechaNacimiento`,`rol`) VALUES('$nombre','$apellido','$email','$contrasena','$pais','$numerotarjeta','$fechaNacimiento','ESTANDAR')");// FUNCIONA WOJU
				echo '<script> alert ("Usuario registrado correctamente");</script>';
				echo '<script> window.location="index.php"; </script>';
			}else{ 
         		echo '<script> alert ("El usuario que intenta registrar ya existe");</script>';
      		  	echo '<script> window.location="index.php"; </script>';  
     		} 
 		}else{
  			echo '<script> window.location="formularioderegistro.php";</script>';
  			
  			}
?>
