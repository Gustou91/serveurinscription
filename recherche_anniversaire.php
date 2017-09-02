<html>
<head>
</head>
<body>
<center>
<?php include "restrict/config.php";
$ok=0;
if(	isset($_POST["de_aaaa"]) && !empty($_POST["de_aaaa"]) &&
	isset($_POST["a_aaaa"]) && !empty($_POST["a_aaaa"])){
$de_aaaa = $_POST["de_aaaa"];
$a_aaaa = $_POST["a_aaaa"];
$type = $_POST["type"];
$ok=1;}
elseif(	isset($_REQUEST["de_aaaa"]) && !empty($_REQUEST["de_aaaa"]) &&
		isset($_REQUEST["a_aaaa"]) && !empty($_REQUEST["a_aaaa"])){
$de_aaaa = $_REQUEST["de_aaaa"];
$a_aaaa = $_REQUEST["a_aaaa"];
$type = $_REQUEST["type"];
$ok=1;}
else{
?>
<script>alert ("Il manque au moins une donnée\nconcernant le membre")</script>
<?php
}
if($ok==1){
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;
$saison = $annee_actu."/".$annee_suivante;
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
$sup_inscription = mysql_query("SELECT * FROM generale WHERE nom='sup_inscription'");
$sup_inscription = mysql_fetch_array($sup_inscription);
$sup_membre = mysql_query("SELECT * FROM generale WHERE nom='sup_membre'");
$sup_membre = mysql_fetch_array($sup_membre);
?>
<script type="text/javascript">
		function OpenBooking_details(id) {
			window.open("detail_membre.php?page=recherche_anniversaire&de_aaaa=<?php echo $de_aaaa; ?>&a_aaaa=<?php echo $a_aaaa; ?>&type=<?php echo $type; ?>&id_membre=" + id, "details_membre", "width=750, height=450, left=" + (screen.width-750)/2 + ", top=" + (screen.height-450)/2);
		}
		function OpenBooking_inscrire(id) {
			window.open("inscription_inscription.php?id_membre=" + id, "inscription_membre", "width=1100, height=700, resizable = yes, scrollbars = yes, left=" + (screen.width-1100)/2 + ", top=" + (screen.height-700)/2);
		}
		function OpenBooking_editer(id) {
			window.open("imprimer_inscription.php?id_inscription=" + id, "imprimer", "resizable = yes, scrollbars = yes,location=no, status=no, menubar=no, width=930, height=850, left=" + (screen.width-930)/2 + ", top=0");
		}
		function OpenBooking_sup(id) {
			window.open("act_sup_inscriptions.php?page=recherche_anniversaire&de_aaaa=<?php echo $de_aaaa; ?>&a_aaaa=<?php echo $a_aaaa; ?>&type=<?php echo $type; ?>&id_inscription=" + id, "sup_inscription", "resizable = no, scrollbars = no,location=no, status=no, menubar=no, width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
</script>
<?php
if($type == "general"){
$nb_membres = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM membres WHERE ( aaaa >= '$de_aaaa' AND aaaa <='$a_aaaa') AND actif='1'");
$nb_membres = mysql_fetch_array($nb_membres);
$nb_membres = $nb_membres['nbre_entrees'];
if($nb_membres!=0){
echo "<b>Recherche des membres nés entre ".$de_aaaa." et ".$a_aaaa.".</b><br><br>";
$membres = mysql_query("SELECT * FROM membres WHERE ( aaaa >= '$de_aaaa' AND aaaa <='$a_aaaa') AND actif='1' ORDER BY nom");
?>

<table class="table4" summary="">
<th>Nom</th>
<th>Pr&eacute;nom</th>
<th colspan=3>Membre</th>
<?php
$variable = 0;
$total=1;
while($boucle_membre = mysql_fetch_array($membres)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
$variable++;
$total++;
echo "<tr style=background:".$couleur."><td>".$boucle_membre['nom']."</td><td>".$boucle_membre['prenom']."</td>";
$id_membre = $boucle_membre['id'];
$inscription = mysql_query("SELECT * FROM inscriptions WHERE id_membre = '$id_membre' AND saison = '$saison' AND actif = '1'");
$inscription = mysql_fetch_array($inscription);
if($inscription['id_membre']!=$id_membre){
echo "<td><button onClick=\"OpenBooking_details(".$boucle_membre['id'].")\" title=\"Du membre\">D&eacute;tails</button></td><td><button onClick=\"OpenBooking_inscrire(".$boucle_membre['id'].")\" title=\"Pour la saison ".$saison."\">Inscrire</button></td>";
}else{
echo "<td><button onClick=\"OpenBooking_details(".$boucle_membre['id'].")\" title=\"Du membre\">D&eacute;tails</button></td><td  title=\"Membre d&eacute;j&agrave; inscrit pour la saison ".$saison."\"</td>";
}
if($sup_membre['valeur'] == "OUI"){echo "<td><button onClick=\"OpenBooking_sup(".$boucle_membre['id'].")\">Sup</button></td>";
}
}
echo "</table>";
}else{
echo "<br><b>Aucune personne n'est née entre ".$de_aaaa." et ".$a_aaaa."</b>";
}}
else{
$nb_membres = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM membres WHERE ( aaaa >= '$de_aaaa' AND aaaa <='$a_aaaa') AND actif='1'");
$nb_membres = mysql_fetch_array($nb_membres);
$nb_membres = $nb_membres['nbre_entrees'];
if($nb_membres!=0){
echo "<b>Recherche des membres nés entre ".$de_aaaa." et ".$a_aaaa.".</b><br><br>";
$saisons = mysql_query("SELECT saison FROM inscriptions WHERE actif = '1' ORDER BY saison");
?>
<table border=0 CELLPADDING=3>
<?php
$saison="";
while($boucle_saison = mysql_fetch_array($saisons)){
if ($saison !=$boucle_saison['saison']){
$saison = $boucle_saison['saison'];
echo "<tr><td>";
?>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Membres inscrits pour la saison <?php echo $saison; ?>&nbsp;</b></font></legend>
<center><br>
<table class="table4" summary="">
<th>Nom</th>
<th>Pr&eacute;nom</th>
<th>feuille N° </th>
<th>Inscription</th>
<th>Membre</th>
<?php
$variable = 0;
$membre = mysql_query("SELECT * FROM membres WHERE ( aaaa >= '$de_aaaa' AND aaaa <='$a_aaaa') AND actif='1' ORDER BY nom");
while($boucle_membre = mysql_fetch_array($membre)){
$id_membre = $boucle_membre['id'];
$inscription = mysql_query("SELECT * FROM inscriptions WHERE id_membre = '$id_membre' AND saison = '$saison' AND actif = '1'");
$inscription = mysql_fetch_array($inscription);
if($inscription['id_membre'] == $id_membre){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
$variable++;
echo "<tr style=background:".$couleur."><td>".$boucle_membre['nom']."</td><td>".$boucle_membre['prenom']."</td><td align=center>".$inscription['id']."</td><td align=center ><button onClick=\"OpenBooking_editer(".$inscription['id'].")\" title=\"La feuille d'inscription\">Editer</button>";
if ($sup_inscription['valeur'] == "OUI"){echo "&nbsp;<button onClick=\"OpenBooking_sup(".$inscription['id'].")\">Supprimer</button>"; }
echo "</td><td align=center ><button onClick=\"OpenBooking_details(".$boucle_membre['id'].")\" title=\"Du membre\">D&eacute;tails</button></td></tr>";
}}
echo "</table></fieldset>";
echo "</td></tr><tr height=20><td></td></tr>";
}}
echo "</table>";
}else{
echo "<br><b>Aucune personne n'est née entre ".$de_aaaa." et ".$a_aaaa."</b>";
}
if(isset($saison) == ""){
echo "<br>Aucune réservation n'est enregistrée dans la base.";
}
}}
?>
</center>
</body>
</html>