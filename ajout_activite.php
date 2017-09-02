<?php include "restrict/config.php";?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center" onload="document.forms.formulaire.nom.focus()">
<center>
<?php
//&eacute;criture dans la base tarifs
if(	isset($_POST["nom"]) && !empty($_POST["nom"])){
//control si tarif existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
//travail sur BDD
$ctrl_activite = mysql_query("SELECT * FROM activites WHERE nom = '$nom'");
$ctrl_activite = mysql_fetch_array($ctrl_activite);
//fin travail sur BDD
if ($ctrl_activite != NULL){
?>
<script>alert ("Cette activité existe déjà,\nveuillez changer de nom.")</script>
<?php
$_POST = "";
}
//fin control si tarif existe
else {
//inscription du tarif dans la base
mysql_query("INSERT INTO activites VALUES(NULL, NOW( ), '$nom', '$obs', '1')")or die(mysql_error());
//fin d'inscription du tarif dans la base
mysql_close();
//fin travail sur BDD
$_POST = "";
?>
<script>alert ("Enregistrement réussi")</script>
<?php
}}
//donn&eacute;e manquante pour un nouveau tarif
else{
if(isset($_POST["nom"])){
?>
<script>alert ("Il manque le nom\nde la nouvelle activite")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau tarif&nbsp;</legend>
	<form method="post" action="ajout_activite.php" name="formulaire">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="20" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } ?>">
	</td>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_activites.php';">
</center>
</body>