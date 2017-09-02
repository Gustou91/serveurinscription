<?php include "restrict/config.php";
?>
<html>
<head>
<title>USM</title>
</head>
<script type="text/javascript">
		function OpenBooking_ajout_cp(historique) {
			window.open("ajout_cp.php?page=ajout_ville&historique=" + historique, "ajout_cp", "width=415, height=320, left=" + (screen.width-415)/2 + ", top=" + (screen.height-420)/2);
		}
</script>
<body style="text-align:center" onload="document.forms.formulaire.ville.focus()">
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
mysql_query("SET NAMES ANSI");
//ecriture dans la base ville
if(	isset($_POST["ville"]) && !empty($_POST["ville"]) &&
	isset($_POST["id_cp"]) && !empty($_POST["id_cp"])){
//control si ville existe
$ville = mysql_real_escape_string(htmlspecialchars($_POST['ville']));
$id_cp = mysql_real_escape_string(htmlspecialchars($_POST['id_cp']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
//travail sur BDD
$ctrl_ville = mysql_query("SELECT * FROM villes WHERE ville = '$ville'");
$ctrl_ville = mysql_fetch_array($ctrl_ville);
//fin travail sur BDD
if ($ctrl_ville != NULL){
?>
<script>alert ("Cette ville existe déjà,\nveuillez changer de ville.")</script>
<?php
$_POST = "";
}
//fin control si ville existe
else {
//inscription de la ville dans la base
mysql_query("INSERT INTO villes VALUES(NULL, NOW( ), '$id_cp', '$ville', '$obs', '1')")or die(mysql_error());
//fin d'inscription du frais dans la base

//fin travail sur BDD
$_POST = "";
?>
<script>alert ("Enregistrement réussi")</script>
<?php
}}
//donnee manquante pour une nouvelle ville
else{
if(	isset($_POST["ville"]) &&
	isset($_POST["cp"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant la nouvelle ville")</script>
<?php
}}
$page = $_REQUEST["page"];
//fin donnee manquante
//fin ecriture dans la base client
?>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter une nouvelle ville et son CP</legend>
	<form method="post" action="ajout_ville.php?page=<?php echo $page; ?>" name="formulaire">
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>ville : </b></font><input type="text" name="ville" size="25" value="<?php if(isset($_POST["ville"])){ echo $_POST["ville"]; } ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>CP : </b></font>
		<select size='1' name='id_cp' title="Choix du CP">
		<option value=0>- CP -</option>
		<?php
			$cp = mysql_query("SELECT * FROM cp WHERE actif = '1' ORDER BY cp;");
			while($boucle = mysql_fetch_array($cp)){
			echo "<option value=".$boucle['id'].">".$boucle['cp']."</option>";
			}
		?>
		</select>
		<button onClick="OpenBooking_ajout_cp('<?php echo $_GET['page']; ?>')">+</button>
		</td>
	</tr>
	</table>
	<br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
</fieldset>
<br>

<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = '<?php if ($_GET['page'] == "ajout_membre"){echo "ajout_membre.php"; } elseif ($_GET['page'] == "inscription_membre") {echo "inscription_membre.php"; } else {echo "admin/adm_villes.php"; } if (isset($_GET['historique'])){echo "?page=".$_GET['historique']; } ?>';">
</center>
</body>
<?php mysql_close(); ?>