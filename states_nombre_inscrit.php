<?php include "restrict/config.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
?>
<html>
<head>
<script type="text/javascript">
		function OpenBooking_voir(id,annee_1,annee_2) {
			window.open("states_cours.php?id_cours=" + id + "&annee_1=" + annee_1 + "&annee_2=" + annee_2, "states_cours", "scrollbars=1, width=500, height=435, left=" + (screen.width-500)/2 + ", top=" + (screen.height-435)/2);
		}
</script>
</head>
<body>
<center>
<table border=0 CELLPADDING=3>
<?php
$saison = $_POST['saison'];
$total_inscrit = mysql_query("SELECT COUNT(*) AS total FROM inscriptions WHERE saison = '$saison' AND actif = '1'");
$total_inscrit = mysql_fetch_array($total_inscrit);
$total_inscrit = $total_inscrit['total'];
echo "<tr><td>";
?>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Saison <?php echo $saison; ?>&nbsp;</b></font></legend>
<center>
Il y a <font color=red><b><?php echo $total_inscrit; ?></b></font> inscrits pour la saison.<br><br>
<table>
<?php
$cours = mysql_query("SELECT id, nom FROM cours WHERE actif='1' ORDER BY nom");
while($boucle_cours = mysql_fetch_array($cours)){
$id_cours = $boucle_cours['id'];
$total_cours = 0;
$inscription_cours = mysql_query("SELECT id_inscriptions FROM inscriptions_cours WHERE id_cours = '$id_cours' AND actif='1'");
while($boucle_inscription_cours = mysql_fetch_array($inscription_cours)){
$id_inscription = $boucle_inscription_cours['id_inscriptions'];
$sous_total = mysql_query("SELECT COUNT(*) AS total FROM inscriptions WHERE saison = '$saison' AND id = '$id_inscription' AND actif = '1'");
$sous_total = mysql_fetch_array($sous_total);
$sous_total = $sous_total['total'];
if ($sous_total == 1){$total_cours++;}
}
if($total_cours != 0){
list($annee_1, $annee_2) = split('[/.-]', $saison);
echo "<tr><td><center><button onClick=\"OpenBooking_voir(".$boucle_cours['id'].",".$annee_1.",".$annee_2.")\">".$total_cours."</button></center></td><td width=5></td><td>personnes sont inscrites au cours de <font color=red><b>".$boucle_cours['nom']."</b></font></td></tr>";
}}
?>
</table>
</center>
</fieldset>
</td></tr><tr height=20><td></td></tr>
<?php
if($saison == ""){
echo "Aucune réservation n'est enregistrée dans la base.";
}
?>
</table>
</center>
</body>
</html>