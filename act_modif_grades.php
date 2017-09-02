<?php
include "restrict/config.php";
$variable = 0;
//&eacute;criture dans la base BOX
if(	isset($_POST["nom"]) && !empty($_POST["nom"])){
//control si le BOX existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$classement = mysql_real_escape_string(htmlspecialchars($_POST['classement']));
$id_grade = $_POST["id_grade"];
$id_activite = $_POST["id_activite"];
//inscription de l'activite dans la base
mysql_query("UPDATE grades SET nom='$nom', obs='$obs', classement='$classement' WHERE id='$id_grade'")or die(mysql_error());
//fin d'inscription de l'activite dans la base
mysql_close();
//fin travail sur BDD
$variable = 1;
$_POST = "";
}
//donn&eacute;e manquante pour une nouvelle activite
elseif(	isset($_POST["nom"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le grade")</script>
<?php
}
if ($variable == 1){
?>
<center>
Grade modifi&eacute; avec succes<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_grades_activite.php?id_activite=<?php echo $id_activite; ?>';">
</center>
<?php
}
elseif((isset($_REQUEST["id_grade"]) && !empty($_REQUEST["id_grade"]))){
$id_grade = $_REQUEST["id_grade"];
$id_activite = $_REQUEST["id_activite"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$grade = mysql_query("SELECT * FROM grades WHERE id='$id_grade'");
$grade = mysql_fetch_array($grade);
mysql_close();
//fin donn&eacute;e manquante pour un grade
//fin &eacute;criture dans la base grade
?>
<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier le grade : <?php echo $grade["nom"]; ?>&nbsp;</legend>
	<form method="post" action="act_modif_grades.php?id_activite=<?php echo $id_activite; ?>">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="15" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } else {echo $grade["nom"];} ?>">
	</td>
	</tr>
	<tr>
	<td height=10>
	</td>
	</tr>
	<tr>
	<td>
	<font>Classement : </font><input type="text" name="classement" size="2" value="<?php if(isset($_POST["classement"])){ echo $_POST["classement"]; } else { echo $grade['classement']; } ?>">
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $grade["obs"];} ?></textarea><br><br>
		<input type="hidden" name="id_grade" value="<?php echo $id_grade; ?>">
		<input type="hidden" name="id_activite" value="<?php echo $id_activite; ?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_grades_activite.php?id_activite=<?php echo $id_activite; ?>';">
</center>
<?php } ?>
</body>
</html>