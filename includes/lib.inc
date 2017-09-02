<?php
	// Récupère le numéro de commande.
	// Si la commande n'existe pas, elle est créée.
	function getFacture($idInscription) {
		
		Logger::configure('init/config.xml');
		$log = Logger::getLogger('TRACE');
		$logError = Logger::getLogger('ERROR');
		
		$numFact = "";
		$datFact = date('d/m/Y');
		
		$req = "SELECT numero as Numero, DATE_FORMAT(date_Facture, '%d/%m/%Y') as Date "
				."FROM factures "
				."WHERE id_inscription = '$idInscription';";
		$log->trace("Req = ".$req);
		
		$facture = mysql_query($req);
		
		if (!$facture) {
			
			$log->trace("Erreur sur la requête.");
			$log->trace(mysql_error());
						
		} else {
			
			$fact = mysql_fetch_array($facture);
			if ($fact['Numero'] != "") {
				
				$log->trace("Facture trouvée pour l'inscription $idInscription.");
				$numFact = $fact['Numero'];
				$datFact = $fact['Date'];
				$log->trace("Facture: ".$numFact." - ".$datFact);
				
			} else {
				
				$log->trace("Facture non trouvée pour l'inscription $idInscription.");
				
			}
			mysql_free_result($facture);			
		}
		

		
		return $numFact.",".$datFact;
	}
	
	
	// Génère un numéro de facture.
	// AAAA = Année en cours.
	// NNNN = Nombre de facture sur l'année en cours + 1
	// N° facture = AAAA - NNNN
	function createNumFacture() {
		
		Logger::configure('init/config.xml');
		$log = Logger::getLogger('TRACE');
		$logError = Logger::getLogger('ERROR');
		
		$numFact = "9999-9999";
		$log->trace("Numéro par défaut = ".$numFact);

		$datRef = new DateTime(date("Y").'-01-01');
		$datRefS = date_format($datRef, 'd/m/Y');

		
		$req = "SELECT count(*) as NbFact "
			."FROM factures "
			."WHERE DATE(date_Facture) >= '$datRefS';";
		$log->trace("req = ".$req);
		
		$nbFactures = mysql_query($req);
		if (!$nbFactures) {
			$log->trace("Erreur sur la requête ".$req);
			$log->trace(mysql_error());
			die('Erreur SQL.');
		}
	
		// Chargement des données et libération de la requête.
		$nbFact = mysql_fetch_array($nbFactures);
		$nb = $nbFact['NbFact'];
		mysql_free_result($nbFactures);
		
		$log->trace("Nombre de facture dans l'année: ".$nb);
		$nb ++;
		$date = date('Y');
		$num = substr("0000".$nb, -4);
		$log->trace("Num: ".$num);
		$numFact = $date."-".$num;
		
			//$date = date("Y");

		return $numFact;
		
	}
	
	
	function saveFacture($idInscription, $numFact) {
		
		Logger::configure('init/config.xml');
		$log = Logger::getLogger('TRACE');
		$logError = Logger::getLogger('ERROR');

		$req = "INSERT INTO factures (numero, id_inscription, date_facture) "
				."VALUES ('$numFact', '$idInscription', NOW())";
		
		$log->trace("Req = ".$req);
		if (mysql_query($req) == TRUE) {
			$log->trace("Facture créée.");
		}
		
	}

?>