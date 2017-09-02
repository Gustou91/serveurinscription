<?php include "restrict/config.php";
if((isset($_REQUEST["id_activite"]) && !empty($_REQUEST["id_activite"]))){
$id = $_REQUEST["id_activite"];
}
?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center">
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nb_grade = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM grades WHERE id_activites='$id'")or die(mysql_error());
$nb_grade = mysql_fetch_array($nb_grade);
$nb_grade = $nb_grade['nbre_entrees']+1;
//&eacute;criture dans la base grades
if(	isset($_POST["nom"]) && !empty($_POST["nom"])){
//control si grade existe
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$classement = mysql_real_escape_string(htmlspecialchars($_POST['classement']));
//travail sur BDD
$ctrl_grade = mysql_query("SELECT * FROM grades WHERE nom = '$nom' AND id_activites = '$id'");
$ctrl_grade = mysql_fetch_array($ctrl_grade);
//fin travail sur BDD
if ($ctrl_grade != NULL){
?>
<script>alert ("Ce Grade existe déjà,\nveuillez changer de nom.")</script>
<?php
$_POST = "";
}
//fin control si grade existe
else {
//inscription du grade dans la base
mysql_query("INSERT INTO grades VALUES(NULL, NOW( ), '$id', '$nom', '$obs', '1', '$classement')")or die(mysql_error());
//fin d'inscription du grade dans la base
mysql_close();
//fin travail sur BDD
$_POST = "";
?>
<script>alert ("Enregistrement réussi")</script>
<?php
}}
//donn&eacute;e manquante pour un nouveau grade
else{
if(	isset($_POST["nom"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau grade")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<body>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau grade&nbsp;</legend>
	<form method="post" action="ajout_grades.php?id_activite=<?php echo $id; ?>">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="20" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } ?>">
	</td>
	</tr>
	<tr>
	<td height=10>
	</td>
	</tr>
	<tr>
	<td>
	<font>Classement : </font><input type="text" name="classement" size="2" value="<?php if(isset($_POST["classement"])){ echo $_POST["classement"]; } else { echo $nb_grade; } ?>">
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_grades_activite.php?id_activite=<?php echo $id; ?>';">
</center>
</body>