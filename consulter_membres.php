<?php include "restrict/config.php";
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
$ctrl_membres = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM membres WHERE actif = '1'");
$ctrl_membres = mysql_fetch_array($ctrl_membres);
$ctrl_membres = $ctrl_membres['nbre_entrees'];

?>
<html>
<head>
<script type="text/javascript">
		function OpenBooking_details(id) {
			window.open("detail_membre.php?page=consulter_membres&id_membre=" + id, "details_membre", "width=800, height=470, left=" + (screen.width-800)/2 + ", top=" + (screen.height-470)/2);
		}
		function OpenBooking_inscrire(id) {
			window.open("inscription_inscription.php?id_membre=" + id, "inscription_membre", "width=1100, height=700, resizable = yes, scrollbars = yes, left=" + (screen.width-1100)/2 + ", top=" + (screen.height-700)/2);
		}
		function OpenBooking_sup(id) {
			window.open("act_sup_membres.php?page=consulter_membres&id_membre=" + id, "sup_membre", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
</script>
</head>
<body>
<?php
if ($ctrl_membres == 0){
echo "<br><center>Aucun membre n'est actif dans la base de donn&eacute;es.</center><br>";
}
else{
?>
<center>
<table border=0 CELLPADDING=3>
<tr><td>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Liste des membres actifs&nbsp;</b></font></legend>
<br>
<table class="table4" summary="">
<th>Nom</th>
<th>Pr&eacute;nom</th>
<th colspan=3>Membre</th>
<?php
$variable = 0;
$membre = mysql_query("SELECT id, nom, prenom FROM membres WHERE actif = '1' ORDER BY nom");
$parametres = mysql_query("SELECT * FROM generale WHERE nom='sup_membre'");
$parametres = mysql_fetch_array($parametres);
while($boucle_membre = mysql_fetch_array($membre)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
$variable++;
echo "<tr style=background:".$couleur."><td>".$boucle_membre['nom']."</td><td>".$boucle_membre['prenom']."</td>";
$id_membre = $boucle_membre['id'];
$inscription = mysql_query("SELECT * FROM inscriptions WHERE id_membre = '$id_membre' AND saison = '$saison' AND actif = '1'");
$inscription = mysql_fetch_array($inscription);
if($inscription['id_membre']!=$id_membre){
echo "<td><button onClick=\"OpenBooking_details(".$boucle_membre['id'].")\" title=\"Du membre\">D&eacute;tails</button></td><td><button onClick=\"OpenBooking_inscrire(".$boucle_membre['id'].")\" title=\"Pour la saison ".$saison."\">Inscrire</button></td>";
}else{echo "<td><button onClick=\"OpenBooking_details(".$boucle_membre['id'].")\" title=\"Du membre\">D&eacute;tails</button></td><td  title=\"Membre d&eacute;j&agrave; inscrit pour la saison ".$saison."\"</td>";
}
if($parametres['valeur'] == "OUI"){echo "<td><button onClick=\"OpenBooking_sup(".$boucle_membre['id'].")\">Sup</button></td>";
}}}
?>
</tr>
</table>
</fieldset>
</td></tr>
</table>
</center>
</body>
</html>