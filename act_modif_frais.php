<?php
include "restrict/config.php";
$variable = 0;
//&eacute;criture dans la base BOX
if(	isset($_POST["nom"]) && !empty($_POST["nom"]) &&
	isset($_POST["prix"]) && !empty($_POST["prix"])){
//control si le BOX existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$prix = mysql_real_escape_string(htmlspecialchars($_POST['prix']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
if(isset($_POST["obligatoire"])){$obligatoire=1;}else{$obligatoire=0;}
if(isset($_POST["caution"])){$caution=1;}else{$caution=0;}
$id_frais = $_POST["id_frais"];
//inscription de l'activite dans la base
mysql_query("UPDATE frais SET nom='$nom', prix='$prix', obs='$obs', obligatoire='$obligatoire', caution='$caution' WHERE id='$id_frais'");
//fin d'inscription de l'activite dans la base
mysql_close();
//fin travail sur BDD
$variable = 1;
$_POST = "";
}
//donn&eacute;e manquante pour une nouvelle activite
elseif(	isset($_POST["nom"]) &&
		isset($_POST["prix"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le frais")</script>
<?php
}
if ($variable == 1){
?>
<center>
frais modifi&eacute; avec succes<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_frais.php';">
</center>
<?php
}
elseif((isset($_REQUEST["id_frais"]) && !empty($_REQUEST["id_frais"]))){
$id_frais = $_REQUEST["id_frais"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$frais = mysql_query("SELECT * FROM frais WHERE id='$id_frais'");
$frais = mysql_fetch_array($frais);
mysql_close();
//fin donn&eacute;e manquante pour un frais
//fin &eacute;criture dans la base frais
?>
<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier le frais : <?php echo $frais["nom"]; ?>&nbsp;</legend>
	<form method="post" action="act_modif_frais.php">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="20" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } else {echo $frais["nom"];} ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Prix : </b></font><input type="text" name="prix" size="5" value="<?php if(isset($_POST["frais"])){ echo $_POST["frais"]; }else {echo ($frais["prix"]*1);} ?>">
	</td>
	</tr>
	<tr height=5>
	</tr>
	<tr>
	<td align=center colspan=3>
	<font>Classement : </font><input type="text" name="classement" size="2" value="<?php if(isset($_POST["classement"])){ echo $_POST["classement"]; } else { echo $frais["classement"]; } ?>">
	&nbsp;
	<label for="1">frais Obligatoire</label><input type="checkbox" name="obligatoire" id="1" <?php if ($frais["obligatoire"]==1){ echo "checked"; } ?>>
	&nbsp;
	<label for="2">Caution</label><input type="checkbox" name="caution" id="2" <?php if ($frais["caution"]==1){ echo "checked"; } ?>>
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $frais["obs"];} ?></textarea><br><br>
		<input type="hidden" name="id_frais" value="<?php echo $id_frais; ?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_frais.php';">
</center>
<?php } ?>
</body>
</html>