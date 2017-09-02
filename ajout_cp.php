<?php include "restrict/config.php";
?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center" onload="document.forms.formulaire.cp.focus()">
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
//&eacute;criture dans la base frais
if(	isset($_POST["cp"]) && !empty($_POST["cp"])){
//control si frais existe
$cp = mysql_real_escape_string(htmlspecialchars($_POST['cp']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
//travail sur BDD
$ctrl_cp = mysql_query("SELECT * FROM cp WHERE cp = '$cp'");
$ctrl_cp = mysql_fetch_array($ctrl_cp);
//fin travail sur BDD
if ($ctrl_cp != NULL){
?>
<script>alert ("Ce Code Postal existe déjà,\nveuillez en changer.")</script>
<?php
$_POST = "";
}
//fin control si frais existe
elseif($cp < 9501){
?>
<script>alert ("Ce Code Postal semble erroné.")</script>
<?php
}
else {
//inscription du frais dans la base
mysql_query("INSERT INTO cp VALUES(NULL, NOW( ), '$cp', '$obs', '1')")or die(mysql_error());
//fin d'inscription du frais dans la base
mysql_close();
//fin travail sur BDD
$_POST = "";
?>
<script>alert ("Enregistrement réussi")</script>
<?php
}}
//donn&eacute;e manquante pour un nouveau frais
else{
if(isset($_POST["cp"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau Code Postal")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
$page = $_REQUEST["page"];
?>
<body>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau Code Postal&nbsp;</legend>
<?php
if (isset($_GET['historique']))
{
$historique = $_GET['historique'];
}else
{
$historique = "";
}
?>
	<form method="post" action="ajout_cp.php?page=<?php echo $page."&historique=".$historique; ?>" name="formulaire">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>CP : </b></font><input type="text" name="cp" size="5" maxlength="5" value="<?php if(isset($_POST["cp"])){ echo $_POST["cp"]; } ?>">
	</td></tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<?php
if ($historique != ""){ $historique = "page=".$historique;}
if ($page=="ajout_ville"){
?>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'ajout_ville.php?<?php echo $historique; ?>';">
<?php
}
elseif ($page=="adm_cp"){
?>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_cp.php?<?php echo $historique; ?>';">
<?php
}
elseif ($page=="act_modif_ville"){
?>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_modif_ville.php?id_ville=<?php echo $_GET['historique']; ?>';">
<?php
}
elseif ($page=="ajout_membre"){
?>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'ajout_membre.php?<?php echo $historique; ?>';">
<?php
}
elseif ($page=="inscription_membre"){
?>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'inscription_membre.php?<?php echo $historique; ?>';">
<?php
}
?>
</center>
</body>