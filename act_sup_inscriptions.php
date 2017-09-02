<?php
include "restrict/config.php";
if((isset($_REQUEST["id_inscription"]) && !empty($_REQUEST["id_inscription"]))){
$id = $_REQUEST["id_inscription"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("UPDATE inscriptions SET actif='0' WHERE id='$id'");
mysql_close();
echo "<center>Cette inscription a bien &eacute;t&eacute; suprim&eacute;e.</center>";

}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; suprim&eacute;</center>";}

if((($_REQUEST['page'])) == "consulter_inscriptions"){
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'consulter_inscriptions.php?saison=<?php echo str_replace("_","/",$_GET['saison']); ?>';"></center>
<?php
}
elseif((($_REQUEST['page'])) == "recherche_anniversaire"){
?>
<script type="text/javascript">
		function OpenBooking_ferme() {
			opener.location = 'recherche_anniversaire.php?de_aaaa=<?php echo $_REQUEST["de_aaaa"];?>$a_aaaa=<?php echo $_REQUEST["a_aaaa"];?>&type=<?php echo $_REQUEST["type"];?>';
			window.close();
		}
</script>
<center><br><input type="button" value="FERMER" onClick="OpenBooking_ferme()"></center>
<?php
}
?>