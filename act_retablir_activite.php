<?php
include "restrict/config.php";
if((isset($_REQUEST["id_activite"]) && !empty($_REQUEST["id_activite"]))){
$id = $_REQUEST["id_activite"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("UPDATE activites SET actif='1' WHERE id='$id'");
mysql_close();
echo "<center>L'activit&eacute; a bien &eacute;t&eacute; r&eacute;tablie</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; r&eacute;tabli</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_activites.php';"></center>