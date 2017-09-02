<?php
include "restrict/config.php";
?>
<html>
<head>
<title>USM</title>
</head>
<?php
$variable = 0;
//&eacute;criture dans la base BOX
if(	isset($_POST["ville"]) && !empty($_POST["ville"]) &&
	isset($_POST["id_cp"]) && !empty($_POST["id_cp"])){
//control si le BOX existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("SET NAMES ANSI");
$ville = mysql_real_escape_string(htmlspecialchars($_POST['ville']));
$id_cp = mysql_real_escape_string(htmlspecialchars($_POST['id_cp']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$id_ville = $_POST["id_ville"];
//inscription de l'activite dans la base
mysql_query("UPDATE villes SET ville='$ville', id_cp='$id_cp', obs='$obs' WHERE id='$id_ville'")or die(mysql_error());
//fin d'inscription de l'activite dans la base
mysql_close();
//fin travail sur BDD
$variable = 1;
$_POST = "";
}
//donn&eacute;e manquante pour une nouvelle activite
elseif(	isset($_POST["ville"]) &&
		isset($_POST["id_cp"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant la ville")</script>
<?php
}
if ($variable == 1){
?>
<center>
ville modifi&eacute; avec succes<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_villes.php';">
</center>
<?php
}
elseif((isset($_REQUEST["id_ville"]) && !empty($_REQUEST["id_ville"]))){
$id_ville = $_REQUEST["id_ville"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$ville = mysql_query("SELECT * FROM villes WHERE id='$id_ville'");
$ville = mysql_fetch_array($ville);
$id_cp=$ville['id_cp'];
$cp = mysql_query("SELECT * FROM cp WHERE id='$id_cp'");
$cp = mysql_fetch_array($cp);
//fin donn&eacute;e manquante pour un frais
//fin &eacute;criture dans la base frais
?>

<body>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier la ville : <?php echo $ville["ville"]; ?>&nbsp;</legend>
	<form method="post" action="act_modif_ville.php" name="formulaire">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>ville : </b></font><input type="text" name="ville" size="25" value="<?php if(isset($_POST["ville"])){ echo $_POST["ville"]; } else {echo $ville["ville"];} ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>CP : </b></font>
		<select size='1' name='id_cp' title="Choix du CP">
		<option value=<?php echo $cp['id']?>><?php echo $cp['cp']?></option>
		<?php
			$liste_cp = mysql_query("SELECT * FROM cp WHERE actif = '1' ORDER BY cp;");
			while($boucle = mysql_fetch_array($liste_cp)){
			if($boucle['id']!=$cp['id']){
			echo "<option value=".$boucle['id'].">".$boucle['cp']."</option>";
			}}
		?>
		</select>
	</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $ville["obs"];} ?></textarea><br><br>
		<input type="hidden" name="id_ville" value="<?php echo $id_ville; ?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
	</fieldset>
<br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_villes.php';">
<script type="text/javascript">
		function OpenBooking_ajout_cp(id_ville) {
			window.open("ajout_cp.php?page=act_modif_ville&historique=" + id_ville, "ajout_cp", "width=415, height=320, left=" + (screen.width-415)/2 + ", top=" + (screen.height-420)/2);
		}
</script>
<button onClick="OpenBooking_ajout_cp(<?php echo $id_ville; ?>)">Ajouter CP</button>
</center>
<?php
}
else{echo "<center><br>Il y a eu une erreur</center>";}
mysql_close();
?>
</body>
</html>