<?php
/*
   //Carácteres para la contraseña
   $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890$%&_.!?";
   $password = "";
   //Reconstruimos la contraseña segun la longitud que se quiera
   for($i=0;$i<20;$i++) {
      //obtenemos un caracter aleatorio escogido de la cadena de caracteres
      $password .= substr($str,rand(0,62),1);
   }
   //Mostramos la contraseña generada
   //echo 'Password generado: '.$password;
   echo md5('UWFduOhyYXxovkk');
   if(md5('UWFduOhyYXxovkk') == '81befb5c5366f609b1ab3e3289b01b9b'){
		echo 'si se cambió';
   }
*/

?>
<form action="xml.php" name="xml" id="xml" target="_blank"   method="POST" enctype="multipart/form-data"">
<input type="file" id="fact" name = "fact">
<button type= "submit">LEER</button>

</form>