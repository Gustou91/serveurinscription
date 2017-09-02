<?php include "restrict/config.php";?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center">
<center>
<?php 
setlocale(LC_TIME, "fr");
echo "ligne 1 : ceci est une ligne test avec des caractères spéciaux : ù é è à ç ";
echo "<br><br><br>";

mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);
$test = mysql_query("SELECT valeur FROM generale WHERE nom = 'ligne_contrat_01'");
$test = mysql_fetch_array($test);
echo "ligne 2 : ceci est une ligne test avec des caractères spéciaux extrait d'une requete SQL :<br>".$test['valeur'];
echo "<br><br><br>";
mysql_close();

mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);
$test = mysql_query("SELECT valeur FROM generale WHERE nom = 'ligne_contrat_01'");
$test = mysql_fetch_array($test);
mysql_set_charset( 'utf8' );
echo "ligne 3 : ceci est une ligne test avec des caractères spéciaux extrait d'une requete SQL + un paramètre :<br>".$test['valeur'];
echo "<br><br><br>";
mysql_close();
?>
</body>
</html>