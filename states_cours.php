<?php include "restrict/config.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$ok=0;
if((isset($_REQUEST["id_cours"]) && !empty($_REQUEST["id_cours"]))){
$id_cours = $_REQUEST["id_cours"];
$ok++;
}
if((isset($_REQUEST["annee_1"]) && !empty($_REQUEST["annee_1"]))){
$annee_1 = $_REQUEST["annee_1"];
$ok++;
}
if((isset($_REQUEST["annee_2"]) && !empty($_REQUEST["annee_2"]))){
$annee_2 = $_REQUEST["annee_2"];
$ok++;
}
if($ok==3){
$saison = $annee_1."/".$annee_2;
$cours = mysql_query("SELECT * FROM cours WHERE id = '$id_cours'");
$cours = mysql_fetch_array($cours);
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
?>
<fieldset align="center" style="height=max; width=max">
<legend><font color=red><b><?php echo $cours['nom']; ?></b></font> pour la saison <font color=blue><b><?php echo $saison; ?></b></font></legend>
<center>
<table class="table4" summary="">
<th>Nom</th>
<th>Pr&eacute;nom</th>
<?php
$variable=0;
$mail = "";
$inscription_cours = mysql_query("SELECT * FROM inscriptions_cours WHERE id_cours = '$id_cours' AND actif='1'");
while($boucle_inscription_cours = mysql_fetch_array($inscription_cours)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}

$id_inscription = $boucle_inscription_cours['id_inscriptions'];
$inscription = mysql_query("SELECT * FROM inscriptions WHERE saison = '$saison' AND id = '$id_inscription' AND actif = '1'");
$inscription = mysql_fetch_array($inscription);
$id_membre = $inscription['id_membre'];
$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
$membre = mysql_fetch_array($membre);
if(isset($membre['id'])){
$variable++;
$mail .= $membre['mail']."; ";
echo "<tr style=background:".$couleur."><td align=center>".$membre['nom']."</td><td align=center>".$membre['prenom']."</td></tr>";
}}
?>
</table>
<br>
</center>
</fieldset>
<form name="impression" method="post" action="states_cours_impression.php">
<fieldset align="center" style="height=max; width=max">
<?php
echo '<input type="hidden" name="id_cours" value="'.$id_cours.'">';
echo '<input type="hidden" name="annee_1" value="'.$annee_1.'">';
echo '<input type="hidden" name="annee_2" value="'.$annee_2.'">';
function Liste($position=0){
	if($position == 1){
		$value .= "<option value='nom' selected>Nom</option>";
		$value .= "<option value='prenom'>Prenom</option>";
	}
	if($position == 2){
		$value .= "<option value=''></option>";
		$value .= "<option value='nom'>Nom</option>";
		$value .= "<option value='prenom' selected>Prenom</option>";
	}
	if($position == 0){
		$value .= "<option value=''></option>";
		$value .= "<option value='nom'>Nom</option>";
		$value .= "<option value='prenom'>Prenom</option>";
	}
		$value .= "<option value='aaaa/mm/jj'>Date de naissance</option>";
		$value .= "<option value='id'>ID</option>";
		$value .= "<option value='poids'>Poids</option>";
		$value .= "<option value='mail'>Email</option>";
		$value .= "<option value='adresse'>Adresse Postale</option>";
		$value .= "<option value='tel'>Téléphone(s)</option>";
		$value .= "<option value='urgence'>Urgence</option>";
		$value .= "<option value='profession1'>Profession N°1</option>";
		$value .= "<option value='profession2'>Profession N°2</option>";
	
	return $value;
}
?>

<legend><input type="submit" value="Imprimer"></legend>
Colonne 1 :
	<select size='1' name='colonne_1'>
		<?php echo Liste(1) ?>
	</select>
<input type="radio" name="classement" value="1" id="1" checked>
<br>
Colonne 2 :
	<select size='1' name='colonne_2'>
		<?php echo Liste(2) ?>
	</select>
<input type="radio" name="classement" value="2" id="2">
<br>
Colonne 3 :
	<select size='1' name='colonne_3'>
		<?php echo Liste() ?>
	</select>
<input type="radio" name="classement" value="3" id="3">
<br>
Colonne 4 :
	<select size='1' name='colonne_4'>
		<?php echo Liste() ?>
	</select>
<input type="radio" name="classement" value="4" id="4"> 
<br>
Colonne 5 :
	<select size='1' name='colonne_5'>
		<?php echo Liste() ?>
	</select>
<input type="radio" name="classement" value="5" id="5"> 
<br>
Colonne 6 :
	<select size='1' name='colonne_6'>
<?php echo Liste() ?>
	</select>
<input type="radio" name="classement" value="6" id="6"> 
</fieldset>
</form>
<center>
<textarea name="mail" cols="50" rows="10" readonly><?php echo $mail; ?></textarea>
</center>
<?php
}else{ echo "<br><center>Il y a eu une erreur, le résultat ne peut pas etre affiché</center>"; }

?>