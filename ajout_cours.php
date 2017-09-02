<?php include "restrict/config.php";
?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center" onload="document.forms.formulaire.nom.focus()">
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nb_cours = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM cours");
$nb_cours = mysql_fetch_array($nb_cours);
$nb_cours = $nb_cours['nbre_entrees']+1;
//&eacute;criture dans la base courss
if(	isset($_POST["nom"]) && !empty($_POST["nom"]) &&
	isset($_POST["tarif"]) && !empty($_POST["tarif"])){
//control si cours existe
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$tarif = mysql_real_escape_string(htmlspecialchars($_POST['tarif']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$classement = mysql_real_escape_string(htmlspecialchars($_POST['classement']));
if(isset($_POST["obligatoire"])){$obligatoire=1;}else{$obligatoire=0;}
//travail sur BDD
$ctrl_cours = mysql_query("SELECT * FROM cours WHERE nom = '$nom'");
$ctrl_cours = mysql_fetch_array($ctrl_cours);
//fin travail sur BDD
if ($ctrl_cours != NULL){
?>
<script>alert ("Ce cours existe déjà,\nveuillez changer de nom.")</script>
<?php
$_POST = "";
}
//fin control si cours existe
else {
//inscription du cours dans la base
mysql_query("INSERT INTO cours VALUES(NULL, NOW( ), '$nom', '$tarif', '$obs', '1', '$obligatoire', '$classement')")or die(mysql_error());
//fin d'inscription du cours dans la base
mysql_close();
//fin travail sur BDD
$_POST = "";
?>
<script>alert ("Enregistrement réussi")</script>
<?php
}}
//donn&eacute;e manquante pour un nouveau cours
else{
if(	isset($_POST["nom"]) &&
	isset($_POST["tarif"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau cours")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<body>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau cours&nbsp;</legend>
	<form method="post" action="ajout_cours.php" name="formulaire">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="20" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Prix : </b></font><input type="text" name="tarif" size="5" value="<?php if(isset($_POST["tarif"])){ echo $_POST["tarif"]; } ?>">
	</td>
	</tr>
	<tr>
	<td height=5>
	</td>
	</tr>
	<tr>
	<td>
	<font>Classement : </font><input type="text" name="classement" size="2" value="<?php if(isset($_POST["classement"])){ echo $_POST["classement"]; } else { echo $nb_cours; } ?>">
	</td>
	<td>
	</td>
	<td align=left>
	<label for="obligatoire">Cours obligatoire</label><input type="checkbox" name="obligatoire" id="1">
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_cours.php?';">
</center>
</body>