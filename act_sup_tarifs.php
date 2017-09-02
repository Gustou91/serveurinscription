<?php
include "restrict/config.php";
if((isset($_REQUEST["id_tarif"]) && !empty($_REQUEST["id_tarif"]))){
$id = $_REQUEST["id_tarif"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$id_activites=mysql_query("SELECT * FROM tarifs_activites WHERE id=$id");
$id_activites = mysql_fetch_array($id_activites);
mysql_query("UPDATE tarifs_activites SET actif='0' WHERE id='$id'");
mysql_close();
echo "<center>Tarif suprim&eacute;</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; suprim&eacute;</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_tarifs_activite.php?id_activite=<?php echo $id_activites['id_activites']; ?>';">
</center>