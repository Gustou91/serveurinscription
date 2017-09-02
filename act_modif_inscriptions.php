<?php include "restrict/config.php";?>

<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center">
<script type="text/javascript">
function Autotab(id, texte, longueur)
{
    if (texte.length > longueur) {
        document.getElementById('id_'+id).focus();
    }
}
</script>
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
if((isset($_REQUEST["id_inscription"]) && !empty($_REQUEST["id_inscription"]))){
$id_inscription = $_REQUEST["id_inscription"];
}
$inscription = mysql_query("SELECT * FROM inscriptions WHERE id = '$id_inscription'");
$inscription = mysql_fetch_array($inscription);
$de_aaaa = substr($inscription['saison'],0,4);
$a_aaaa = substr($inscription['saison'],5,4);
$id_membre = $inscription['id_membre'];
$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
$membre = mysql_fetch_array($membre);
echo "FEUILLE D'INSCRIPTION DE<br>";
echo $membre['nom']." ".$membre['prenom']." (".(($annee_actu)-($membre['aaaa']))." ans)";
echo "<br><b><font color=red>Saison <input type=\"text\" name=\"de_aaaa\" size=\"2\" maxlength=\"4\" value=\"".$de_aaaa."\"> / <input type=\"text\" name=\"a_aaaa\" size=\"2\" maxlength=\"4\" value=\"".$a_aaaa."\"></font></b><br><br>";
$nb_activite=1;
$nb_cours=1;
$nb_frais=1;
$nb_grade=1;
?>

<form method="post" name="formulaire">
<table border=0>
<tr>
<td>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Activit&eacute;s &nbsp;</b></font></legend>
<?php
$activites = mysql_query("SELECT * FROM activites WHERE actif = '1' ORDER BY nom");
?>
<table class="table4" summary="">
<?php
$Nb_POST_grade = 0;
while($boucle_activite = mysql_fetch_array($activites)){
$id_activite = $boucle_activite['id'];
$tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id_activites = '$id_activite' AND actif = '1' ORDER BY nom");
$grades = mysql_query("SELECT * FROM grades WHERE id_activites = '$id_activite' AND actif = '1' ORDER BY classement");
$Nb_POST_grade++;
?>
<tr title="<?php echo "Observations : ".$boucle_activite['obs']; ?>">
<th colspan=3>
<font color=red><?php echo $boucle_activite['nom']; ?></font>
&nbsp;<select size='1' name='grade_<?php echo $Nb_POST_grade; ?>'>
<?php 
$inscription_grade = mysql_query("SELECT * FROM inscriptions_grades WHERE id_inscriptions = '$id_inscription' AND actif = '1'");
while($boucle_inscription_grade = mysql_fetch_array($inscription_grade)){
$id_grade = $boucle_inscription_grade['id_grades'];
$grade = mysql_query("SELECT * FROM grades WHERE id = '$id_grade'");
$grade = mysql_fetch_array($grade);
if(($grade['id_activites']) ==($boucle_activite['id'])){
echo "<option value=".$grade['id'].">".$grade['nom']."</option>";
}}
?>
<option value=0>-- grades --</option>
<?php
while($boucle_grade = mysql_fetch_array($grades)){
echo "<option value=".$boucle_grade['id'].">".$boucle_grade['nom']."</option>";
}
?>
</select>
</th>
</tr>
<?php
$nb_grade++;
while($boucle_tarif_activite = mysql_fetch_array($tarifs_activites)){
?>
<?php
$inscriptions_tarifs_activites = mysql_query("SELECT * FROM inscriptions_tarifs_activites WHERE id_inscriptions = '$id_inscription' AND actif = '1' ORDER BY id_tarifs_activites");
$checked = false;
while($boucle_tarif_activites = mysql_fetch_array($inscriptions_tarifs_activites)){
$id_tarifs_activites = $boucle_tarif_activites['id_tarifs_activites'];
$cherche_tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id = '$id_tarifs_activites'");
$cherche_tarifs_activites = mysql_fetch_array($cherche_tarifs_activites);
if($cherche_tarifs_activites['id'] == $boucle_tarif_activite['id']){$checked = true;}
}
?>
<tr title="<?php echo "Observations : ".$boucle_tarif_activite['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="activite_<?php echo $nb_activite; ?>" value="<?php echo $boucle_tarif_activite['id']; ?>" <?php if ($checked == true){echo "checked"; }?>>
</td>
<td align=center>
<?php echo ($boucle_tarif_activite['prix']*1); 
echo " € ";
?>
</td>
<td>
<?php echo $boucle_tarif_activite['nom']; ?>
</td>
</tr>
<?php
$nb_activite++;
}}
?>
</table>
</fieldset>
</td>
<td width=15>
</td>
<td>
<fieldset align="center" style="height=max; width=max">
<?php 
$parametres = mysql_query("SELECT * FROM generale WHERE nom='reduction'");
$parametres = mysql_fetch_array($parametres);
$valeur = ($parametres['valeur']-1)*100;
?>
<legend><font color=blue><b>Cours </b></font><input type="checkbox" name="reduc" <?php if($inscription['reduc'] != 1){echo "checked";} ?>><?php if($inscription['reduc'] != 1){echo "<input type=\"text\" name=\"p1_num\" size=\"1\" value=\"".$inscription['reduc']."\">";}else{echo $valeur." %";} ?>&nbsp;&nbsp;
Nb de trimestres : 
<select size='1' name='nb_trimestre'>
<?php
if($inscription['trimestre']==3){
?>
<option value=3> - 3 - </option>
<option value=2> - 2 - </option>
<option value=1> - 1 - </option>
<?php } elseif ($inscription['trimestre']==2) { ?>
<option value=2> - 2 - </option>
<option value=1> - 1 - </option>
<option value=3> - 3 - </option>
<?php } else { ?>
<option value=1> - 1 - </option>
<option value=2> - 2 - </option>
<option value=3> - 3 - </option>
<?php } ?>
</select>&nbsp;
</legend>
<center>
Les prix indiqu&eacute;s concernent une ann&eacute;e compl&eacute;te,<br>soit 3 trimestres, et seront divis&eacute;s automatiquement si besoin.<br>
<?php
$cours = mysql_query("SELECT * FROM cours WHERE actif = '1' ORDER BY classement");
?>
<table class="table4" summary="">
<?php
while($boucle_cours = mysql_fetch_array($cours)){
$checked = false;
$inscriptions_cours = mysql_query("SELECT * FROM inscriptions_cours WHERE id_inscriptions = '$id_inscription' AND actif = '1'");
while($boucle_inscriptions_cours = mysql_fetch_array($inscriptions_cours)){
$id_cours = $boucle_inscriptions_cours['id_cours'];
if($id_cours == $boucle_cours['id']){$checked=true; }
}
?>
<tr title="<?php echo "Observations : ".$boucle_cours['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="cours_<?php echo $nb_cours; ?>" value="<?php echo $boucle_cours['id']; ?>" <?php if ($checked == true){echo "checked"; }?>>
</td>
<td align=center>
<?php echo ($boucle_cours['prix']*1); 
echo " € ";
?>
</td>
<td>
<?php echo $boucle_cours['nom']; ?>
</td>
</tr>
<?php
$nb_cours++;
}
?>
</table>
</center>
</fieldset>
</td>
<td width=15>
</td>
<td>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Frais Divers &nbsp;</b></font></legend>
<?php
$frais = mysql_query("SELECT * FROM frais WHERE actif = '1' ORDER BY classement");
?>
<table class="table4" summary="">
<?php
while($boucle_frais = mysql_fetch_array($frais)){
$checked = false;
$inscriptions_frais = mysql_query("SELECT * FROM inscriptions_frais WHERE id_inscriptions = '$id_inscription' AND actif = '1'");
while($boucle_inscriptions_frais = mysql_fetch_array($inscriptions_frais)){
$id_frais = $boucle_inscriptions_frais['id_frais'];
if($id_frais == $boucle_frais['id']){$checked=true; }
}

?>
<tr title="<?php echo "Observations : ".$boucle_frais['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="frais_<?php echo $nb_frais; ?>" value="<?php echo $boucle_frais['id']; ?>" <?php if ($checked == true){echo "checked"; }?>>
</td>
<td align=center>
<?php echo ($boucle_frais['prix']*1); 
echo " € ";
?>
</td>
<td>
<?php echo $boucle_frais['nom']; ?>
</td>
</tr>
<?php
$nb_frais++;
}
?>
</table>
</fieldset>
</td>
</tr>

<tr>
<td height=10 colspan=5>
</td>
</tr>
<tr>
<td height=20 colspan=5>
<center>
<input type="button" onClick="document.formulaire.action='simulations.php';document.formulaire.target='simulation';document.formulaire.submit();" value="simulation">
</center>
</td>
</tr>
<tr>
<td height=5 colspan=5>
</td>
</tr>

<tr>
<td colspan=5>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Autres &nbsp;</b></font></legend>
<center>
<table border=0>
<tr>
<td colspan=3 align=center>
Passeport fait, donn&eacute; et rempli :&nbsp;
<input type="radio" name="passeport" value="OUI" id="1" <?php if($inscription['passeport'] == 1){echo"checked"; } ?>><label for="1">OUI</label>
<input type="radio" name="passeport" value="NON" id="2" <?php if($inscription['passeport'] == 0){echo"checked"; } ?>><label for="2">NON</label>
</td>
</tr>
<tr>
<td height=10>
</td>
<td>
</td>
</tr>
<tr>
<td colspan=3 align=center>
Photo :&nbsp;
<input type="radio" name="photo" value="OUI" id="3" <?php if($inscription['photo'] == 1){echo"checked"; } ?>><label for="3">OUI</label>
<input type="radio" name="photo" value="NON" id="4" <?php if($inscription['photo'] == 0){echo"checked"; } ?>><label for="4">NON</label>
</td>
</tr>
<tr>
<td height=10>
</td>
<td>
</td>
</tr>
<tr>
<td colspan=3 align=center>
certificat :&nbsp;
<input type="radio" name="certificat" value="OUI" id="7" <?php if($inscription['certificat'] == "OUI"){echo"checked"; } ?>><label for="7">OUI</label>
<input type="radio" name="certificat" value="NON" id="8" <?php if($inscription['certificat'] == "NON"){echo"checked"; } ?>><label for="8">NON</label>
(jj/mm/aaaa) : 
<input type="text" name="certificat_jj" size="1" maxlength="2" <?php if($inscription['certificat'] == "OUI"){echo"value=\"".$inscription['certificat_jj']."\""; } ?> onkeyup="Autotab(2, this.value, this.size)" id="id_1"> 
<input type="text" name="certificat_mm" size="1" maxlength="2" <?php if($inscription['certificat'] == "OUI"){echo"value=\"".$inscription['certificat_mm']."\""; } ?> onkeyup="Autotab(3, this.value, this.size)" id="id_2"> 
<input type="text" name="certificat_aaaa" size="2" maxlength="4" <?php if($inscription['certificat'] == "OUI"){echo"value=\"".$inscription['certificat_aaaa']."\""; } ?> id="id_3">
</td>
</tr>
<tr>
<td height=10>
</td>
<td>
</td>
</tr>
<tr>
<td align="center" colspan=3>
Caution :&nbsp;
<input type="radio" name="caution" value="espece" id="5" <?php if($inscription['caution'] == "espece"){echo"checked"; } ?>><label for="5">Esp&egrave;ces </label>
<input type="radio" name="caution" value="cheque" id="6" <?php if($inscription['caution'] == "cheque"){echo"checked"; } ?>><label for="6">Ch&egrave;que </label>
N° : <input type="text" name="caution_num" size="10" value="<?php if($inscription['caution'] == "cheque"){echo $inscription['caution_num']; } ?>"> Banque :
	<select size='1' name='caution_banque' title="Choix de la Banque">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
			if($boucle['id'] == $inscription['caution_banque'])
			{
			echo "<option value=".$boucle['id']." selected>".$boucle['banque']."</option>";
			}else
			{
			echo "<option value=".$boucle['id'].">".$boucle['banque']."</option>";
			}}
		?>
</select>
</td>
</tr>
<tr>
<td height=30>
</td>
<td></td>
</tr>
<tr>
<td colspan=3 align=center>
Si le paiement total se fait en esp&egrave;ce, ne remplissez pas ce qui suit.
</td>
</tr>
<tr>
<td colspan=3 height=5>
</td>
<tr>
<td align="right">
<?php
$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_1'");
$parametres = mysql_fetch_array($parametres);
?>
Paiements N° <font color=red><b>1 </b></font><?php echo $parametres['valeur']; ?> :</td><td width=5></td><td>N° du cheque : <input type="text" name="p1_num" size="10" value="<?php if($inscription['p1_num'] != 0 ){echo $inscription['p1_num']; } ?>"> Banque :
<select size='1' name='p1_banque' title="Choix de la Banque">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
			if($boucle['id'] == $inscription['p1_banque'])
			{
			echo "<option value=".$boucle['id']." selected>".$boucle['banque']."</option>";
			}else
			{
			echo "<option value=".$boucle['id'].">".$boucle['banque']."</option>";
			}}
		?>
</select>
<?php
if(!(is_numeric($inscription['p1_banque']))){echo ($inscription['p1_banque']);}
?>
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
<?php
$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_2'");
$parametres = mysql_fetch_array($parametres);
?>
Paiements N° <font color=blue><b>2 </b></font><?php echo $parametres['valeur']; ?> :</td><td></td><td>N° du cheque : <input type="text" name="p2_num" size="10" value="<?php if($inscription['p2_num'] != 0 ){echo $inscription['p2_num']; } ?>"> Banque :
<select size='1' name='p2_banque' title="Choix de la Banque">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
			if($boucle['id'] == $inscription['p2_banque'])
			{
			echo "<option value=".$boucle['id']." selected>".$boucle['banque']."</option>";
			}else
			{
			echo "<option value=".$boucle['id'].">".$boucle['banque']."</option>";
			}}
		?>
</select>
<?php
if(!(is_numeric($inscription['p2_banque']))){echo ($inscription['p2_banque']);}
?>
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
<?php
$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_3'");
$parametres = mysql_fetch_array($parametres);
?>
Paiements N° <font color=green><b>3 </b></font><?php echo $parametres['valeur']; ?> :</td><td></td><td>N° du cheque : <input type="text" name="p3_num" size="10" value="<?php if($inscription['p3_num'] != 0 ){echo $inscription['p3_num']; } ?>"> Banque :
<select size='1' name='p3_banque' title="Choix de la Banque">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
			if($boucle['id'] == $inscription['p3_banque'])
			{
			echo "<option value=".$boucle['id']." selected>".$boucle['banque']."</option>";
			}else
			{
			echo "<option value=".$boucle['id'].">".$boucle['banque']."</option>";
			}}
		?>
</select>
<?php
if(!(is_numeric($inscription['p3_banque']))){echo ($inscription['p3_banque']);}
?>
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
<?php
$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_4'");
$parametres = mysql_fetch_array($parametres);
?>
Paiements N° <font color=DeepPink><b>4 </b></font><?php echo $parametres['valeur']; ?> :</td><td></td><td>N° du cheque : <input type="text" name="p4_num" size="10" value="<?php if($inscription['p4_num'] != 0 ){echo $inscription['p4_num']; } ?>"> Banque :
<select size='1' name='p4_banque' title="Choix de la Banque">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
			if($boucle['id'] == $inscription['p4_banque'])
			{
			echo "<option value=".$boucle['id']." selected>".$boucle['banque']."</option>";
			}else
			{
			echo "<option value=".$boucle['id'].">".$boucle['banque']."</option>";
			}}
		?>
</select>
<?php
if(!(is_numeric($inscription['p4_banque']))){echo ($inscription['p4_banque']);}
?>
</td>
</tr>
<tr>
<td height=10 colspan=3>
</td>
</tr>
<tr>
<td align=center colspan=3>
Observations : <br><textarea name="obs" cols="33" rows="5"><?php echo nl2br(stripslashes($inscription['obs'])); ?></textarea>
</td>
</tr>
<?php
$parametres = mysql_query("SELECT * FROM generale WHERE nom='reduction_manuelle'");
$parametres = mysql_fetch_array($parametres);
if ($parametres['valeur'] == "OUI"){
?>
<tr>
<td height=10 colspan=3>
</td>
</tr>
<tr>
<td align=center colspan=3>
Modification du prix possible (+/- x €): <input type="text" name="reduc_manu" size="2" value="<?php echo $inscription['reduc_manu']; ?>" title="Info: Un nombre d&eacute;cimal doit s'&eacute;crire avec un point."> €
</td>
</tr>
<?php } ?>
</table>
</center>
</fieldset>
</td>
</tr>
</table>
<br>
<input type="submit" onClick="document.formulaire.action='act_modif_inscription_recapitulatif.php?id_inscription=<?php echo $id_inscription; ?>'; document.formulaire.target='sup_inscription'; document.formulaire.submit();" value="Suivant">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
<input type="hidden" name="nb_activite" value="<?php echo $nb_activite-1;?>">
<input type="hidden" name="nb_cours" value="<?php echo $nb_cours-1;?>">
<input type="hidden" name="nb_frais" value="<?php echo $nb_frais-1;?>">
<input type="hidden" name="nb_grade" value="<?php echo $nb_grade-1;?>">
</form>
<?php
if ($_GET['page'] =="consulter_inscriptions"){
?>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'consulter_inscriptions.php?saison=<?php echo $de_aaaa."/".$a_aaaa; ?>';">
<?php
}
?>
</center>
</body>
</html>