<?php include "../restrict/config.php";?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center">
<center>
<?php 
setlocale(LC_TIME, "fr");
echo "Bonjour, aujourd'hui nous sommes le <b><font color=red>";
echo $nom_long_jour_actu;
echo "&nbsp;".strftime("%d")."&nbsp;";
echo $nom_long_mois_actu;
echo "&nbsp;".strftime("%Y")."</font></b>, il est ".strftime("%H:%M:%S").".<b>";

mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );

$titre_1 = mysql_query("SELECT valeur FROM generale WHERE nom='titre_1'");
$titre_1 = mysql_fetch_array($titre_1);
$titre_1 = $titre_1['valeur'];

$titre_2 = mysql_query("SELECT valeur FROM generale WHERE nom='titre_2'");
$titre_2 = mysql_fetch_array($titre_2);
$titre_2 = $titre_2['valeur'];

$parametres = mysql_query("SELECT valeur FROM generale WHERE nom = 'image_site'");
$parametres = mysql_fetch_array($parametres);
mysql_close();
?>
<br><br><br><br>
<table border=0 valign=middle>
<tr>
<td align=left>
<?php echo nl2br(stripslashes($titre_1)); ?>
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><img src="../img/<?php echo $parametres['valeur']; ?>" width="300" height="300">
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align=right>
<?php echo nl2br(stripslashes($titre_2)); ?>
</td>
</tr>
</table>
</body>
</html>