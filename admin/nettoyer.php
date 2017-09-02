<html>
<?php include "../restrict/config.php";?>
<body>
<form method="post" action="parametres.php">
<?php 
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nb_0_inscription_frais = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_frais WHERE actif='0'");
$nb_0_inscription_grades = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_grades WHERE actif='0'");
$nb_0_inscription_cours = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_cours WHERE actif='0'");
$nb_0_inscription_tarifs_activites = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_tarifs_activites WHERE actif='0'");

$nb_inscription_frais = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_frais");
$nb_inscription_grades = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_grades");
$nb_inscription_cours = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_cours");
$nb_inscription_tarifs_activites = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM inscription_tarifs_activites");


mysql_query("DELETE FROM inscriptions_cours WHERE actif = '0'");
mysql_query("DELETE FROM inscriptions_frais WHERE actif = '0'");
mysql_query("DELETE FROM inscriptions_grades WHERE actif = '0'");
mysql_query("DELETE FROM inscriptions_tarifs_activites WHERE actif = '0'");

echo "<br><br><center><b>Base de données nettoyée.<b></center>";
//echo "La table d'enregistrement des frais contenait <b>".$nb_inscription_frais['nbre_entrees']."</b> nombres d'entrées. ".$nb_0_inscription_frais['nbre_entrees']." enregistrements inactifs ont été définitivement effacé.<br><br>";
// echo "La table d'enregistrement des grades contenait <b>".$nb_inscription_grades['nbre_entrees']."</b> nombres d'entrées. ".$nb_0_inscription_grades['nbre_entrees']." enregistrements inactifs ont été définitivement effacé.<br><br>";
// echo "La table d'enregistrement des cours contenait <b>".$nb_inscription_cours['nbre_entrees']."</b> nombres d'entrées. ".$nb_0_inscription_cours['nbre_entrees']." enregistrements inactifs ont été définitivement effacé.<br><br>";
// echo "La table d'enregistrement des tarifs d'activités contenait <b>".$nb_inscription_tarifs_activites['nbre_entrees']."</b> nombres d'entrées. ".$nb_0_inscription_tarifs_activites['nbre_entrees']." enregistrements inactifs ont été définitivement effacé.";

?>
</body>
</html>