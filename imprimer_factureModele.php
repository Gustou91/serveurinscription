<?php 
	//onload="window.print()"
	include "restrict/config1.php";
	include("phpToPDF.php");
	
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'ansi' );
	
	$margeH = 15;
	
	$PDF = new phpToPDF();
	$PDF->AddPage();


	$PDF->SetFont('Arial','B',18);
	$PDF->Write($margeH,'Association '); 
	$PDF->SetFont('');
	
	$PDF->Write($margeH,'"USM – JU JIT SO"');
	$PDF->SetFontSize(12);
	$PDF->Cell(150,$margeH,'Facture n° :  2016 - 001   ',0,1,'C');
	$PDF->Cell(333,1,'Date         :  15/09/2016',0,1,'C');
	$PDF->Write(10,"1 Avenue Charles de Gaulle \n");
	$PDF->Write(1,"91630 Marolles-en-Hurepoix \n");
	$PDF->Write(15,"06.08.88.07.07  -  marollesjudo@gmail.com \n");
	
	$PDF->SetFont('Arial','BI',20);
	$PDF->SetFillColor(113, 163, 15);
	$PDF->SetTextColor(255, 255, 255);
	$PDF->Cell(190, 10,"F a c t u r e  \n\n",0,1,'R', true);
	
	$PDF->SetFont('Arial','B',14);
	$PDF->SetTextColor(0, 0, 0);
	//$PDF->Cell(10, 10, "David ANACLET", 0, 'L');
	$PDF->Cell(110,20);
	$PDF->Write(15, "David ANACLET\n");
	$PDF->SetFont('Arial','',12);
	$PDF->Cell(110,5);
	$PDF->MultiCell(80, 5, "24 bis Grande Rue\n91630 LEUDEVILLE\n\n\n", 0, "L", 0);
	

	
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
	$contenuTableau = array(
		"[C]1", "Licence FFJDA", "[R]37 ", "[R]37 ",
		"[C]1", "Ecusson section JU JIT SO", "[R]5 ", "[R]5 ",
		"[C]1", "Cotisation adhésion annuelle", "[R]30 ", "[R]30 ",
		"[C]1", "Cours Adultes/Ado Judo/Jujitsu", "[R]163 ", "[R]163 ",
		"[C]1", "Passeport", "[R]8 ", "[R]8 ",
	);
	
	$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);

	$PDF->Write(5, "\n");
	$PDF->Write(5, "Facture en euros. Tva non applicable\n");
	$PDF->Write(3, "Réglée par chèque n° 6448079\n");
	
	$PDF->Cell(130);
	$PDF->Write(5, "Total H.T.");
	$PDF->Cell(27);
	$PDF->Write(5, "243,00 €\n\n");
	$PDF->Cell(130);
	$PDF->SetFont('Arial','B',10);
	$PDF->Write(5, "Total TTC");
	$PDF->Cell(27);
	$PDF->Write(5, "243,00 €\n");
	$PDF->Write(15, " \n\n\n");
	
	$PDF->SetFont('Arial','',10);
	$PDF->Write(5, "Conditions de paiement : paiement à réception de facture\n");
	$PDF->Write(5, "Aucun escompte consenti pour règlement anticipé\n");
	$PDF->Write(5, "Tout incident de paiement est passible d'intérêt de retard. Le montant des pénalités résulte de l'application aux sommes restant dues d'un taux d'intérêt légal en vigueur au moment de l'incident.\n");
	$PDF->Write(5, "Indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement: 40€\n\n\n");
	$PDF->Write(5, "Association Loi 1901 - N° Siren 447 720 699 00027 - Catégorie juridique: 9220 Association déclarée");


	$PDF->Output();
?>