<?php include "restrict/config.php";?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center" onLoad="recalcule()">
<center>
<?php
$suivant = 1;
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;
$moduler_cheque = mysql_query("SELECT valeur FROM generale WHERE nom = 'moduler_cheque'");
$moduler_cheque = mysql_fetch_array($moduler_cheque);
if($moduler_cheque['valeur'] == "OUI"){
		$moduler_cheque = "";
		$ctrl_cheque ="<center>La case suivante doit être égale à 0€ pour que les changements soient pris en compte : <input type=\"text\" name=\"modif_total\" size=\"1\" id=\"id_0\" style=\"color : red\" readonly=\"readonly\">€.</center>";
	}else{
		$moduler_cheque = "readonly=\"readonly\"";
		$ctrl_cheque ="";
	}
?>
<form method="post" action="inscription_enregistrement.php">
<input type="hidden" name="saison" value="<?php echo $annee_actu."/".$annee_suivante;?>">
<?php
if((isset($_REQUEST["id_membre"]) && !empty($_REQUEST["id_membre"]))){
$id_membre = $_REQUEST["id_membre"];
?>
<input type="hidden" name="id_membre" value="<?php echo $id_membre;?>">
<?php
}
$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
$membre = mysql_fetch_array($membre);
echo "RECAPITULATIF DE L'INSCRIPTION DE<br>";
echo $membre['nom']." ".$membre['prenom'];
if(	isset($_POST["nb_trimestre"]) && !empty($_POST["nb_trimestre"])){
$nb_trimestre = $_POST["nb_trimestre"];
?>
<input type="hidden" name="trimestre" value="<?php echo $nb_trimestre;?>">
<input type="hidden" name="nom" value="<?php echo $membre['nom'];?>">
<input type="hidden" name="prenom" value="<?php echo $membre['prenom'];?>">
<?php
if ($nb_trimestre == 3){echo "<br>pour<font color=red> 3 </font>trimestres de la";}
elseif ($nb_trimestre == 2){echo "<br>pour<font color=red> 2 </font>trimestres de la";}
elseif ($nb_trimestre == 1){echo "<br>pour<font color=red> 1 </font>trimestre de la";}
}
echo "<br><b><font color=red>Saison ".$annee_actu." - ".$annee_suivante."</font></b><br>Etape 3 / 4<br><br>";

if(	isset($_POST["nb_activite"]) && !empty($_POST["nb_activite"]) &&
	isset($_POST["nb_cours"]) && !empty($_POST["nb_cours"])&&
	isset($_POST["nb_frais"]) && !empty($_POST["nb_frais"]) &&
	isset($_POST["nb_grade"]) && !empty($_POST["nb_grade"])){
$nb_activite = $_POST["nb_activite"];
$nb_cours = $_POST["nb_cours"];
$nb_frais = $_POST["nb_frais"];
$nb_grade = $_POST["nb_grade"];
$calcul_activite = 0;
$calcul_grade = 0;
$manque_grade = 0;
$prix_activite = 0;
$prix_cours = 0;
$prix_frais = 0;
$prix_caution = 0;
$reduc_manu = 0;
}
$calcul = 0;
$post_activite=1;
for($i=1;$i<=$nb_activite;$i++){
$activite = "activite_".$i;
if(	isset($_POST[$activite]) && !empty($_POST[$activite])){
$id_tarif_activite = ($_POST[$activite]);
?>

<input type="hidden" name="<?php echo "activite_".$post_activite;?>" value="<?php echo $id_tarif_activite;?>">
<?php
$post_activite++;
$tarif_activite = mysql_query("SELECT * FROM tarifs_activites WHERE id = '$id_tarif_activite'");
$tarif_activite = mysql_fetch_array($tarif_activite);
$id_activite = $tarif_activite['id_activites'];
if ($id_activite != $calcul){$calcul_activite++; $calcul = $id_activite;}
$activite = mysql_query("SELECT * FROM activites WHERE id = '$id_activite'");
$activite = mysql_fetch_array($activite);
echo "# <font color=blue>".$tarif_activite['nom']."</font> au prix de <font color=red>".($tarif_activite['prix']*1)." €</font> concernant l'activite <font color=blue>".$activite['nom']."</font><br>";
$prix_activite = $prix_activite + $tarif_activite['prix'];
}}
echo "<br>";
$calcul = 0;
$post_grade=1;
for($i=1;$i<=$nb_grade;$i++){
$grade = "grade_".$i;
if(	isset($_POST[$grade]) && !empty($_POST[$grade])){
$id_grade = $_POST[$grade];
if ($id_grade != 0){
$info_grade = mysql_query("SELECT * FROM grades WHERE id = '$id_grade'");
$info_grade = mysql_fetch_array($info_grade);
?>

<input type="hidden" name="<?php echo "grade_".$post_grade;?>" value="<?php echo $id_grade;?>">
<?php
$id_activite = $info_grade['id_activites'];
$activite = mysql_query("SELECT * FROM activites WHERE id = '$id_activite'");
$activite = mysql_fetch_array($activite);
$calcul_grade++;
$post_grade++;
echo "Le grade en d&eacute;but de saison pour l'activit&eacute; <font color=blue>".$activite['nom']."</font> est la ceinture <font color=blue>".$info_grade['nom']."</font><br>";
}}}
if ($prix_activite !=0){echo "<table class='table4' summary=''><th>Soit pour un sous total de <font color=red>".$prix_activite." € </font></th></table><br>";}
$post_cours=1;
for($i=1;$i<=$nb_cours;$i++){
$cours = "cours_".$i;
if(	isset($_POST[$cours]) && !empty($_POST[$cours])){
$id_cours = ($_POST[$cours]);
$cours = mysql_query("SELECT * FROM cours WHERE id = '$id_cours'");
$cours = mysql_fetch_array($cours);
$sous_prix_cours = $cours['prix'];
if ($nb_trimestre == 2){$sous_prix_cours = (($sous_prix_cours/3)*2);}
elseif ($nb_trimestre == 1){$sous_prix_cours = ($sous_prix_cours/3);}
?>

<input type="hidden" name="<?php echo "cours_".$post_cours;?>" value="<?php echo $id_cours;?>">
<?php
$post_cours++;
echo "# <font color=blue>".$cours['nom']."</font> au prix de <font color=red>".($sous_prix_cours*1)." €</font><br>";
$prix_cours = $prix_cours + $sous_prix_cours;
}}

$variable=0;
if ($prix_cours != 0 and (isset($_POST["reduc"]) && !empty($_POST["reduc"]))){
$variable=1;
$parametres = mysql_query("SELECT * FROM generale WHERE nom='reduction'");
$parametres = mysql_fetch_array($parametres);
$reduction = $parametres['valeur'];
$valeur = ($parametres['valeur']-1)*100;
echo "<table class='table4' summary=''><th>Soit pour un sous total de <font color=red><s>".$prix_cours." € </s></font>&nbsp;&nbsp;".$valeur." % : <font color=red>".$prix_cours*$reduction." € </font></th></table><br>";
$prix_cours=$prix_cours*$reduction;
?>

<input type="hidden" name="reduc" value="<?php echo $parametres['valeur']; ?>">
<?php
}
if ($prix_cours != 0 and $variable == 0){
echo "<table class='table4' summary=''><th>Soit pour un sous total de <font color=red>".$prix_cours." € </font></th></table><br>";
?>

<input type="hidden" name="reduc" value="1">
<?php
}

$post_frais=1;
for($i=1;$i<=$nb_frais;$i++){
$frais = "frais_".$i;
if(	isset($_POST[$frais]) && !empty($_POST[$frais])){
$id_frais = ($_POST[$frais]);
$frais = mysql_query("SELECT * FROM frais WHERE id = '$id_frais'");
$frais = mysql_fetch_array($frais);
?>

<input type="hidden" name="<?php echo "frais_".$post_frais;?>" value="<?php echo $id_frais;?>">
<?php
echo "# <font color=blue>".$frais['nom']."</font> au prix de <font color=red>".($frais['prix']*1)." €</font><br>";
if($frais['caution']==0){$prix_frais = $prix_frais + $frais['prix'];}else{$prix_caution = $prix_caution + $frais['prix'];}
$post_frais++;
}}
if ($prix_frais != 0){echo "<table class='table4' summary=''><th>Soit pour un sous total de <font color=red>".$prix_frais." € </font></th></table><br>";}

if(	isset($_POST["reduc_manu"]) && !empty($_POST["reduc_manu"])){
$reduc_manu = $_POST["reduc_manu"];
echo "<br>Modification manuelle du total de ".$reduc_manu." €";
?>

<input type="hidden" name="reduc_manu" value="<?php echo $reduc_manu;?>">
<?php
}else{
?>

<input type="hidden" name="reduc_manu" value="0">
<?php
}

$total = $prix_activite + $prix_cours + $prix_frais + $reduc_manu;
echo "<br><table class='table4' summary=''><th><font size=5>Le Montant total &agrave; r&eacute;gler est de <font color=red><b>".$total." €</b></font></font></th></table><br><br>";
if ($prix_caution != 0){echo "<table class='table4' summary=''><th>Avec une caution de <font color=red>".$prix_caution." € </font></th></table><br>";}

?>
<input type="hidden" name="prix_caution" value="<?php echo $prix_caution;?>">
<input type="hidden" name="total" value="<?php echo $total;?>">
<?php
if($calcul_activite != $calcul_grade){echo "Il y a une incoh&eacute;rence entre le nombre d'activit&eacute;s et le nombre de grades s&eacute;lectionn&eacute;s<br><br>";
$suivant=0;}

$p1_num=0;
$p2_num=0;
$p3_num=0;
$p4_num=0;
$p1_banque="";
$p2_banque="";
$p3_banque="";
$p4_banque="";
$p1_date=0;
$p2_date=0;
$p3_date=0;
$p4_date=0;

if(	isset($_POST["p4_num"]) && !empty($_POST["p4_num"])  &&
	isset($_POST["p4_banque"]) && !empty($_POST["p4_banque"])){

	$p4_num = $_POST["p4_num"];
	$p4_banque = $_POST["p4_banque"];

	$cheque_1 = ($prix_activite + $prix_frais + $reduc_manu);
	$cheque_2 = round((($prix_cours)/3));
	$cheque_3 = round((($prix_cours)/3));
	$cheque_4 = round((($prix_cours)/3));

	if(($cheque_1+$cheque_2+$cheque_3+$cheque_4) != $total){$cheque_2 = $cheque_2 + ($total-($cheque_1+$cheque_2+$cheque_3+$cheque_4));}

	if(	isset($_POST["p3_num"]) && !empty($_POST["p3_num"])){$p3_num = $_POST["p3_num"];}else{$suivant=0;}
	if(	isset($_POST["p3_banque"]) && !empty($_POST["p3_banque"])){$p3_banque = $_POST["p3_banque"];}else{$suivant=0;}
	if(	isset($_POST["p2_num"]) && !empty($_POST["p2_num"])){$p2_num = $_POST["p2_num"];}else{$suivant=0;}
	if(	isset($_POST["p2_banque"]) && !empty($_POST["p2_banque"])){$p2_banque = $_POST["p2_banque"];}else{$suivant=0;}
	if(	isset($_POST["p1_num"]) && !empty($_POST["p1_num"])){$p1_num = $_POST["p1_num"];}else{$suivant=0;}
	if(	isset($_POST["p1_banque"]) && !empty($_POST["p1_banque"])){$p1_banque = $_POST["p1_banque"];}else{$suivant=0;}

	$p4_date = $_POST["p4_date"];
	$p3_date = $_POST["p3_date"];
	$p2_date = $_POST["p2_date"];
	$p1_date = $_POST["p1_date"];

	if($p1_num < 10){$suivant=0;}
	if($p2_num < 10){$suivant=0;}
	if($p3_num < 10){$suivant=0;}
	if($p4_num < 10){$suivant=0;}
	?>

	<script type="text/javascript">
	function recalcule()
	{
		var total;
		var id_1;
		var id_2;
		var id_3;
		var id_4;
		
		total = <?php echo $total; ?>;
		id_1 = document.getElementById('id_1').value;
		id_2 = document.getElementById('id_2').value;
		id_3 = document.getElementById('id_3').value;
		id_4 = document.getElementById('id_4').value;
		
		document.getElementById('id_0').value = (((total)-(id_1)-(id_2)-(id_3)-(id_4)).toFixed(2))*1;
		
		if(total-id_1-id_2-id_3-id_4 == 0){
			document.getElementById('p1_prix').value = id_1;
			document.getElementById('p2_prix').value = id_2;
			document.getElementById('p3_prix').value = id_3;
			document.getElementById('p4_prix').value = id_4;
		}else{
			document.getElementById('p1_prix').value = <?php echo $cheque_1; ?>;
			document.getElementById('p2_prix').value = <?php echo $cheque_2; ?>;
			document.getElementById('p3_prix').value = <?php echo $cheque_3; ?>;
			document.getElementById('p4_prix').value = <?php echo $cheque_4; ?>;
		}
	}
	</script>
	<input type="hidden" name="espece" value="0">
	<input type="hidden" name="p1_num" value="<?php echo $p1_num;?>">
	<input type="hidden" name="p2_num" value="<?php echo $p2_num;?>">
	<input type="hidden" name="p3_num" value="<?php echo $p3_num;?>">
	<input type="hidden" name="p4_num" value="<?php echo $p4_num;?>">
	<input type="hidden" name="p1_banque" value="<?php echo $p1_banque;?>">
	<input type="hidden" name="p2_banque" value="<?php echo $p2_banque;?>">
	<input type="hidden" name="p3_banque" value="<?php echo $p3_banque;?>">
	<input type="hidden" name="p4_banque" value="<?php echo $p4_banque;?>">
	<input type="hidden" id="p1_prix" name="p1_prix" value="<?php echo $cheque_1;?>">
	<input type="hidden" id="p2_prix" name="p2_prix" value="<?php echo $cheque_2;?>">
	<input type="hidden" id="p3_prix" name="p3_prix" value="<?php echo $cheque_3;?>">
	<input type="hidden" id="p4_prix" name="p4_prix" value="<?php echo $cheque_4;?>">
	<input type="hidden" id="p1_date" name="p1_date" value="<?php echo $p1_date;?>">
	<input type="hidden" id="p2_date" name="p2_date" value="<?php echo $p2_date;?>">
	<input type="hidden" id="p3_date" name="p3_date" value="<?php echo $p3_date;?>">
	<input type="hidden" id="p4_date" name="p4_date" value="<?php echo $p4_date;?>">
	<?php
	echo "<table border=0><tr><td>";
	echo "Le montant du ch&egrave;que N°<font color=red><b>1</b></font> sera de <input type=\"text\" name=\"modif_1\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_1\" value=\"".$cheque_1."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p1_date, 1, 2000))).")</td>";
	if($p1_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p1_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p1_banque != ""){
	$ch_p1_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p1_banque'");
	$ch_p1_banque = mysql_fetch_array($ch_p1_banque);
	echo " de la banque <font color=blue>".$ch_p1_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td>Le montant du ch&egrave;que N°<font color=blue><b>2</b></font> sera de <input type=\"text\" name=\"modif_2\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_2\" value=\"".$cheque_2."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p2_date, 1, 2000))).")";
	if($p2_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p2_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p2_banque != ""){
	$ch_p2_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p2_banque'");
	$ch_p2_banque = mysql_fetch_array($ch_p2_banque);
	echo " de la banque <font color=blue>".$ch_p2_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td>Le montant du ch&egrave;que N°<font color=green><b>3</b></font> sera de <input type=\"text\" name=\"modif_3\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_3\" value=\"".$cheque_3."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p3_date, 1, 2000))).")";
	if($p3_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p3_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p3_banque != ""){
	$ch_p3_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p3_banque'");
	$ch_p3_banque = mysql_fetch_array($ch_p3_banque);
	echo " de la banque <font color=blue>".$ch_p3_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td>Le montant du ch&egrave;que N°<font color=blue><b>4</b></font> sera de <input type=\"text\" name=\"modif_4\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_4\" value=\"".$cheque_4."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p4_date, 1, 2000))).")";
	if($p4_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p4_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p4_banque != ""){
	$ch_p4_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p4_banque'");
	$ch_p4_banque = mysql_fetch_array($ch_p4_banque);
	echo " de la banque <font color=blue>".$ch_p4_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td colspan=\"3\">";
	echo $ctrl_cheque;
	echo"</td></tr></table><br>";
}
elseif(	isset($_POST["p3_num"]) && !empty($_POST["p3_num"])  &&
	isset($_POST["p3_banque"]) && !empty($_POST["p3_banque"])){
	
	$p3_num = $_POST["p3_num"];
	$p3_banque = $_POST["p3_banque"];

	$cheque_1 = ($prix_activite + $prix_frais + $reduc_manu + (round((($prix_cours)/3))));
	$cheque_2 = round((($prix_cours)/3));
	$cheque_3 = round((($prix_cours)/3));

	if(($cheque_1+$cheque_2+$cheque_3) != $total){$cheque_2 = $cheque_2 + ($total-($cheque_1+$cheque_2+$cheque_3));}

	if(	isset($_POST["p2_num"]) && !empty($_POST["p2_num"])){$p2_num = $_POST["p2_num"];}else{$suivant=0;}
	if(	isset($_POST["p2_banque"]) && !empty($_POST["p2_banque"])){$p2_banque = $_POST["p2_banque"];}else{$suivant=0;}
	if(	isset($_POST["p1_num"]) && !empty($_POST["p1_num"])){$p1_num = $_POST["p1_num"];}else{$suivant=0;}
	if(	isset($_POST["p1_banque"]) && !empty($_POST["p1_banque"])){$p1_banque = $_POST["p1_banque"];}else{$suivant=0;}
	
	$p3_date = $_POST["p3_date"];
	$p2_date = $_POST["p2_date"];
	$p1_date = $_POST["p1_date"];
	
	if($p1_num < 10){$suivant=0;}
	if($p2_num < 10){$suivant=0;}
	if($p3_num < 10){$suivant=0;}
	?>

	<script type="text/javascript">
	function recalcule()
	{
		var total;
		var id_1;
		var id_2;
		var id_3;
		
		total = <?php echo $total; ?>;
		id_1 = document.getElementById('id_1').value;
		id_2 = document.getElementById('id_2').value;
		id_3 = document.getElementById('id_3').value;
		
		document.getElementById('id_0').value = (((total)-(id_1)-(id_2)-(id_3)).toFixed(2))*1;
		
		if(total-id_1-id_2-id_3 == 0){
			document.getElementById('p1_prix').value = id_1;
			document.getElementById('p2_prix').value = id_2;
			document.getElementById('p3_prix').value = id_3;
		}else{
			document.getElementById('p1_prix').value = <?php echo $cheque_1; ?>;
			document.getElementById('p2_prix').value = <?php echo $cheque_2; ?>;
			document.getElementById('p3_prix').value = <?php echo $cheque_3; ?>;
		}
	}
	</script>
	<input type="hidden" name="espece" value="0">
	<input type="hidden" name="p1_num" value="<?php echo $p1_num;?>">
	<input type="hidden" name="p2_num" value="<?php echo $p2_num;?>">
	<input type="hidden" name="p3_num" value="<?php echo $p3_num;?>">
	<input type="hidden" name="p1_banque" value="<?php echo $p1_banque;?>">
	<input type="hidden" name="p2_banque" value="<?php echo $p2_banque;?>">
	<input type="hidden" name="p3_banque" value="<?php echo $p3_banque;?>">
	<input type="hidden" id="p1_prix" name="p1_prix" value="<?php echo $cheque_1;?>">
	<input type="hidden" id="p2_prix" name="p2_prix" value="<?php echo $cheque_2;?>">
	<input type="hidden" id="p3_prix" name="p3_prix" value="<?php echo $cheque_3;?>">
	<input type="hidden" id="p1_date" name="p1_date" value="<?php echo $p1_date;?>">
	<input type="hidden" id="p2_date" name="p2_date" value="<?php echo $p2_date;?>">
	<input type="hidden" id="p3_date" name="p3_date" value="<?php echo $p3_date;?>">
	<input type="hidden" name="p4_num" value="0">
	<input type="hidden" name="p4_banque" value="">
	<input type="hidden" id="p4_prix" name="p4_prix" value="0">
	<input type="hidden" id="p4_date" name="p4_date" value="">
	<?php
	echo "<table border=0><tr><td>";
	echo "Le montant du ch&egrave;que N°<font color=red><b>1</b></font> sera de <input type=\"text\" name=\"modif_1\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_1\" value=\"".$cheque_1."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p1_date, 1, 2000))).")</td>";
	if($p1_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p1_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p1_banque != ""){
	$ch_p1_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p1_banque'");
	$ch_p1_banque = mysql_fetch_array($ch_p1_banque);
	echo " de la banque <font color=blue>".$ch_p1_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td>Le montant du ch&egrave;que N°<font color=blue><b>2</b></font> sera de <input type=\"text\" name=\"modif_2\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_2\" value=\"".$cheque_2."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p2_date, 1, 2000))).")";
	if($p2_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p2_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p2_banque != ""){
	$ch_p2_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p2_banque'");
	$ch_p2_banque = mysql_fetch_array($ch_p2_banque);
	echo " de la banque <font color=blue>".$ch_p2_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td>Le montant du ch&egrave;que N°<font color=green><b>3</b></font> sera de <input type=\"text\" name=\"modif_3\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_3\" value=\"".$cheque_3."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p3_date, 1, 2000))).")";
	if($p3_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p3_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p3_banque != ""){
	$ch_p3_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p3_banque'");
	$ch_p3_banque = mysql_fetch_array($ch_p3_banque);
	echo " de la banque <font color=blue>".$ch_p3_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td colspan=\"3\">";
	echo $ctrl_cheque;
	echo"</td></tr></table><br>";
}

elseif(	isset($_POST["p2_num"]) && !empty($_POST["p2_num"])  &&
	isset($_POST["p2_banque"]) && !empty($_POST["p2_banque"])){
	
	$p2_num = $_POST["p2_num"];
	$p2_banque = $_POST["p2_banque"];

	$cheque_1 = ($prix_activite + $prix_frais + $reduc_manu);
	$cheque_2 = ($prix_cours);

	if(	isset($_POST["p1_num"]) && !empty($_POST["p1_num"])){$p1_num = $_POST["p1_num"];}else{$suivant=0;}
	if(	isset($_POST["p1_banque"]) && !empty($_POST["p1_banque"])){$p1_banque = $_POST["p1_banque"];}else{$suivant=0;}
	
	$p2_date = $_POST["p2_date"];
	$p1_date = $_POST["p1_date"];
	
	if($p1_num < 10){$suivant=0;}
	if($p2_num < 10){$suivant=0;}
	?>

	<script type="text/javascript">
	function recalcule()
	{
		var total;
		var id_1;
		var id_2;
		
		total = <?php echo $total; ?>;
		id_1 = document.getElementById('id_1').value;
		id_2 = document.getElementById('id_2').value;
		
		document.getElementById('id_0').value = (((total)-(id_1)-(id_2)).toFixed(2))*1;
		
		if(total-id_1-id_2 == 0){
			document.getElementById('p1_prix').value = id_1;
			document.getElementById('p2_prix').value = id_2;
		}else{
			document.getElementById('p1_prix').value = <?php echo $cheque_1; ?>;
			document.getElementById('p2_prix').value = <?php echo $cheque_2; ?>;
		}
	}
	</script>
	<input type="hidden" name="espece" value="0">
	<input type="hidden" name="p1_num" value="<?php echo $p1_num;?>">
	<input type="hidden" name="p2_num" value="<?php echo $p2_num;?>">
	<input type="hidden" name="p1_banque" value="<?php echo $p1_banque;?>">
	<input type="hidden" name="p2_banque" value="<?php echo $p2_banque;?>">
	<input type="hidden" id="p1_prix" name="p1_prix" value="<?php echo $cheque_1;?>">
	<input type="hidden" id="p2_prix" name="p2_prix" value="<?php echo $cheque_2;?>">
	<input type="hidden" id="p1_date" name="p1_date" value="<?php echo $p1_date;?>">
	<input type="hidden" id="p2_date" name="p2_date" value="<?php echo $p2_date;?>">
	<input type="hidden" name="p3_num" value="0">
	<input type="hidden" name="p3_banque" value="">
	<input type="hidden" id="p3_prix" name="p3_prix" value="0">
	<input type="hidden" id="p3_date" name="p3_date" value="">
	<input type="hidden" name="p4_num" value="0">
	<input type="hidden" name="p4_banque" value="">
	<input type="hidden" id="p4_prix" name="p4_prix" value="0">
	<input type="hidden" id="p4_date" name="p4_date" value="">
	<?php
	echo "<table border=0><tr><td>";
	echo "Le montant du ch&egrave;que N°<font color=red><b>1</b></font> sera de <input type=\"text\" name=\"modif_1\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_1\" value=\"".$cheque_1."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p1_date, 1, 2000))).")</td>";
	if($p1_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p1_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p1_banque != ""){
	$ch_p1_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p1_banque'");
	$ch_p1_banque = mysql_fetch_array($ch_p1_banque);
	echo " de la banque <font color=blue>".$ch_p1_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td>Le montant du ch&egrave;que N°<font color=blue><b>2</b></font> sera de <input type=\"text\" name=\"modif_2\" size=\"1\" onkeyup=\"recalcule()\" id=\"id_2\" value=\"".$cheque_2."\" style=\"color : red\"".$moduler_cheque."><font color=red>€.</font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p2_date, 1, 2000))).")";
	if($p2_num != 0){echo "<td width=10></td><td>Ch&egrave;que N° <font color=blue>".$p2_num."</font>";}else{echo "<td width=10></td><td>Num&eacute;ro de ch&egrave;que inconnu";}
	if($p2_banque != ""){
	$ch_p2_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p2_banque'");
	$ch_p2_banque = mysql_fetch_array($ch_p2_banque);
	echo " de la banque <font color=blue>".$ch_p2_banque['banque']."</font></td></tr>";}else{echo " d'une banque inconnue</td></tr>";}
	echo "<tr><td colspan=\"3\">";
	echo $ctrl_cheque;
	echo"</td></tr></table><br>";
}

elseif(	isset($_POST["p1_num"]) && !empty($_POST["p1_num"])  &&
	isset($_POST["p1_banque"]) && !empty($_POST["p1_banque"])){

	$p1_num = $_POST["p1_num"];
	$p1_banque = $_POST["p1_banque"];
	$p1_date = $_POST["p1_date"];
	$cheque_1 = $prix_activite + $prix_cours + $prix_frais + $reduc_manu;

	if($p1_num < 10){$suivant=0;}
	?>

	<input type="hidden" name="espece" value="0">
	<input type="hidden" name="p1_num" value="<?php echo $p1_num;?>">
	<input type="hidden" name="p1_banque" value="<?php echo $p1_banque;?>">
	<input type="hidden" name="p1_prix" value="<?php echo $cheque_1;?>">
	<input type="hidden" name="p2_num" value="0">
	<input type="hidden" name="p2_banque" value="">
	<input type="hidden" name="p2_prix" value="0">
	<input type="hidden" id="p2_date" name="p2_date" value="">
	<input type="hidden" name="p3_num" value="0">
	<input type="hidden" name="p3_banque" value="">
	<input type="hidden" name="p3_prix" value="0">
	<input type="hidden" id="p3_date" name="p3_date" value="">
	<input type="hidden" name="p4_num" value="0">
	<input type="hidden" name="p4_banque" value="">
	<input type="hidden" name="p4_prix" value="0">
	<input type="hidden" id="p4_date" name="p4_date" value="">
	<?php
	echo "Le montant du ch&egrave;que N°<font color=red><b>1</b></font> sera de <font color=red>".$cheque_1." €. </font> (".ucfirst(strftime("%B", mktime(0, 0, 0, $p2_date, 1, 2000))).") ";
	if($p1_num != 0){echo "Ch&egrave;que N° <font color=blue>".$p1_num."</font>";}else{echo "Num&eacute;ro de ch&egrave;que inconnu";}
	if($p1_banque != ""){
	$ch_p1_banque = mysql_query("SELECT banque FROM banques WHERE id = '$p1_banque'");
	$ch_p1_banque = mysql_fetch_array($ch_p1_banque);
	echo " de la banque <font color=blue>".$ch_p1_banque['banque']."</font><br><br>";}else{echo " d'une banque inconnue<br><br>";}
}
else{
echo "La somme consid&eacute;r&eacute;e sera vers&eacute;e en esp&egrave;ce, puisque les renseignements concernant les cheques n'ont pas, ou ont mal &eacute;t&eacute; renseign&eacute;s<br><br>";
?>

<input type="hidden" name="espece" value="1">
<?php
}

if(	isset($_POST["caution"]) && !empty($_POST["caution"])){
$caution = $_POST["caution"];
?>

<input type="hidden" name="caution" value="<?php echo $caution; ?>">
<?php
if ($caution == "cheque"){
if(	isset($_POST["caution_num"]) && !empty($_POST["caution_num"])){
$caution_num = "avec le numero <font color=red>".$_POST["caution_num"]."</font>";
?>

<input type="hidden" name="caution_num" value="<?php echo $_POST["caution_num"]; ?>">
<?php
}else{
$caution_num = "mais aucun num&eacute;ro de ch&egrave;que n'a &eacute;t&eacute; renseign&eacute;";
$suivant=0;
}
if(	isset($_POST["caution_banque"]) && !empty($_POST["caution_banque"])){
$id_caution_banque=$_POST["caution_banque"];
$ch_caution_banque = mysql_query("SELECT * FROM banques WHERE id = '$id_caution_banque'");
$ch_caution_banque = mysql_fetch_array($ch_caution_banque);
$caution_banque = "de la banque <font color=blue>".$ch_caution_banque["banque"]."</font>";
?>
<input type="hidden" name="caution_banque" value="<?php echo $id_caution_banque; ?>">
<?php
}else{
$caution_banque = "aucun nom de banque n'a &eacute;t&eacute; renseign&eacute;";
$suivant=0;
}
echo "Une caution de ".$prix_caution."€ sera donn&eacute;e en ch&egrave;que ".$caution_num." ".$caution_banque;
}
elseif($caution == "espece"){
echo "Une caution de ".$prix_caution."€ sera donn&eacute;e en <font color=red>espece</font>";
}}


else{if($prix_caution != 0){
echo "Une caution est nécessaire, et certaines informations ne sont pas renseignée";
$suivant=0;
}else{
echo "Aucune caution ne sera donn&eacute;e";
?>

<input type="hidden" name="caution" value="0">
<?php
}}

if(	isset($_POST["passeport"]) && !empty($_POST["passeport"])){
$passeport=$_POST["passeport"];
?>

<input type="hidden" name="passeport" value="<?php echo $passeport;?>">
<?php
if ($passeport == "OUI"){echo "<br>Passeport <font color=red>donn&eacute;</font>, fait et rempli.";}
elseif ($passeport == "NON"){echo "<br><font color=red>Aucun Passeport</font> donn&eacute;.";}
}
else{
echo "<br>Aucune information n'a &eacute;t&eacute; renseign&eacute;e concernant le passeport.";
$suivant=0;
}

if(	isset($_POST["photo"]) && !empty($_POST["photo"])){
$photo=$_POST["photo"];
?>

<input type="hidden" name="photo" value="<?php echo $photo;?>">
<?php
if ($photo == "OUI"){echo "<br>Photo : <font color=red>OUI</font>";}
elseif ($photo == "NON"){echo "<br>Photo : <font color=red>NON</font>";}
}
else{
echo "<br>Aucune information n'a &eacute;t&eacute; renseign&eacute;e concernant la photo.";
$suivant=0;
}
if(	isset($_POST["certificat"]) && !empty($_POST["certificat"])){
$certificat=$_POST["certificat"];
?>
<input type="hidden" name="certificat" value="<?php echo $certificat;?>">
<?php
if($certificat=="OUI"){
if(	isset($_POST["certificat_jj"]) && !empty($_POST["certificat_jj"])  &&
	isset($_POST["certificat_mm"]) && !empty($_POST["certificat_mm"])){
$certificat_jj=$_POST["certificat_jj"];
$certificat_mm=$_POST["certificat_mm"];
$certificat_aaaa=$_POST["certificat_aaaa"];
if (($certificat_jj > 31) or ($certificat_mm > 12)){
echo "<br>Il y a eu une erreur lors de la saisie de la date du certificat m&eacute;dical...";
$suivant=0;
}
else{
echo "<br>Le certificat m&eacute;dical a &eacute;t&eacute; d&eacute;livr&eacute; le <font color=red>".$certificat_jj." / ".$certificat_mm." / ".$certificat_aaaa."</font>";
?>
<input type="hidden" name="certificat_jj" value="<?php echo $certificat_jj;?>">
<input type="hidden" name="certificat_mm" value="<?php echo $certificat_mm;?>">
<input type="hidden" name="certificat_aaaa" value="<?php echo $certificat_aaaa;?>">
<?php
}}else{
echo "<br>Il y a eu une erreur lors de la saisie de la date du certificat m&eacute;dical...";
$suivant=0;
}}else{
echo "<br>Le certificat médical n'a pas &eacute;t&eacute; donn&eacute;";
}}
else{
echo "<br>Aucune information n'a &eacute;t&eacute; renseign&eacute;e concernant le certificat m&eacute;dical.";
$suivant=0;
}
if(	isset($_POST["obs"]) && !empty($_POST["obs"])){
$obs = $_POST["obs"];
?>

<input type="hidden" name="obs" value="<?php echo $obs;?>">
<?php
if ($obs == "RAS"){echo "<br>Il n'y a aucune observation particuli&egrave;re"; }else{
echo "<br>- Observations -<br><textarea name=\"obs\" cols=\"33\" rows=\"5\">".$obs."</textarea>";
}}
if($suivant == 1){echo "<br><br><input type=\"button\" value=\"Pr&eacute;c&eacute;dent\" onclick=\"Javascript:history.back();\"><input type=\"submit\" value=\"Enregistrer\">&nbsp;&nbsp;&nbsp;";}
else{echo "<br><br><input type=\"button\" value=\"Enregistrer\">&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Pr&eacute;c&eacute;dent\" onclick=\"Javascript:history.back();\"><br>Bouton inactiv&eacute; suite &agrave; une incoh&eacute;rence...";}
?>
<br><br>
<input type="hidden" name="nb_activite" value="<?php echo $post_activite-1;?>">
<input type="hidden" name="nb_cours" value="<?php echo $post_cours-1;?>">
<input type="hidden" name="nb_frais" value="<?php echo $post_frais-1;?>">
<input type="hidden" name="nb_grade" value="<?php echo $post_grade-1;?>">
</form>
</center>
</body>
</html>