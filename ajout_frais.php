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
$nb_frais = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM frais");
$nb_frais = mysql_fetch_array($nb_frais);
$nb_frais = $nb_frais['nbre_entrees']+1;
//&eacute;criture dans la base frais
if(	isset($_POST["nom"]) && !empty($_POST["nom"]) &&
	isset($_POST["tarif"]) && !empty($_POST["tarif"])){
//control si frais existe
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$tarif = mysql_real_escape_string(htmlspecialchars($_POST['tarif']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$classement = mysql_real_escape_string(htmlspecialchars($_POST['classement']));
if(isset($_POST["obligatoire"])){$obligatoire=1;}else{$obligatoire=0;}
if(isset($_POST["caution"])){$caution=1;}else{$caution=0;}
//travail sur BDD
$ctrl_frais = mysql_query("SELECT * FROM frais WHERE nom = '$nom'");
$ctrl_frais = mysql_fetch_array($ctrl_frais);
//fin travail sur BDD
if ($ctrl_frais != NULL){
?>
<script>alert ("Ce frais existe déjà,\nveuillez changer de nom.")</script>
<?php
$_POST = "";
}
//fin control si frais existe
else {
//inscription du frais dans la base
mysql_query("INSERT INTO frais VALUES(NULL, NOW( ), '$nom', '$tarif', '$obs', '1', '$obligatoire', '$classement', '$caution')")or die(mysql_error());
//fin d'inscription du frais dans la base
$nb_frais++;
mysql_close();
//fin travail sur BDD
$_POST = "";
?>
<script>alert ("Enregistrement réussi")</script>
<?php
}}
//donn&eacute;e manquante pour un nouveau frais
else{
if(	isset($_POST["nom"]) &&
	isset($_POST["tarif"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau frais")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<body>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau frais&nbsp;</legend>
	<form method="post" action="ajout_frais.php" name="formulaire">
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
	<tr height=5>
	</tr>
	<tr>
	<td align=center colspan=3>
	<font>Classement : </font><input type="text" name="classement" size="2" value="<?php if(isset($_POST["classement"])){ echo $_POST["classement"]; } else { echo $nb_frais; } ?>">
	&nbsp;
	<label for="1">Frais obligatoire</label><input type="checkbox" name="obligatoire" id="1">
	&nbsp;
	<label for="2">Caution</label><input type="checkbox" name="caution" id="2">
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_frais.php?';">
</center>
</body>