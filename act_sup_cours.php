<?php
include "restrict/config.php";
if((isset($_REQUEST["id_cours"]) && !empty($_REQUEST["id_cours"]))){
$id = $_REQUEST["id_cours"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("UPDATE cours SET actif='0' WHERE id='$id'");
mysql_close();
echo "<center>Cours suprim&eacute;</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; modifi&eacute;</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_cours.php';">
</center>