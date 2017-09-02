<?php include "restrict/config.php";
?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center" onload="document.forms.formulaire.banque.focus()">
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
//&eacute;criture dans la base frais
if(	isset($_POST["banque"]) && !empty($_POST["banque"])){
//control si frais existe
$banque = mysql_real_escape_string(htmlspecialchars($_POST['banque']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
//travail sur BDD
$ctrl_banque = mysql_query("SELECT * FROM banques WHERE banque = '$banque'");
$ctrl_banque = mysql_fetch_array($ctrl_banque);
//fin travail sur BDD
if ($ctrl_banque != NULL){
?>
<script>alert ("Cette banque existe déjà,\nveuillez en changer.")</script>
<?php
$_POST = "";
}
//fin control si frais existe
else {
//inscription du frais dans la base
mysql_query("INSERT INTO banques VALUES(NULL, NOW( ), '$banque', '$obs', '1')")or die(mysql_error());
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
if(isset($_POST["banque"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau Code Postal")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<body>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter une nouvelle Banque&nbsp;</legend>
	<form method="post" action="ajout_banque.php?page=<?php echo $page; ?>" name="formulaire">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>banque : </b></font><input type="text" name="banque" size="25" value="<?php if(isset($_POST["banque"])){ echo $_POST["banque"]; } ?>">
	</td></tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_banques.php';">
</center>
</body>