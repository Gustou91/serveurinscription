<?php include "../restrict/config.php";
echo "<br><br><center><b>Le systeme est en train de s'�teindre.<br>Merci de patienter avant de le d�brancher.</b></center>";
echo "<br><center><b>Il ne doit y avoir plus qu'une seule diode rouge qui est allum�e...</b></center>";
system('sudo /sbin/shutdown -h now');
?>