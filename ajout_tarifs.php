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
//&eacute;criture dans la base tarifs
if(	isset($_POST["nom"]) && !empty($_POST["nom"]) &&
	isset($_POST["tarif"]) && !empty($_POST["tarif"])){
//control si tarif existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$tarif = mysql_real_escape_string(htmlspecialchars($_POST['tarif']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
if(isset($_POST["obligatoire"])){$obligatoire=1;}else{$obligatoire=0;}
//travail sur BDD
$ctrl_tarif = mysql_query("SELECT * FROM tarifs_activites WHERE nom = '$nom' AND id_activites = '$id'");
$ctrl_tarif = mysql_fetch_array($ctrl_tarif);
//fin travail sur BDD
if ($ctrl_tarif != NULL){
?>
<script>alert ("Ce Tarif existe déjà,\nveuillez changer de nom.")</script>
<?php
$_POST = "";
}
//fin control si tarif existe
else {
//inscription du tarif dans la base
mysql_query("INSERT INTO tarifs_activites VALUES(NULL, NOW( ), '$id', '$nom', '$tarif', '$obs', '1', '$obligatoire')")or die(mysql_error());
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
if(	isset($_POST["nom"]) &&
	isset($_POST["tarif"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau tarif")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<body>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau tarif&nbsp;</legend>
	<form method="post" action="ajout_tarifs.php?id_activite=<?php echo $id; ?>">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="15" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Prix : </b></font><input type="text" name="tarif" size="5" value="<?php if(isset($_POST["tarif"])){ echo $_POST["tarif"]; } ?>">
	</td>
	</tr>
	<tr>
	<td colspan="3" align=center>
	<label for="obligatoire">Tarif Obligatoire</label><input type="checkbox" name="obligatoire" id="1">
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_tarifs_activite.php?id_activite=<?php echo $id; ?>';">
</center>
</body>