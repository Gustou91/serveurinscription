<?php include "restrict/config.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$cnil = mysql_query("SELECT valeur FROM generale WHERE nom = 'cnil'");
$cnil = mysql_fetch_array($cnil);
mysql_close()
?>
<html>
<head>
</head>
<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue size=4>Voici quelques information sur la loi CNIL</font></legend>
<textarea readonly cols="80" rows="19"><?php echo stripslashes($cnil['valeur'])?></textarea>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close();">
</center>
</body>
</html>