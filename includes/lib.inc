<?php
	// R�cup�re le num�ro de commande.
	// Si la commande n'existe pas, elle est cr��e.
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
			
			$log->trace("Erreur sur la requ�te.");
			$log->trace(mysql_error());
						
		} else {
			
			$fact = mysql_fetch_array($facture);
			if ($fact['Numero'] != "") {
				
				$log->trace("Facture trouv�e pour l'inscription $idInscription.");
				$numFact = $fact['Numero'];
				$datFact = $fact['Date'];
				$log->trace("Facture: ".$numFact." - ".$datFact);
				
			} else {
				
				$log->trace("Facture non trouv�e pour l'inscription $idInscription.");
				
			}
			mysql_free_result($facture);			
		}
		

		
		return $numFact.",".$datFact;
	}
	
	
	// G�n�re un num�ro de facture.
	// AAAA = Ann�e en cours.
	// NNNN = Nombre de facture sur l'ann�e en cours + 1
	// N� facture = AAAA - NNNN
	function createNumFacture() {
		
		Logger::configure('init/config.xml');
		$log = Logger::getLogger('TRACE');
		$logError = Logger::getLogger('ERROR');
		
		$numFact = "9999-9999";
		$log->trace("Num�ro par d�faut = ".$numFact);

		$datRef = new DateTime(date("Y").'-01-01');
		$datRefS = date_format($datRef, 'd/m/Y');

		
		$req = "SELECT count(*) as NbFact "
			."FROM factures "
			."WHERE DATE(date_Facture) >= '$datRefS';";
		$log->trace("req = ".$req);
		
		$nbFactures = mysql_query($req);
		if (!$nbFactures) {
			$log->trace("Erreur sur la requ�te ".$req);
			$log->trace(mysql_error());
			die('Erreur SQL.');
		}
	
		// Chargement des donn�es et lib�ration de la requ�te.
		$nbFact = mysql_fetch_array($nbFactures);
		$nb = $nbFact['NbFact'];
		mysql_free_result($nbFactures);
		
		$log->trace("Nombre de facture dans l'ann�e: ".$nb);
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
			$log->trace("Facture cr��e.");
		}
		
	}

?>