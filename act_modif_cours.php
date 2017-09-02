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
$classement = mysql_real_escape_string(htmlspecialchars($_POST['classement']));
if(isset($_POST["obligatoire"])){$obligatoire=1;}else{$obligatoire=0;}
$id_cours = $_POST["id_cours"];
//inscription de l'activite dans la base
mysql_query("UPDATE cours SET nom='$nom', prix='$prix', obs='$obs', obligatoire='$obligatoire', classement='$classement' WHERE id='$id_cours'");
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
<script>alert ("Il manque au moins une donnée\nconcernant le cours")</script>
<?php
}
if ($variable == 1){
?>
<center>
cours modifi&eacute; avec succes<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_cours.php';">
</center>
<?php
}
elseif((isset($_REQUEST["id_cours"]) && !empty($_REQUEST["id_cours"]))){
$id_cours = $_REQUEST["id_cours"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$cours = mysql_query("SELECT * FROM cours WHERE id='$id_cours'");
$cours = mysql_fetch_array($cours);
mysql_close();
//fin donn&eacute;e manquante pour un cours
//fin &eacute;criture dans la base cours
?>
<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier le cours : <?php echo $cours["nom"]; ?>&nbsp;</legend>
	<form method="post" action="act_modif_cours.php">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="20" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } else {echo $cours["nom"];} ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Prix : </b></font><input type="text" name="prix" size="5" value="<?php if(isset($_POST["cours"])){ echo $_POST["cours"]; }else {echo ($cours["prix"]*1);} ?>">
	</td>
	</tr>
	<tr>
	<td height=5>
	</td>
	</tr>
	<tr>
	<td>
	<font>Classement : </font><input type="text" name="classement" size="2" value="<?php if(isset($_POST["classement"])){ echo $_POST["classement"]; } else { echo $cours["classement"]; } ?>">
	</td>
	<td>
	</td>
	<td align=left>
	<label for="obligatoire">cours Obligatoire</label><input type="checkbox" name="obligatoire" id="1" <?php if ($cours["obligatoire"]==1){ echo "checked"; } ?>>
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $cours["obs"];} ?></textarea><br><br>
		<input type="hidden" name="id_cours" value="<?php echo $id_cours; ?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_cours.php';">
</center>
<?php } ?>
</body>
</html>