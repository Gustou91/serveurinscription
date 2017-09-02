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
$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;
if((isset($_REQUEST["id_membre"]) && !empty($_REQUEST["id_membre"]))){
$id_membre = $_REQUEST["id_membre"];
}
$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
$membre = mysql_fetch_array($membre);
echo "FEUILLE D'INSCRIPTION DE<br>";
echo $membre['nom']." ".$membre['prenom']." (".(($annee_actu)-($membre['aaaa']))." ans)";
echo "<br><b><font color=red>Saison ".$annee_actu." - ".$annee_suivante."</font></b><br>Etape 2 / 4<br><br>";
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
while($boucle_activite = mysql_fetch_array($activites)){
$id_activite = $boucle_activite['id'];
$tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id_activites = '$id_activite' AND actif = '1' ORDER BY nom");
$grades = mysql_query("SELECT * FROM grades WHERE id_activites = '$id_activite' AND actif = '1' ORDER BY classement");
?>
<tr title="<?php echo "Observations : ".$boucle_activite['obs']; ?>">
<th colspan=3>
<font color=red><?php echo $boucle_activite['nom']; ?></font>
&nbsp;<select size='1' name='grade_<?php echo $boucle_activite['id']; ?>'>
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
<tr title="<?php echo "Observations : ".$boucle_tarif_activite['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="activite_<?php echo $nb_activite; ?>" value="<?php echo $boucle_tarif_activite['id']; ?>" <?php if ($boucle_tarif_activite['obligatoire'] == 1){echo "checked"; }?>>
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
<legend><font color=blue><b>Cours </b></font><input type="checkbox" name="reduc"><?php echo $valeur." "; ?>%&nbsp;&nbsp;
Nb de trimestres : 
<select size='1' name='nb_trimestre'>
<option value=3> - 3 - </option>
<option value=2> - 2 - </option>
<option value=1> - 1 - </option>
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
?>
<tr title="<?php echo "Observations : ".$boucle_cours['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="cours_<?php echo $nb_cours; ?>" value="<?php echo $boucle_cours['id']; ?>" <?php if ($boucle_cours['obligatoire'] == 1){echo "checked"; }?>>
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
?>
<tr title="<?php echo "Observations : ".$boucle_frais['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="frais_<?php echo $nb_frais; ?>" value="<?php echo $boucle_frais['id']; ?>" <?php if ($boucle_frais['obligatoire'] == 1){echo "checked"; }?>>
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
<input type="radio" name="passeport" value="OUI" id="1"><label for="1">OUI</label>
<input type="radio" name="passeport" value="NON" id="2"><label for="2">NON</label>
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
<input type="radio" name="photo" value="OUI" id="3"><label for="3">OUI</label>
<input type="radio" name="photo" value="NON" id="4"><label for="4">NON</label>
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
<input type="radio" name="certificat" value="OUI" id="7"><label for="7">OUI</label>
<input type="radio" name="certificat" value="NON" id="8"><label for="8">NON</label>
(jj/mm/aaaa) : 
<input type="text" name="certificat_jj" size="1" maxlength="2" onkeyup="Autotab(2, this.value, this.size)" id="id_1"> 
<input type="text" name="certificat_mm" size="1" maxlength="2" onkeyup="Autotab(3, this.value, this.size)" id="id_2"> 
<input type="text" name="certificat_aaaa" size="2" maxlength="4" value="<?php echo $annee_actu; ?>" id="id_3">
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
<input type="radio" name="caution" value="espece" id="5"><label for="5">Esp&egrave;ces </label>
<input type="radio" name="caution" value="cheque" id="6"><label for="6">Ch&egrave;que </label>
N° : <input type="text" name="caution_num" size="10"> Banque : <input type="text" name="caution_banque" size="10">
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
Paiements N° <font color=red><b>1</b></font> d'Octobre :</td><td width=5></td><td>Cheque N° : <input type="text" name="p1_num" size="10"> Banque : <input type="text" name="p1_banque" size="10">
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
Paiements N° <font color=blue><b>2</b></font> de Janvier :</td><td></td><td>Cheque N° : <input type="text" name="p2_num" size="10"> Banque : <input type="text" name="p2_banque" size="10">
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
Paiements N° <font color=green><b>3</b></font> d'Avril :</td><td></td><td>Cheque N° : <input type="text" name="p3_num" size="10"> Banque : <input type="text" name="p3_banque" size="10">
</td>
</tr>
<tr>
<td height=10 colspan=3>
</td>
</tr>
<tr>
<td align=center colspan=3>
Observations : <br><textarea name="obs" cols="33" rows="5">RAS</textarea>
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
Modification du prix possible (+/- x €): <input type="text" name="reduc_manu" size="2" value="0" title="Info: Un nombre d&eacute;cimal doit s'&eacute;crire avec un point."> €
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
<input type="button" value="Suivant" onClick="document.formulaire.action='inscription_recapitulatif.php?id_membre=<?php echo $id_membre; ?>';document.formulaire.target='site';document.formulaire.submit();">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">&nbsp;&nbsp;&nbsp;<input type="button" value="Pr&eacute;c&eacute;dent" onclick="Javascript:history.back();">
<input type="hidden" name="nb_activite" value="<?php echo $nb_activite-1;?>">
<input type="hidden" name="nb_cours" value="<?php echo $nb_cours-1;?>">
<input type="hidden" name="nb_frais" value="<?php echo $nb_frais-1;?>">
<input type="hidden" name="nb_grade" value="<?php echo $nb_grade-1;?>">
</form>
</center>
</body>
</html>