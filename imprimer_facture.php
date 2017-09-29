<?php 
	//onload="window.print()"
	include "restrict/config1.php";
	include("phpToPDF.php");
	require_once "includes/log4php/Logger.php";

	Logger::configure('init/config.xml');
	$log = Logger::getLogger('TRACE');
	$logError = Logger::getLogger('ERROR');

	$log->trace("Début générateur de facture.");
		
		
	// Connexion à la base de données.
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);
	mysql_set_charset( 'ansi' );
	
	
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
	
	
	if((isset($_REQUEST["id_inscription"]) && !empty($_REQUEST["id_inscription"]))){
	
		$id_inscription = $_REQUEST["id_inscription"];
	
		// Requête des récupération des informations sur l'inscription et le membre inscrit.
		$req = "SELECT ins.id, ins.date, ins.id_membre, ins.total as Total, ins.saison, mbr.nom as Nom, "
				."mbr.prenom as Prenom, mbr.adresse as Adresse, mbr.cp as cp, vil.ville as Ville, mbr.mail, "
				."p1_num as numChq1, p2_num as numChq2, p3_num as numChq3, p4_num as numChq4 "
				."FROM inscriptions ins left join membres mbr on ins.id_membre = mbr.id "
				."left join villes vil on mbr.ville = vil.id "
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

	
		// Récupération du numéro de facture.
		$log->trace("Recherche de la facture pour l'inscription ".$id_inscription);
		$facture = getFacture($id_inscription);
		$Fact = split(",", $facture);
		$numFact = $Fact[0];
		$datFact = $Fact[1];
		
		
		$log->trace("Numéro de facture: ".$numFact);
		
		if ($numFact == "") {

			$log->trace("Facture non touvée.");
		
			// Création d'un nouveau numéo de facture.
			$numFact = createNumFacture();
			$log->trace("Numéro de facture généré = ".$numFact);
			saveFacture($id_inscription, $numFact);
			
		}
	
	
		// Début de génération de la facture.
		$margeH = 15;
		
		$PDF = new phpToPDF();
		$PDF->AddPage();


		$PDF->SetFont('Arial','B',18);
		$PDF->Write($margeH,'Association '); 
		$PDF->SetFont('');
		
		$PDF->Write($margeH,'"USM – JU JIT SO"');
		$PDF->SetFontSize(12); //$numFact
		//$PDF->Cell(150,$margeH,'Facture n° :  2016-001   ',0,1,'C');
		$PDF->Cell(150,$margeH,"Facture n° :  ".$numFact."   ",0,1,'C');
		//$PDF->Cell(333,1,'Date         :  15/09/2016',0,1,'C');
		$PDF->Cell(333,1,"Date         :  ".$datFact,0,1,'C');
		$PDF->Write(10,"1 Avenue Charles de Gaulle \n");
		$PDF->Write(1,"91630 Marolles-en-Hurepoix \n");
		$PDF->Write(15,"06.08.88.07.07  -  marollesjudo@gmail.com \n");
		
		$PDF->SetFont('Arial','BI',20);
		$PDF->SetFillColor(113, 163, 15);
		$PDF->SetTextColor(255, 255, 255);
		$PDF->Cell(190, 10,"F a c t u r e  \n\n",0,1,'R', true);
		
		$PDF->SetFont('Arial','B',14);
		$PDF->SetTextColor(0, 0, 0);
		$PDF->Cell(110,20);
		$PDF->Write(15, $nom."\n");
		$PDF->SetFont('Arial','',12);
		$PDF->Cell(110,5);
		$PDF->MultiCell(80, 5, $adresse."\n\n\n", 0, "L", 0);
		//$PDF->MultiCell(80, 5, "24 bis Grande Rue\n91630 LEUDEVILLE\n\n\n", 0, "L", 0);
		

		
		// Définition des propriétés du tableau.
		$proprietesTableau = array(
			'TB_ALIGN' => 'L',
			'L_MARGIN' => 0,
			'BRD_COLOR' => array(8,39,9),
			'BRD_SIZE' => '0.3',
		);
		
		// Définition des propriétés du header du tableau.	
		$proprieteHeader = array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 12,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'V_ALIGN' => 'T',
			'T_TYPE' => 'B',
			'LN_SIZE' => 6,
			'BG_COLOR_COL0' => array(113, 163, 15),
			'BG_COLOR' => array(113, 163, 15),
			'BRD_COLOR' => array(8,39,9),
			'BRD_SIZE' => 0.2,
			'BRD_TYPE' => '1',
			'BRD_TYPE_NEW_PAGE' => '',
		);
		
		// Contenu du header du tableau.	
		$contenuHeader = array(
			20, 90, 40, 40,
			"[CB]Quantité", "[CB]Désignation", "[CB]Prix unitaire HT", "[CB]Prix total HT",
		);
		
		// Définition des propriétés du reste du contenu du tableau.	
		$proprieteContenu = array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 10,
			'T_FONT' => 'Arial',
			'T_ALIGN_COL0' => 'L',
			'T_ALIGN' => 'R',
			'V_ALIGN' => 'M',
			'T_TYPE' => '',
			'LN_SIZE' => 12,
			'BG_COLOR_COL0' => array(245, 245, 150),
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(8,39,9),
			'BRD_SIZE' => 0.1,
			'BRD_TYPE' => '1',
			'BRD_TYPE_NEW_PAGE' => '',
		);
		
		// Contenu du tableau.	
		/*$contenuTableau = array(
			"[C]1", "Licence FFJDA", "[R]37 ", "[R]37 ",
			"[C]1", "Ecusson section JU JIT SO", "[R]5 ", "[R]5 ",
			"[C]1", "Cotisation adhésion annuelle", "[R]30 ", "[R]30 ",
			"[C]1", "Cours Adultes/Ado Judo/Jujitsu", "[R]163 ", "[R]163 ",
			"[C]1", "Passeport", "[R]8 ", "[R]8 ",
		);*/

		// Requête de récupération de l'ensemble des cours inscrits.
		$req = "SELECT cou.nom as Cours, ins.prix as Prix "
			  ."FROM inscriptions_cours ins left join cours cou on ins.id_cours = cou.id "
			  ."where ins.id_inscriptions = '$id_inscription' and ins.actif = 1;";
	
		$listCours = mysql_query($req);
		
		if (!$listCours) {
			$log->trace("Cours pour inscription $id_inscription non trouvés.");
			$log->trace(mysql_error());
			die('Cours non trouvé.');
		}
		
		// Récupération des données.
		$contenuTableau = array();
		while ($row = mysql_fetch_assoc($listCours)) {
			
			array_push($contenuTableau, "[C]1", $row['Cours'], "[R]".$row['Prix']." ", "[R]".$row['Prix']." ");
			
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
				
				array_push($contenuTableau, "[C]1", $row['Frais'], "[R]".$row['Prix']." ", "[R]".$row['Prix']." ");
				
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
				
				array_push($contenuTableau, "[C]1", $row['Activite'], "[R]".$row['Prix']." ", "[R]".$row['Prix']." ");
				
			}
			
		}
		mysql_free_result($listActivite);

				
		$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);

		
		
		$PDF->Write(5, "\n");
		$PDF->Write(5, "Facture en euros. Tva non applicable\n");
		//$PDF->Write(3, "Réglée par chèque n° 6448079\n");
		$PDF->Write(3, "Réglée par chèque(s) n° ".$lstChq."\n");

		
		$PDF->Cell(130);
		$PDF->Write(5, "Total H.T.");
		$PDF->Cell(27);
		$PDF->Write(5, $total." €\n\n");
		$PDF->Cell(130);
		$PDF->SetFont('Arial','B',10);
		$PDF->Write(5, "Total TTC");
		$PDF->Cell(27);
		$PDF->Write(5, $total." €\n");
		$PDF->Write(15, " \n\n\n");
		
		$PDF->SetFont('Arial','',10);
		$PDF->Write(5, "Conditions de paiement : paiement à réception de facture\n");
		$PDF->Write(5, "Aucun escompte consenti pour règlement anticipé\n");
		$PDF->Write(5, "Tout incident de paiement est passible d'intérêt de retard. Le montant des pénalités résulte de l'application aux sommes restant dues d'un taux d'intérêt légal en vigueur au moment de l'incident.\n");
		$PDF->Write(5, "Indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement: 40€\n\n\n");
		$PDF->Write(5, "Association Loi 1901 - N° Siren 447 720 699 00027 - Catégorie juridique: 9220 Association déclarée");


		//$PDF->Output();
		$PDF->Output("FACT-".$numFact."_".str_replace(" ","_",$nom).".pdf",'I');

	}

?>