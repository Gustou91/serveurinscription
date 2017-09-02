<?php include "../restrict/config.php";
echo "<br><br><center><b>Le systeme est en train de s'éteindre.<br>Merci de patienter avant de le débrancher.</b></center>";
echo "<br><center><b>Il ne doit y avoir plus qu'une seule diode rouge qui est allumée...</b></center>";
system('sudo /sbin/shutdown -h now');
?>