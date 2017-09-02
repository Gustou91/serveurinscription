<?php
include "restrict/config.php";
if((isset($_REQUEST["id_ville"]) && !empty($_REQUEST["id_ville"]))){
$id = $_REQUEST["id_ville"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("UPDATE villes SET actif='1' WHERE id='$id'");
mysql_close();
echo "<center>ville restaur&eacute;</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; modifi&eacute;</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_villes.php';">
</center>