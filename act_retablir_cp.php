<?php
include "restrict/config.php";
if((isset($_REQUEST["id_cp"]) && !empty($_REQUEST["id_cp"]))){
$id = $_REQUEST["id_cp"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("UPDATE cp SET actif='1' WHERE id='$id'");
mysql_close();
echo "<center>Code Postal restaur&eacute;</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; modifi&eacute;</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_cp.php';">
</center>