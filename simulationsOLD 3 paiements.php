<?php include "restrict/config.php";?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center">
<center>
<?php
$suivant = 1;
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;
if((isset($_POST["id_membre"]) && !empty($_POST["id_membre"]))){
$id_membre = $_POST["id_membre"];
}
$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
$membre = mysql_fetch_array($membre);
echo "SIMULATION DE L'INSCRIPTION DE<br>";
echo $membre['nom']." ".$membre['prenom'];
if(	isset($_POST["nb_trimestre"]) && !empty($_POST["nb_trimestre"])){
$nb_trimestre = $_POST["nb_trimestre"];
if ($nb_trimestre == 3){echo "<br>pour<font color=red> 3 </font>trimestres de la";}
elseif ($nb_trimestre == 2){echo "<br>pour<font color=red> 2 </font>trimestres de la";}
elseif ($nb_trimestre == 1){echo "<br>pour<font color=red> 1 </font>trimestre de la";}
}
echo "<br><b><font color=red>Saison ".$annee_actu." - ".$annee_suivante."</font></b><br>";
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
$calcul = 0;
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
}
if ($prix_cours != 0 and $variable == 0){
echo "<table class='table4' summary=''><th>Soit pour un sous total de <font color=red>".$prix_cours." € </font></th></table><br>";
}
$post_frais=1;
for($i=1;$i<=$nb_frais;$i++){
$frais = "frais_".$i;
if(	isset($_POST[$frais]) && !empty($_POST[$frais])){
$id_frais = ($_POST[$frais]);
$frais = mysql_query("SELECT * FROM frais WHERE id = '$id_frais'");
$frais = mysql_fetch_array($frais);
if($frais['caution']==0){
echo "# <font color=blue>".$frais['nom']."</font> au prix de <font color=red>".($frais['prix']*1)." €</font><br>";
$prix_frais = $prix_frais + $frais['prix'];
$post_frais++;
}}}
if ($prix_frais != 0){echo "<table class='table4' summary=''><th>Soit pour un sous total de <font color=red>".$prix_frais." € </font></th></table><br>";}
$post_frais=1;
for($i=1;$i<=$nb_frais;$i++){
$frais = "frais_".$i;
if(	isset($_POST[$frais]) && !empty($_POST[$frais])){
$id_frais = ($_POST[$frais]);
$frais = mysql_query("SELECT * FROM frais WHERE id = '$id_frais'");
$frais = mysql_fetch_array($frais);
if($frais['caution']==1){
echo "# <font color=blue>".$frais['nom']."</font> au prix de <font color=red>".($frais['prix']*1)." €</font><br>";
$prix_caution = $prix_caution + $frais['prix'];
$post_frais++;
}}}
if ($prix_caution != 0){echo "<table class='table4' summary=''><th>Soit pour un sous total en caution de <font color=red>".$prix_caution." € </font></th></table><br>";}
if(	isset($_POST["reduc_manu"]) && !empty($_POST["reduc_manu"])){
$reduc_manu = $_POST["reduc_manu"];
echo "<br>Modification manuelle du total de ".$reduc_manu." €";
}
$total = $prix_activite + $prix_cours + $prix_frais + $reduc_manu;
echo "<table class='table4' summary=''><th><font size=5>Le Montant total &agrave; r&eacute;gler est de <font color=red><b>".$total." €</b></font></font></th></table><br><br>";
?>
<table class='table4' summary='' style="text-align:center;">
<th>1 Paiement</th>
<th>2 Paiements</th>
<th>3 Paiements</th>
<tr><td>
<?php echo $total;?>€
</td><td><center>
<table>
<tr>
<?php
if (((round($prix_cours /3))*3) == $prix_cours)
{
$_2_1 = $prix_activite + $prix_frais + $reduc_manu + (($prix_cours)/3);
$_2_2 = (($prix_cours)/3)*2;

$_3_1 = $prix_activite + $prix_frais + $reduc_manu + (($prix_cours)/3);
$_3_2 = (($prix_cours)/3);
$_3_3 = (($prix_cours)/3);
}else
{
$_2_1 = round($prix_activite + $prix_frais + $reduc_manu + (($prix_cours)/3));
$_2_2 = round((($prix_cours)/3)*2);
if(($_2_1+$_2_2) != $total){$_2_1 = $_2_1 + ($total-($_2_1+$_2_2));}

$_3_1 = round($prix_activite + $prix_frais + $reduc_manu + (($prix_cours)/3));
$_3_2 = round((($prix_cours)/3));
$_3_3 = round((($prix_cours)/3));
if(($_3_1+$_3_2+$_3_3) != $total){$_3_1 = $_3_1 + ($total-($_3_1+$_3_2+$_3_3));}
}
?>
<td height=50% style="border:0px;">N°1 : </td><td height=50% style="border:0px;"><?php echo $_2_1; ?>€</td>
</tr>
<tr>
<td height=50% style="border:0px;">N°2 : </td><td height=50% style="border:0px;"><?php echo $_2_2;?>€</td>
</tr>
</table>
</center>
</td><td>
<table>
<tr>
<td height=50% style="border:0px;">N°1 : </td><td height=50% style="border:0px;"><?php echo $_3_1;?>€</td>
</tr>
<tr>
<td height=50% style="border:0px;">N°2 : </td><td height=50% style="border:0px;"><?php echo $_3_2;?>€</td>
</tr>
<tr>
<td height=50% style="border:0px;">N°3 : </td><td height=50% style="border:0px;"><?php echo $_3_3;?>€</td>
</tr>
</table>
</td></tr>
</table>
</center>
</body>
</html>