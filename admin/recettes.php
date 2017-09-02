<?php include "../restrict/config.php";?>
<html>
<head>
<title>USM</title>
<script type="text/javascript">
		function affichage(id,total)
		{
			document.getElementById(id).innerHTML = total + " €";
		}
</script>
</head>
<body style="text-align:center">
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$saisons = mysql_query("SELECT saison FROM inscriptions WHERE actif = '1' ORDER BY saison");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
?>
<table border=0 CELLPADDING=3>
<?php
$saison="";
while($boucle_saison = mysql_fetch_array($saisons)){
if ($saison !=$boucle_saison['saison']){
$big_total=0;
$saison = $boucle_saison['saison'];
echo "<tr><td>";
?>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Recettes pour la saison <?php echo $saison; ?> : <font color=red id="<?php echo $saison; ?>"></font></b></font></legend>
<center><br>
<table class="table4" summary="">
<th>Données</th>
<th>Quantité</th>
<th>Prix Unit.<br>estimé</th>
<th>Total</th>
<tr><td align="center" colspan="4"><b><font color="red">-- Frais --</font></b></td></tr>
<?php
$sql_frais = mysql_query("SELECT id, nom FROM frais");
$variable = 0;
$total = 0;
while($boucle_frais = mysql_fetch_array($sql_frais)){
$sous_total = 0;
$quantite = 0;
$id_frais = $boucle_frais['id'];
$sql_inscriptions_frais = mysql_query("SELECT prix FROM inscriptions_frais, inscriptions WHERE 
		inscriptions_frais.id_frais='$id_frais' AND
		inscriptions.id=inscriptions_frais.id_inscriptions AND
		inscriptions.saison='$saison' AND
		inscriptions_frais.actif='1' AND
		inscriptions.actif='1'");

while($boucle_inscriptions_frais = mysql_fetch_array($sql_inscriptions_frais)){
$sous_total = $sous_total + $boucle_inscriptions_frais['prix'];
$quantite++;
}
if($quantite!=0){
if($variable%2){$couleur = "#EFECCA";}else{$couleur = "#EDF7F2";}
echo "<tr style=\"background:".$couleur.";\"><td align=\"right\">".$boucle_frais['nom']."</td><td align=\"center\">".$quantite."</td><td align=\"right\">".$sous_total/$quantite." €</td><td align=\"right\">".$sous_total." €</td></tr>";
$variable++;
$total = $total + $sous_total;
}}
$big_total = $total;
echo "<tr><td colspan=\"3\" align=\"right\">Sous Total</td><td align=\"right\"><b>".$total." €</b></td></tr>";
?>
<tr><td align="center" colspan="4"><b><font color="red">-- Cours --</font></b></td></tr>
<?php
$sql_cours = mysql_query("SELECT id, nom FROM cours");
$variable = 0;
$total = 0;
while($boucle_cours = mysql_fetch_array($sql_cours)){
$sous_total = 0;
$quantite = 0;
$id_cours = $boucle_cours['id'];
$sql_inscriptions_cours = mysql_query("SELECT prix FROM inscriptions_cours, inscriptions WHERE 
		inscriptions_cours.id_cours='$id_cours' AND
		inscriptions.id=inscriptions_cours.id_inscriptions AND
		inscriptions.saison='$saison' AND
		inscriptions_cours.actif='1' AND
		inscriptions.actif='1'");

while($boucle_inscriptions_cours = mysql_fetch_array($sql_inscriptions_cours)){
$sous_total = $sous_total + $boucle_inscriptions_cours['prix'];
$quantite++;
}
if($quantite!=0){
if($variable%2){$couleur = "#EFECCA";}else{$couleur = "#EDF7F2";}
echo "<tr style=\"background:".$couleur.";\"><td align=\"right\">".$boucle_cours['nom']."</td><td align=\"center\">".$quantite."</td><td align=\"right\">".$sous_total/$quantite." €</td><td align=\"right\">".$sous_total." €</td></tr>";
$variable++;
$total = $total + $sous_total;
}}
$big_total = $big_total + $total;
echo "<tr><td colspan=\"3\" align=\"right\">Sous Total</td><td align=\"right\"><b>".$total." €</b></td></tr>";
?>
<tr><td align="center" colspan="4"><b><font color="red">-- Activités --</font></b></td></tr>
<?php
$sql_activites = mysql_query("SELECT id, nom FROM activites");
$variable = 0;
$total = 0;
while($boucle_activites = mysql_fetch_array($sql_activites)){
$first = true;
$id_activite = $boucle_activites['id'];
$sql_tarif_activites = mysql_query("SELECT id, nom FROM tarifs_activites WHERE id_activites='$id_activite'");
while($boucle_tarif_activites = mysql_fetch_array($sql_tarif_activites)){
$id_tarif_activite = $boucle_tarif_activites['id'];
$sous_total = 0;
$quantite = 0;
$sql_inscriptions_tarifs_activites = mysql_query("SELECT prix FROM inscriptions_tarifs_activites, inscriptions WHERE 
		inscriptions_tarifs_activites.id_tarifs_activites='$id_tarif_activite' AND
		inscriptions.id=inscriptions_tarifs_activites.id_inscriptions AND
		inscriptions.saison='$saison' AND
		inscriptions_tarifs_activites.actif='1' AND
		inscriptions.actif='1'");

while($boucle_inscriptions_tarifs_activites = mysql_fetch_array($sql_inscriptions_tarifs_activites)){
$sous_total = $sous_total + $boucle_inscriptions_tarifs_activites['prix'];
$quantite++;
}
if($quantite!=0){
if($first){
echo "<tr><td><b>".$boucle_activites['nom']."</b></td><td colspan=3></td></tr>";
$first = false;
}
if($variable%2){$couleur = "#EFECCA";}else{$couleur = "#EDF7F2";}
echo "<tr style=\"background:".$couleur.";\"><td align=\"right\">".$boucle_tarif_activites['nom']."</td><td align=\"center\">".$quantite."</td><td align=\"right\">".$sous_total/$quantite." €</td><td align=\"right\">".$sous_total." €</td></tr>";
$variable++;
$total = $total + $sous_total;
}}}
$big_total = $big_total + $total;
echo "<tr><td colspan=\"3\" align=\"right\">Sous Total</td><td align=\"right\"><b>".$total." €</b></td></tr>";
echo "<tr><td colspan=4>TOTAL : ".$big_total."€</td></tr>";
?>
</table>
</center>
<script type="text/javascript">
	affichage('<?php echo $saison; ?>', '<?php echo $big_total; ?>');
</script>
</fieldset>
<tr><td height="15"></td></tr>
<?php
}}
?>

</center>
</body>
</html>