<?php
include "restrict/config.php";
$variable = 0;
//&eacute;criture dans la base BOX
if(	isset($_POST["nom"]) && !empty($_POST["nom"])){
//control si le BOX existe
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
$obs = mysql_real_escape_string(htmlspecialchars($_POST['obs']));
$activite_id = $_POST["activite_id"];
//inscription de l'activite dans la base
mysql_query("UPDATE activites SET nom='$nom', obs='$obs' WHERE id='$activite_id'");
//fin d'inscription de l'activite dans la base
mysql_close();
//fin travail sur BDD
$variable = 1;
$_POST = "";
}
//donn&eacute;e manquante pour une nouvelle activite
elseif(	isset($_POST["nom"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant l'activité")</script>
<?php
}
if ($variable == 1){
?>
<center>Activit&eacute; modifi&eacute; avec succes</center>
<?php
}
elseif((isset($_REQUEST["id_activite"]) && !empty($_REQUEST["id_activite"]))){
$id = $_REQUEST["id_activite"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$activite = mysql_query("SELECT * FROM activites WHERE id='$id'");
$activite = mysql_fetch_array($activite);
mysql_close();
//fin donn&eacute;e manquante pour une activite
//fin &eacute;criture dans la base activites
?>
<body>
<form method="post" action="act_modif_activite.php">
<center>
<fieldset align="center" style="height=max; width=max">
       <legend>Modifier l'activit&eacute; : <?php echo $activite['nom'];?>&nbsp;</legend><br>
		<font color=red>Nom : </font><input type="text" name="nom" size="10" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } else {echo $activite['nom'];}?>"><br>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else {echo $activite['obs'];} ?></textarea><br><br>
		<input type="hidden" name="activite_id" value="<?php echo $id;?>">
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
</fieldset>
</center>
</form>
<?php
}
else{ echo "<center>Il y a eu une erreur, aucune modification n'a &eacute;t&eacute; faite</center>";}
?>
<center><br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_activites.php';">
</center>
</body>
</html>