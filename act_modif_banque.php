<?php
include "restrict/config.php";
$variable = 0;
//ecriture dans la base banque
if(	isset($_POST["banque"]) && !empty($_POST["banque"])){
//control si le banque existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$banque = mysql_real_escape_string(htmlspecialchars($_POST['banque']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$id_banque = $_POST["id_banque"];
//inscription de l'banque dans la base
mysql_query("UPDATE banques SET banque='$banque', obs='$obs' WHERE id='$id_banque'");
//fin d'inscription de l'banque dans la base
mysql_close();
//fin travail sur BDD
$variable = 1;
$_POST = "";
}
//donnee manquante pour une banque
elseif(	isset($_POST["banque"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant la banque")</script>
<?php
}
if ($variable == 1){
?>
<center>
Banque modifi&eacute; avec succes<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_banques.php';">
</center>
<?php
}
elseif((isset($_REQUEST["id_banque"]) && !empty($_REQUEST["id_banque"]))){
$id_banque = $_REQUEST["id_banque"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$banque = mysql_query("SELECT * FROM banques WHERE id='$id_banque'");
$banque = mysql_fetch_array($banque);
mysql_close();
//fin donn&eacute;e manquante pour un banque
//fin &eacute;criture dans la base banque
?>
<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier la Banque : <?php echo $banque["banque"]; ?>&nbsp;</legend>
	<form method="post" action="act_modif_banque.php">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>banque : </b></font><input type="text" name="banque" size="25" value="<?php if(isset($_POST["banque"])){ echo $_POST["banque"]; } else {echo $banque["banque"];} ?>">
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $banque["obs"];} ?></textarea><br><br>
		<input type="hidden" name="id_banque" value="<?php echo $id_banque; ?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_banques.php';">
</center>
<?php } ?>
</body>
</html>