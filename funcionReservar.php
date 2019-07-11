<script>
  function myFuncion (){

      var r = confirm('Desea confirmar la reserva de la propiedad cuyo comienzo es el: lunes <?php echo $comienzo; ?> ');
      if (r == true) {
         window.location="reservar.php?sem=<?php echo $sem; ?> & anio= <?php echo $anio ;?>&id=<?php echo $fila['ID'];?>&idsemana= <?php echo $fila['IDsemana']; ?>";
      }
  }
</script>
