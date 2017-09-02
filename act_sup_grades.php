<?php
include "restrict/config.php";
if((isset($_REQUEST["id_grade"]) && !empty($_REQUEST["id_grade"]))){
$id = $_REQUEST["id_grade"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$id_grade=mysql_query("SELECT * FROM grades WHERE id=$id");
$id_grade = mysql_fetch_array($id_grade);
mysql_query("UPDATE grades SET actif='0' WHERE id='$id'");
mysql_close();
echo "<center>Grade suprim&eacute;</center>";
}
else{ echo "<center>Il y a eu une erreur, rien n'a &eacute;t&eacute; suprim&eacute;</center>";}
?>
<center><br><input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_grades_activite.php?id_activite=<?php echo $id_grade['id_activites']; ?>';">
</center>