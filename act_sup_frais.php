<?php
include "restrict/config.php";
if((isset($_REQUEST["id_frais"]) && !empty($_REQUEST["id_frais"]))){
$id = $_REQUEST["id_frais"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("UPDATE frais SET actif='0' WHERE id='$id'");
mysql_close();
echo "<center>frais suprim&eacute;</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; modifi&eacute;</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_frais.php';">
</center>