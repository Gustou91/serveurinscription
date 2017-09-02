<?php

	include "restrict/config1.php";
	require_once "includes/log4php/Logger.php";
	require_once "includes/lib.inc";

	Logger::configure('init/config.xml');
	$log = Logger::getLogger('TRACE');
	$logError = Logger::getLogger('ERROR');

	$log->trace("Début annule inscription.");

	// Connexion à la base de données.
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);
	mysql_set_charset( 'ansi' );
	
	
	if((isset($_REQUEST["id_inscription"]) && !empty($_REQUEST["id_inscription"]))){
		
		$id_inscription = $_REQUEST["id_inscription"]; 
		
		// Requête des récupération des informations sur l'inscription et le membre inscrit.
		$req = "SELECT ins.id, ins.date, ins.id_membre, ins.total as Total, ins.saison, mbr.nom as Nom, "
				."mbr.prenom as Prenom, mbr.adresse as Adresse, mbr.cp as cp, mbr.ville as Ville, mbr.mail, "
				."p1_num as numChq1, p2_num as numChq2, p3_num as numChq3, p4_num as numChq4 "
				."FROM inscriptions ins left join membres mbr on ins.id_membre = mbr.id "
				."where ins.id = '$id_inscription';";
				
		$inscription = mysql_query($req);
		
		if (!$inscription) {
			$log->trace("Inscription $id_inscription non trouvée.");
			$log->trace(mysql_error());
			die('Inscription non trouvée.');
		}
		
		// Chargement des données et libération de la requête.
		$ins = mysql_fetch_array($inscription);
		
		$nom     = $ins['Prenom']." ".$ins['Nom'];
		$adresse = $ins['Adresse']."\n".$ins['cp']." ".$ins['Ville'];
		$total   = $ins['Total'];
		$lstChq  = $ins['numChq1'];
		if ($ins['numChq2'] > 0) $lstChq = $lstChq.", ".$ins['numChq2'];
		if ($ins['numChq3'] > 0) $lstChq = $lstChq.", ".$ins['numChq3'];
		if ($ins['numChq4'] > 0) $lstChq = $lstChq.", ".$ins['numChq4'];
		mysql_free_result($inscription);
		
		// Requête de récupération de l'ensemble des cours inscrits.
		$req = "SELECT cou.nom as Cours, ins.prix as Prix "
			  ."FROM inscriptions_cours ins left join cours cou on ins.id_cours = cou.id "
			  ."where ins.id_inscriptions = '$id_inscription' and ins.actif = 1;";
	
		$listCours = mysql_query($req);
		
		if (!$listCours) {
			$log->trace("Cours pour inscription $id_inscription non trouvés.");
			$log->trace(mysql_error());
			die('Cours non trouvée.');
		}
		
		// Récupération des données.
		$contenuTableau = array();
		while ($row = mysql_fetch_assoc($listCours)) {
			
			array_push($contenuTableau, $row['Cours'], $row['Prix'], $row['Prix']);
			
		}
		mysql_free_result($listCours);		
		
		
		
		// Requête de récupération de l'ensemble des frais.
		$req = "SELECT frs.nom as Frais, ins.prix as Prix "
			  ."FROM inscriptions_frais ins left join frais frs on ins.id_frais = frs.id "
			  ."where ins.id_inscriptions = '$id_inscription' and ins.actif = 1;";
	
		$listFrais = mysql_query($req);
		
		if (!$listFrais) {
			
			// Pas de frais.
			$log->trace("Frais pour inscription $id_inscription non trouvés.");
			$log->trace(mysql_error());
			die('Frais non trouvée.');
			
		} else {
		
			// Récupération des données.
			while ($row = mysql_fetch_assoc($listFrais)) {
				
				array_push($contenuTableau, $row['Frais'], $row['Prix'], "0.00");
				
			}
		}
		mysql_free_result($listFrais);
		
		
		// Requête de récupération de l'ensemble des frais.
		$req = "SELECT act.nom as Activite, ins.prix as Prix "
			  ."FROM inscriptions_tarifs_activites ins left join tarifs_activites act on ins.id_tarifs_activites = act.id "
			  ."where ins.id_inscriptions = '$id_inscription' and ins.actif = 1;";
	
		$listActivite = mysql_query($req);
		
		if (!$listActivite) {
			
			// Pas d'activité.
			$log->trace("Activité pour inscription $id_inscription non trouvés.");
			$log->trace(mysql_error());
			
		} else {		
		
			// Récupération des données.
			while ($row = mysql_fetch_assoc($listActivite)) {
				
				array_push($contenuTableau, $row['Activite'], $row['Prix'], "0.00");
				
			}
			
		}
		mysql_free_result($listActivite);		
		
		
	}

 ?>
 
 
<html>
	<head>
		<title>USM</title>
		<link rel="stylesheet" href="vendor\bootstrap-3.3.6\dist\css\bootstrap.min.css">
		<link rel="stylesheet" href="vendor\bootstrap-3.3.6\dist\css\bootstrap-theme.min.css">
	</head>
	<body>	
		<?php
		echo("<b>Inscription: </b>".$id_inscription);
		echo("<br><b>Nom: </b>".$nom);
		echo("<br>");
		?>
		<form>
		<table class="table table-inverse" summary="">
			<thead>
				<th>Item</th>
				<th>Montant payé</th>
				<th>Montant remboursé</th>
			</thead>
			<tbody>
				<?php
					$i = 1;
					foreach( $contenuTableau as $data ){

						if ($i == 1) {
							echo("<tr><td>".$data."</td>");
						}
					
						if ($i == 2) {
							echo("<td>".$data."</td>");
						}
					
						if ($i == 3) {
							echo("<td><div class=\"col-5\"><input class=\"form-control\" type=\"text\" value=\"".$data."\" ></div></td></tr>");
							$i = 0;
						}
						$i++;
					}
				?>			
			</tbody>
		</table>
		</form>
	
	</body>
	<script src="vendor\bootstrap-3.3.6\js\tests\vendor\jquery.min.js"></script>
	<script src="vendor\bootstrap-3.3.6\dist\js\bootstrap.min.js"></script>
</html>