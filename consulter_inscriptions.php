<?php 
	include "restrict/config.php";
	require_once "includes/log4php/Logger.php";

	Logger::configure('init/config.xml');
	$log = Logger::getLogger('TRACE');
	$logError = Logger::getLogger('ERROR');

	$log->trace("Début liste des adhérents.");
	
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'ansi' );
	$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
	$couleur_01 = mysql_fetch_array($couleur_01);
	$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
	$couleur_02 = mysql_fetch_array($couleur_02);
	$saison_demande = $_POST['saison'];
	if ($saison_demande == ""){$saison_demande = $_GET['saison'];}
	$saisons = mysql_query("SELECT saison FROM inscriptions WHERE actif = '1' AND saison = '$saison_demande' ORDER BY saison");
	$sup_parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sup_inscription'");
	$sup_parametres = mysql_fetch_array($sup_parametres);
	$modif_parametres = mysql_query("SELECT valeur FROM generale WHERE nom='modif_inscription'");
	$modif_parametres = mysql_fetch_array($modif_parametres);
?>
<html>
<head>
<script type="text/javascript">
		function OpenBooking_editer(id) {
			window.open("imprimer_inscription.php?id_inscription=" + id, "imprimer", "resizable = yes, scrollbars = yes,location=no, status=no, menubar=no, width=930, height=850, left=" + (screen.width-930)/2 + ", top=0");
		}
		function OpenBooking_sup(id,saison) {
			window.open("act_sup_inscriptions.php?id_inscription=" + id + "&saison=" + saison + "&page=consulter_inscriptions", "sup_inscription", "resizable = no, scrollbars = no,location=no, status=no, menubar=no, width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_modif(id) {
			window.open("act_modif_inscriptions.php?id_inscription=" + id + "&page=consulter_inscriptions", "sup_inscription", "resizable = yes, scrollbars = yes,location=no, status=no, menubar=no, width=1100, height=750, left=" + (screen.width-1100)/2 + ", top=" + (screen.height-750)/2);
		}
		function OpenFacture(id) {
			window.open("imprimer_facture.php?id_inscription=" + id, "Facture", "resizable = yes, scrollbars = yes,location=no, status=no, menubar=no, width=1100, height=750, left=" + (screen.width-1100)/2 + ", top=" + (screen.height-750)/2);
		}
		function PrintList(saison) {
			window.open("liste_adherents.php?saison=" + saison, "Liste des adhérents", "resizable = yes, scrollbars = yes,location=no, status=no, menubar=no, width=1100, height=750, left=" + (screen.width-1100)/2 + ", top=" + (screen.height-750)/2);
		}
</script>
</head>
<body>
<center>
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
<?php
	$cmd = "<button onClick=\"PrintList('".$saison."')\" title=\"Imprimer la liste\">Imprimer la liste</button>";
	$log->trace("Commande = ".$cmd);
	echo $cmd;
?>
<center><br>
<table class="table4" summary="">
<th>Nom</th>
<th>Pr&eacute;nom</th>
<th>feuille N° </th>
<th>Inscription</th>
<?php

	$variable = 0;
	$membre = mysql_query("SELECT id, nom, prenom FROM membres WHERE actif = '1' ORDER BY nom");
	while($boucle_membre = mysql_fetch_array($membre)){
		
		$id_membre = $boucle_membre['id'];
		$inscription = mysql_query("SELECT id, id_membre FROM inscriptions WHERE id_membre = '$id_membre' AND saison = '$saison' AND actif = '1'");
		$inscription = mysql_fetch_array($inscription);
		if($inscription['id_membre'] == $id_membre){
			if($variable%2){
				$couleur = $couleur_01['valeur'];
			} else {
				$couleur = $couleur_02['valeur'];
			}
			$variable++;
			echo "<tr style=background:".$couleur."><td>".$boucle_membre['nom']."</td><td>".$boucle_membre['prenom']."</td><td align=center>".$inscription['id']."</td><td><button onClick=\"OpenBooking_editer(".$inscription['id'].")\" title=\"La feuille d'inscription\">Editer</button>";
			
			if ($sup_parametres['valeur'] == "OUI"){
				echo "&nbsp;<button onClick=\"OpenBooking_sup(".$inscription['id'].",'".str_replace("/","_","$saison")."')\" title=\"La feuille d'inscription\">Supprimer</button>"; 
			}
			if ($modif_parametres['valeur'] == "OUI"){
				echo "&nbsp;<button onClick=\"OpenBooking_modif(".$inscription['id'].")\" title=\"La feuille d'inscription\">Modifier</button>"; 
			}
			echo "&nbsp;<button onClick=\"OpenFacture(".$inscription['id'].")\" title=\"Facture\">Facture</button>"; 
			echo "</td></tr>";
		}
	} 
?>
</table></center></fieldset></td></tr><tr height=20><td></td></tr>
<?php }}
if($saison == ""){
echo "Aucune réservation n'est enregistrée dans la base.";
}
?>
</table>
</center>
</body>
</html>