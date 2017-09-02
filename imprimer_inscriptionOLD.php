<?php 
//onload="window.print()"
include "restrict/config1.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
if((isset($_REQUEST["id_inscription"]) && !empty($_REQUEST["id_inscription"]))){
$id_inscription = $_REQUEST["id_inscription"];
$inscription = mysql_query("SELECT *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee FROM inscriptions WHERE id = '$id_inscription'");
$inscription = mysql_fetch_array($inscription);
$id_membre = $inscription['id_membre'];
$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
$membre = mysql_fetch_array($membre);
$parametres = mysql_query("SELECT * FROM generale WHERE nom='imprimer'");
$parametres = mysql_fetch_array($parametres);
$largeur = mysql_query("SELECT * FROM generale WHERE nom='largeur_impression'");
$largeur = mysql_fetch_array($largeur);
$image = mysql_query("SELECT * FROM generale WHERE nom='image_contrat'");
$image = mysql_fetch_array($image);
$position_entete = mysql_query("SELECT * FROM generale WHERE nom='position_entete'");
$position_entete = mysql_fetch_array($position_entete);

function banques($type_banque)
{
	if(is_numeric($type_banque))
	{
		$nom_banque = mysql_query("SELECT banque FROM banques WHERE id = '$type_banque'");
		$nom_banque = mysql_fetch_array($nom_banque);
		return $nom_banque['banque'];
		
	}else
	{
		return $type_banque;
	}
}
?>
<html>
<head>
<title>USM N° <?php echo $id_inscription." Saison ".$inscription['saison']; ?></title>
</head>
<body <?php if($parametres['valeur'] == "OUI"){echo "onload=\"window.print()\""; }?>>
<center>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr>
<?php
if($position_entete['valeur'] == "gauche"){
	echo "<td align=center  width=33%>";
	echo '<img src="img/'.$image['valeur'].'" height="125">';
}else{
	echo "<td align=left  width=33%>";
	$titre_1 = mysql_query("SELECT * FROM generale WHERE nom = 'titre_1'");
	$titre_1 = mysql_fetch_array($titre_1);
	echo nl2br(stripslashes($titre_1['valeur']));
}
?>
</td><td align=center  width=33%>
<?php
if($position_entete['valeur'] == "milieu"){
	echo '<img src="img/'.$image['valeur'].'" height="125">';
}elseif($position_entete['valeur'] == "gauche"){
	$titre_1 = mysql_query("SELECT * FROM generale WHERE nom = 'titre_1'");
	$titre_1 = mysql_fetch_array($titre_1);
	echo nl2br(stripslashes($titre_1['valeur']));
}else{
	$titre_2 = mysql_query("SELECT * FROM generale WHERE nom = 'titre_2'");
	$titre_2 = mysql_fetch_array($titre_2);
	echo nl2br(stripslashes($titre_2['valeur']));
}
?>
</td>
<?php
if($position_entete['valeur'] == "droite"){
	echo "<td align=center  width=33%>";
	echo '<img src="img/'.$image['valeur'].'" height="125">';
}else{
	echo "<td align=right  width=33%>";
	$titre_2 = mysql_query("SELECT * FROM generale WHERE nom = 'titre_2'");
	$titre_2 = mysql_fetch_array($titre_2);
	echo nl2br(stripslashes($titre_2['valeur']));
}
$ville = $membre['ville'];
if(is_numeric($membre['ville'])){
$ville = mysql_query("SELECT ville FROM villes WHERE id = '$ville'");
$ville = mysql_fetch_array($ville);
$ville = $ville['ville'];}
?>
</td></tr>
</table>
<hr>
<h2><u>FEUILLE D'INSCRIPTION N° <?php echo $id_inscription." Saison ".$inscription['saison']; ?></u></h2>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td>
Nom : <b><?php echo $membre['nom'];?></b>
</td><td>
Pr&eacute;nom : <b><?php echo $membre['prenom'];?></b>
</td><td>
Sexe : <b><?php if(($membre['sexe'])=="F"){echo "F&eacute;minin";}elseif(($membre['sexe'])=="M"){echo "Masculin";}else{echo "Inconnu";}?></b>
</td><td>
Date de naissance : <b><?php if((($membre['jj'])==0) AND (($membre['mm'])==0) AND (($membre['aaaa'])==0)){echo "Inconnu";}else{if($membre['jj']<=9){echo "0";}echo $membre['jj']." / "; if($membre['mm']<=9){echo "0";}echo $membre['mm']." / ".$membre['aaaa'];}?></b>
</td><td>
Poids : <b><?php if(($membre['poids'])==0){echo "Inconnu";}else{echo $membre['poids']." Kg";}?></b>
</td></tr><tr height=2></tr><tr><td colspan=2>
Nom des repr&eacute;sentants l&eacute;gaux : <b><?php echo $membre['representants'];?></b>
</td><td>
T&eacute;l. : <b><?php if($membre['tel_dom']==NULL){echo "Inconnu";}else{echo $membre['tel_dom'];}?></b>
</td><td>
Port. : <b><?php if($membre['tel_port']==NULL){echo "Inconnu";}else{echo $membre['tel_port'];}?></b>
</td></tr>
</table>
<table  border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td>
Profes. du repr. N°1 : <b><?php echo $membre['profession1'];?></b>
</td><td>
Profes. du repr. N°2 : <b><?php echo $membre['profession2'];?></b>
</td></tr><tr height=2></tr><tr><td>
Adresse : <b><?php echo $membre['adresse']." ".$membre['cp']." ".$ville;?></b>
</td><td>
E-m@il : <b><?php echo $membre['mail'];?></b>
</td></tr><tr height=2></tr><tr><td>
Personne &agrave; pr&eacute;venir en Urgence : <b><?php echo $membre['urgence'];?></b>
</td><td>
Port : <b><?php if($membre['tel_urg']==NULL){echo "Inconnu";}else{echo $membre['tel_urg'];}?></b>
</td></tr>
</table>
<?php if(($membre['obs'])!="RAS"){ ?>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td width=95 valign=top>
Observations :
</td><td>
<?php echo nl2br (stripslashes($membre['obs']));?>
</td></tr>
</table>
<hr>
<?php }
?>
<table border=1 CELLPADDING=3>
<tr><td>
<table border=0>
<tr><td>
<table border=0>
<?php
$inscriptions_tarifs_activites = mysql_query("SELECT * FROM inscriptions_tarifs_activites WHERE id_inscriptions = '$id_inscription' AND actif = '1' ORDER BY id_tarifs_activites");
$calcul=0;
while($boucle_tarif_activites = mysql_fetch_array($inscriptions_tarifs_activites)){
$id_tarifs_activites = $boucle_tarif_activites['id_tarifs_activites'];
$tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id = '$id_tarifs_activites'");
$tarifs_activites = mysql_fetch_array($tarifs_activites);
$id_activite = $tarifs_activites['id_activites'];
$activite = mysql_query("SELECT * FROM activites WHERE id = '$id_activite'");
$activite = mysql_fetch_array($activite);
$id_activite = $activite['id'];
if ($id_activite != $calcul){
$calcul = $id_activite;
echo "<tr><td>";
echo "<u><b>".$activite['nom']."</b></u>";
echo "</td></tr>";
}else{
echo "<tr><td>&nbsp;</td></tr>";
}}
?>
</table>
</td><td>
<table border=0>
<?php
$inscriptions_tarifs_activites = mysql_query("SELECT * FROM inscriptions_tarifs_activites WHERE id_inscriptions = '$id_inscription' AND actif = '1' ORDER BY id_tarifs_activites");
$calcul=0;
while($boucle_tarif_activites = mysql_fetch_array($inscriptions_tarifs_activites)){
$id_tarifs_activites = $boucle_tarif_activites['id_tarifs_activites'];
$tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id = '$id_tarifs_activites'");
$tarifs_activites = mysql_fetch_array($tarifs_activites);
$id_activite = $tarifs_activites['id_activites'];
$activite = mysql_query("SELECT * FROM activites WHERE id = '$id_activite'");
$activite = mysql_fetch_array($activite);
$id_activite = $activite['id'];
if ($id_activite != $calcul){
$calcul = $id_activite;
$inscriptions_grades = mysql_query("SELECT * FROM inscriptions_grades WHERE id_inscriptions = '$id_inscription' AND actif = '1'");
while($boucle_grades = mysql_fetch_array($inscriptions_grades)){
$id_grade = $boucle_grades['id_grades'];
$grade = mysql_query("SELECT * FROM grades WHERE id = '$id_grade'");
$grade = mysql_fetch_array($grade);
if(($grade['id_activites']) ==($activite['id'])){
echo "<tr><td>";
echo "( ".$grade['nom']." )";
echo "</td></tr>";
}}}else{
echo "<tr><td>&nbsp;</td></tr>";
}}
?>
</table>
</td><td>
<table border=0>
<?php
$inscriptions_tarifs_activites = mysql_query("SELECT * FROM inscriptions_tarifs_activites WHERE id_inscriptions = '$id_inscription' AND actif = '1' ORDER BY id_tarifs_activites");
while($boucle_tarif_activites = mysql_fetch_array($inscriptions_tarifs_activites)){
$id_tarifs_activites = $boucle_tarif_activites['id_tarifs_activites'];
$tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id = '$id_tarifs_activites'");
$tarifs_activites = mysql_fetch_array($tarifs_activites);
echo "<tr><td>";
echo $tarifs_activites['nom'];
echo "</td><td width=3></td><td>: ";
echo ($boucle_tarif_activites['prix']*1)." €";
echo "</td></tr>";
}
?>
</table>
</td></tr>
</table></td></tr></table><table border=0><tr height=2><td></td></tr></table>
<table border=0>
<tr><td>
<table border=1 CELLPADDING=3>
<tr><td>
<table border=0>
<?php
$inscriptions_cours = mysql_query("SELECT * FROM inscriptions_cours WHERE id_inscriptions = '$id_inscription' AND actif = '1'");
while($boucle_cours = mysql_fetch_array($inscriptions_cours)){
$id_cours = $boucle_cours['id_cours'];
$cours = mysql_query("SELECT * FROM cours WHERE id = '$id_cours'");
$cours = mysql_fetch_array($cours);
echo "<tr><td>";
echo $cours['nom'];
echo "</td><td width=3></td><td>: ";
if($inscription['reduc']==1){
echo (($boucle_cours['prix']/3)*($inscription['trimestre']))." €";
}else{
echo "<s>".(($boucle_cours['prix']/3)*($inscription['trimestre']))." €</s> ".(($inscription['reduc']-1)*100)." % ".(((($boucle_cours['prix'])*($inscription['reduc']))/3)*($inscription['trimestre']))." €";
}}
?>
</table></td></tr></table>
</td><td width=100></td><td>
<table border=1 CELLPADDING=3>
<tr><td>
<table border=0>
<?php
$inscriptions_frais = mysql_query("SELECT * FROM inscriptions_frais WHERE id_inscriptions = '$id_inscription' AND actif = '1'");
while($boucle_frais = mysql_fetch_array($inscriptions_frais)){
$id_frais = $boucle_frais['id_frais'];
$frais = mysql_query("SELECT * FROM frais WHERE id = '$id_frais'");
$frais = mysql_fetch_array($frais);
echo "<tr><td>";
echo $frais['nom'];
echo "</td><td width=3></td><td>: ";
echo ($boucle_frais['prix']*1)." €";
}
?>
</table>
</td></tr></table>
</td></tr>
</table><table border=0><tr height=2><td></td></tr></table>
<table CELLPADDING=6 border=1><tr><td>
<?php echo "<b><u>Total &agrave; payer : ".$inscription['total']." €</u></b>"; ?>
</td></tr></table>
<?php echo "Pour ".$inscription['trimestre']." trimestre(s)."?>
<hr>
<?php
if (($inscription['caution'])=="cheque"){
echo "Un ch&egrave;que de caution de ".($inscription['caution_prix']*1)."€ portant le num&eacute;ro <b>".$inscription['caution_num']."</b> de la banque <b>".(banques($inscription['caution_banque']))."</b> a &eacute;t&eacute; donn&eacute;.<br><br>";
}elseif (($inscription['caution'])=="espece"){
echo ($inscription['caution_prix']*1)."€ en esp&egrave;ce a &eacute;t&eacute; donn&eacute; pour la caution.<br><br>";
}else{
echo "Aucune caution vers&eacute;e.<br><br>";
}
if(($inscription['p4_prix'])!=0){
?>
<table border=0 CELLPADDING=5>
<tr><td align=right>
Paiement N° <b>1</b> de fin <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p1_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p1_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p1_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p1_banque']));?></b>
</td></tr><tr><td align=right>
Paiement N° <b>2</b> de début <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p2_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p2_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p2_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p2_banque']));?></b>
</td></tr>
<tr><td align=right>
Paiement N° <b>3</b> de début <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p3_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p3_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p3_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p3_banque']));?></b>
</td></tr>
<tr><td align=right>
Paiement N° <b>4</b> de début <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p4_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p4_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p4_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p4_banque']));?></b>
</td></tr>
</table>
<?php
}
elseif(($inscription['p3_prix'])!=0){
?>
<table border=0 CELLPADDING=5>
<tr><td align=right>
Paiement N° <b>1</b> de fin <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p1_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p1_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p1_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p1_banque']));?></b>
</td></tr><tr><td align=right>
Paiement N° <b>2</b> de début <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p2_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p2_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p2_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p2_banque']));?></b>
</td></tr>
<tr><td align=right>
Paiement N° <b>3</b> de début <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p3_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p3_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p3_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p3_banque']));?></b>
</td></tr>
</table>
<?php
}elseif(($inscription['p2_prix'])!=0){
?>
<table border=0 CELLPADDING=5>
<tr><td align=right>
Paiement N° <b>1</b> de fin <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p1_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p1_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p1_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p1_banque']));?></b>
</td></tr><tr><td align=right>
Paiement N° <b>2</b> de début <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p2_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p2_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p2_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p2_banque']));?></b>
</td></tr>
</table>
<?php
}elseif(($inscription['p1_prix'])!=0){
?>
<table border=0 CELLPADDING=5>
<tr><td align=right>
Paiement N° <b>1</b> de fin <?php echo (ucfirst(strftime("%B", mktime(0, 0, 0, ($inscription['p1_date']), 1, 2000))));?> :
</td><td align=left>
Montant : <b><?php echo ($inscription['p1_prix']*1);?></b> €. Cheque N° <b><?php echo ($inscription['p1_num']);?></b> de la Banque : <b><?php echo (banques($inscription['p1_banque']));?></b>
</td></tr>
</table>
<?php
}else{
echo "Le r&eacute;glement de l'inscription s'est fait en esp&egrave;ce.<br><br>";
}
?>
<hr>
</center>
<?php
if($inscription['certificat']=="OUI"){
?>
Certificat m&eacute;dical d&eacute;livr&eacute; le : <?php if($inscription['certificat_jj']<=9){echo"0";} echo $inscription['certificat_jj']." / "; if($inscription['certificat_mm']<=9){echo"0";} echo $inscription['certificat_mm']." / ".$inscription['certificat_aaaa']."."?>
<?php
}else{
?>
Aucun certificat n'a &eacute;t&eacute; donn&eacute;.
<?php
}
if($inscription['passeport']=="1"){
?>
 Passeport fait et rempli.
<?php
}else{
?>
 Aucun passeport n'a &eacute;t&eacute; donn&eacute;.
<?php
}
if($inscription['photo']=="1"){
?>
 La photo est donn&eacute;e.
<?php
}else{
?>
 Aucune photo n'a &eacute;t&eacute; donn&eacute;.
<?php
}
?>
<br>
<?php if(($inscription['obs'])!="RAS"){ ?>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td width=95 valign=top>
Observations :
</td><td>
<?php echo nl2br (stripslashes($inscription['obs']));?>
</td></tr>
</table>
<?php } ?>
<hr>
<br>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td colspan=2>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'ligne_contrat_01'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'date_1'");
$parametre = mysql_fetch_array($parametre);
if(($parametre['valeur'])=="OUI"){
echo " ";
if($inscription['jour']<=9){echo "0";};
echo $inscription['jour']." / ";
if($inscription['mois']<=9){echo "0";};
echo $inscription['mois']." / ".$inscription['annee'];
}else{echo " ___ / ___ / ______";}
?>
</td></tr><tr><td width=50%></td><td>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'sous_ligne_contrat_01'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
?>
</td></tr></table><br>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td colspan=2>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'ligne_contrat_02'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'date_2'");
$parametre = mysql_fetch_array($parametre);
if(($parametre['valeur'])=="OUI"){
echo " ";
if($inscription['jour']<=9){echo "0";};
echo $inscription['jour']." / ";
if($inscription['mois']<=9){echo "0";};
echo $inscription['mois']." / ".$inscription['annee'];
}else{echo " ___ / ___ / ______";}
?>
</td></tr><tr><td width=25%></td><td>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'sous_ligne_contrat_02'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
?>
</td></tr></table><br>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td colspan=2>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'ligne_contrat_03'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'date_3'");
$parametre = mysql_fetch_array($parametre);
if(($parametre['valeur'])=="OUI"){
echo " ";
if($inscription['jour']<=9){echo "0";};
echo $inscription['jour']." / ";
if($inscription['mois']<=9){echo "0";};
echo $inscription['mois']." / ".$inscription['annee'];
}else{echo "___ / ___ / ______";}
?>
</td></tr><tr><td width=25%></td><td>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'sous_ligne_contrat_03'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
?>
</td></tr>
</table>
<br>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'ligne_contrat_04'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
?>
</td></tr>
</table>
<br>
<table border=0 width=<?php echo $largeur['valeur'] ?>>
<tr><td>
<font size=2>Détails sur la loi CNIL:</font>
</td></tr>
<tr><td>
<font size=1>
<?php
$parametre = mysql_query("SELECT * FROM generale WHERE nom = 'cnil'");
$parametre = mysql_fetch_array($parametre);
echo nl2br (stripslashes($parametre['valeur']));
?>
</font>
</td></tr>
</table>
<?php
}
else{
echo "<center><br><b>Il y a eu une erreur.<b></center>";
}
?>
</body>
</html>