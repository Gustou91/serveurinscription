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
$id_tarif = $_POST["id_tarif"];
$id_activite = $_POST["id_activite"];
//inscription de l'activite dans la base
mysql_query("UPDATE tarifs_activites SET nom='$nom', prix='$prix', obs='$obs', obligatoire='$obligatoire' WHERE id='$id_tarif'");
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
<script>alert ("Il manque au moins une donnée\nconcernant l'activité")</script>
<?php
}
if ($variable == 1){
?>
<center>
Tarif modifi&eacute; avec succes<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_tarifs_activite.php?id_activite=<?php echo $id_activite; ?>';">
</center>
<?php
}
elseif((isset($_REQUEST["id_tarif"]) && !empty($_REQUEST["id_tarif"]))){
$id_tarif = $_REQUEST["id_tarif"];
$id_activite = $_REQUEST["id_activite"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$tarif = mysql_query("SELECT * FROM tarifs_activites WHERE id='$id_tarif'");
$tarif = mysql_fetch_array($tarif);
mysql_close();
//fin donn&eacute;e manquante pour un tarif
//fin &eacute;criture dans la base tarif
?>
<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier le tarif : <?php echo $tarif["nom"]; ?>&nbsp;</legend>
	<form method="post" action="act_modif_tarifs.php?id_activite=<?php echo $id_activite; ?>">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="15" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } else {echo $tarif["nom"];} ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Prix : </b></font><input type="text" name="prix" size="5" value="<?php if(isset($_POST["tarif"])){ echo $_POST["tarif"]; }else {echo ($tarif["prix"]*1);} ?>">
	</td>
	</tr>
	<tr>
	<td colspan="3" align=center>
	<label for="obligatoire">Tarif Obligatoire</label><input type="checkbox" name="obligatoire" id="1" <?php if ($tarif["obligatoire"]==1){ echo "checked"; } ?>>
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $tarif["obs"];} ?></textarea><br><br>
		<input type="hidden" name="id_tarif" value="<?php echo $id_tarif; ?>">
		<input type="hidden" name="id_activite" value="<?php echo $id_activite; ?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'act_tarifs_activite.php?id_activite=<?php echo $id_activite; ?>';">
</center>
<?php } ?>
</body>
</html>