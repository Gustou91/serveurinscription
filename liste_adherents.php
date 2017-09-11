<?php 

	//onload="window.print()"
	include "restrict/config1.php";
	include("phpToPDF.php");
	require_once "includes/log4php/Logger.php";

	Logger::configure('init/config.xml');
	$log = Logger::getLogger('TRACE');
	$logError = Logger::getLogger('ERROR');

	$log->trace("Début Impression liste des adhérents.");
		
		
	// Connexion à la base de données.
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);
	mysql_set_charset( 'ansi' );


	function left($str, $length) {
		 return substr($str, 0, $length);
	}

	function right($str, $length) {
		 return substr($str, -$length);
	}	

	if((isset($_REQUEST["saison"]) && !empty($_REQUEST["saison"]))){
	
		$saison = $_REQUEST["saison"];
		$log->trace("Saison ".$saison);
	
		// Construction de la structure de la liste.

		// Définition des propriétés du tableau.
		$proprietesTableau = array(
			'TB_ALIGN' => 'L',
			'L_MARGIN' => 0,
			'BRD_COLOR' => array(8,39,9),
			'BRD_SIZE' => '0.3',
		);

		// Définition des propriétés du header du tableau.	
		$proprieteHeader = array(
			'T_COLOR' => array(255,255,255),
			'T_SIZE' => 12,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'V_ALIGN' => 'M',
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
			70, 60, 30, 30,
			"[CB]Nom", "[CB]Prénom", "[CB]Date de naissance", "[CB]Tel urgence",
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

		
		// Début de génération de la facture.
		$margeH = 15;
		
		$PDF = new phpToPDF();
		$PDF->AddPage();
		$PDF->SetSubject("Liste des adhérents", true);
		$PDF->startPageNums();

		$PDF->Image('img/LOGO-JUJITSO2.jpg',10,10,20);
		$PDF->Cell(50);
		$PDF->SetFont('Arial','B',18);
		$PDF->Write($margeH,'Association'); 
		$PDF->SetFont('');
		
		$PDF->Write($margeH,'"USM – JU JIT SO"');
		$PDF->Write(12, "\n\n");
		
		
		
		
		// Récupération de l'ensemble des cours proposés.
		$req = "SELECT cou.id as id, cou.nom as nom, cou.obs as obs "
				."FROM cours cou "
				."WHERE cou.actif = 1 AND cou.id in (1, 2, 3, 4, 6, 7, 8, 21, 22)"
				."ORDER BY cou.nom;";
				
		$listCours = mysql_query($req);
			
		if (!$listCours) {
			$log->trace("Aucun cours trouvé.");
			$log->trace(mysql_error());
			die('Aucun cours trouvé.');
		}
		
		$nbcours = mysql_num_rows($listCours);
		$nocours = 1;
		$log->trace("Nombre de cours = ".$nbcours);
		
		// Boucle sur les cours trouvés.
		while ($rowCours = mysql_fetch_assoc($listCours)) {
			
			$log->trace("Cours ".$nocours);
			$contenuTableau = array();
			
			
			// Récupération de la liste des membres pour le cours courant.
			$req = "SELECT mem.id as memId, mem.nom as nom, mem.prenom as prenom, mem.jj, mem.mm, mem.aaaa, tel_urg as telUrg "
			."FROM membres mem LEFT JOIN inscriptions ins on mem.id = ins.id_membre "
			."LEFT JOIN inscriptions_cours ico on ins.id = ico.id_inscriptions "
			."WHERE ico.id_cours = '".$rowCours['id']."' AND ins.saison = '".$saison."' AND mem.actif = 1 and ins.actif = 1 and ico.actif = 1 "
			."ORDER BY mem.nom, mem.prenom;";
			$log->trace("Req = ".$req);
			
			$listMembres = mysql_query($req);
			
			if (!$listMembres) {
				$log->trace("Aucun membre trouvé.");
				$log->trace(mysql_error());
				//die('Aucun membre trouvé.');
				$nocours ++;
				continue;
			}

			if (mysql_num_rows($listMembres) > 0) {
				
							
				// Gestion du saut de page.
				$log->trace("Cours ".$nocours."/".$nbcours);
				if ($nocours != 1) {
					$log->trace("Ajout d'un saut de page.");
					$PDF->AddPage();
				}
				
				$PDF->SetFont('Arial','B',14);
				$PDF->Cell(0, 10, "Cours ".$rowCours['nom']." (".mysql_num_rows($listMembres)." membres)", 1, 1, "C", false);
				$PDF->SetFont('');
				$PDF->ln();
				
				// Boucle sur les cours trouvés.
				while ($rowMembres = mysql_fetch_assoc($listMembres)) {
					
					$telurg = left( $rowMembres['telUrg'], 2)."."
								.substr($rowMembres['telUrg'], 2, 2)."."
								.substr($rowMembres['telUrg'], 4, 2)."."
								.substr($rowMembres['telUrg'], 6, 2)."."
								.substr($rowMembres['telUrg'], 8, 2);
					$datnaiss = right("0".$rowMembres['jj'], 2)."/".right("0".$rowMembres['mm'], 2)."/".$rowMembres['aaaa'];
					$log->trace("Membre = ".$rowMembres['nom']." ".$rowMembres['prenom']." ".$datnaiss." ".$telurg);
					array_push($contenuTableau, 
						$rowMembres['nom'], 
						$rowMembres['prenom'], 
						"[C]".$datnaiss, 
						"[C]".$telurg);
					
				}
				mysql_free_result($listMembres);
				
				// Ecriture de la liste pour le cours courant.
				$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);
			
				$nocours ++;
			} else {
				$nbcours --;
			}

		}
		mysql_free_result($listCours);
		
		$PDF->Output("ListeDesAdhérents-Saison_".str_replace("/","-",$saison).".pdf",'I');
		
	} else die('Précisez la saison.');
?>