<?php include "restrict/config.php";?>

<html>
<head>
<title>USM</title>
</head>
<script type="text/javascript">
		function print(id) {
			window.open("imprimer_inscription.php?id_inscription=" + id, "imprimer", "resizable = yes, scrollbars = yes, location=no, status=no, menubar=no, width=925, height=850, left=" + (screen.width-925)/2 + ", top=0");
		}
		
</script>
<?php

	function setVar($data, $default) {
		return ( isset($data]) && !empty($data]) ? $data : $default;
	}
	


	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'utf8' );

	$id_membre = $_POST["id_membre"];
	$total = $_POST["total"];
	if(isset($_POST["prix_caution"])){
		$prix_caution = $_POST["prix_caution"];
	}else{
		$prix_caution="";
	}
	$passeport = $_POST["passeport"];
	if($passeport == "OUI"){
		$passeport = 1;
	}else{
		$passeport = 0;
	}
	$photo = $_POST["photo"];
	if($photo == "OUI"){
		$photo = 1;
	}else{
		$photo = 0;
	}
	$certificat = $_POST["certificat"];
	if($certificat=="OUI"){
		$certificat_jj = $_POST["certificat_jj"];
		$certificat_mm = $_POST["certificat_mm"];
		$certificat_aaaa = $_POST["certificat_aaaa"];
	}
	else{
		$certificat_jj = 0;
		$certificat_mm = 0;
		$certificat_aaaa = 0;
	}
	$caution = $_POST["caution"];
	if($caution == "cheque"){
		$caution_num = $_POST["caution_num"];
		$caution_banque = $_POST["caution_banque"];
	}else{
		$caution_num = 0;
		$caution_banque = "";
	}
	$trimestre = $_POST["trimestre"];
	$espece = $_POST["espece"];
	if ($espece == "1"){
		$p1_num = 0;
		$p2_num = 0;
		$p3_num = 0;
		$p4_num = 0;
		$p1_prix = 0;
		$p2_prix = 0;
		$p3_prix = 0;
		$p4_prix = 0;
		$p1_banque = "";
		$p2_banque = "";
		$p3_banque = "";
		$p4_banque = "";
	}else{
		$p1_num = setVar($_POST["p1_num"], 0);
		$p2_num = setVar($_POST["p2_num"], 0);
		$p3_num = setVar($_POST["p3_num"], 0);
		$p4_num = setVar($_POST["p4_num"], 0);
		$p1_prix = setVar($_POST["p1_prix"], 0");
		$p2_prix = setVar($_POST["p2_prix"], 0);
		$p3_prix = setVar($_POST["p3_prix"], 0);
		$p4_prix = setVar($_POST["p4_prix"], 0);
		$p1_banque = setVar($_POST["p1_banque"], "");
		$p2_banque = setVar($_POST["p2_banque"], "");
		$p3_banque = setVar($_POST["p3_banque"], "");
		$p4_banque = setVar($_POST["p4_banque"], "");
		$p1_date = setVar($_POST["p1_date"], "");
		$p2_date = setVar($_POST["p2_date"], "");
		$p3_date = setVar($_POST["p3_date"], "");
		$p4_date = setVar($_POST["p4_date"], "");
		
		//$p1_num = (	isset($_POST["p1_num"]) && !empty($_POST["p1_num"]) ? $_POST["p1_num"] : "";
	}
	if(isset($_POST["reduc"])){
		$reduc = $_POST["reduc"];
	}else{
		$reduc="";
	}
	$reduc_manu = $_POST["reduc_manu"];
	$saison = $_POST["saison"];
	$obs = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['obs'])));

	$inscription = mysql_query("SELECT * FROM inscriptions WHERE id_membre = '$id_membre' AND saison = '$saison' AND actif = '1'");
	$inscription = mysql_fetch_array($inscription);

	if(($inscription['id_membre']) != $id_membre){

		// Enregistrement de l'inscription.
		mysql_query("INSERT INTO inscriptions VALUES(NULL, NOW( ), '$id_membre', '$total', '$passeport', '$photo', '$certificat', '$certificat_jj', '$certificat_mm', '$certificat_aaaa', '$caution', '$caution_num', '$caution_banque', '$prix_caution', '$trimestre', '$p1_num', '$p1_banque', '$p1_date', '$p1_prix', '$p2_num', '$p2_banque', '$p2_date', '$p2_prix', '$p3_num', '$p3_banque','$p3_date', '$p3_prix', '$p4_num', '$p4_banque', '$p4_date', '$p4_prix', '$espece', '$reduc', '$reduc_manu', '$saison', '$obs', '1')")or die(mysql_error());
		$id_inscription = mysql_insert_id();

		$nb_activite = $_POST["nb_activite"];
		for($i=1;$i<=$nb_activite;$i++){
			$tarif_activite = "activite_".$i;
			$id_tarif_activite = $_POST[$tarif_activite];
			$tarif_activite = mysql_query("SELECT * FROM tarifs_activites WHERE id = '$id_tarif_activite'");
			$tarif_activite = mysql_fetch_array($tarif_activite);
			$prix = $tarif_activite['prix'];
			mysql_query("INSERT INTO inscriptions_tarifs_activites VALUES(NULL, NOW( ), '$id_inscription', '$id_tarif_activite', '$prix', '1')")or die(mysql_error());
		}

		// Enregistrement des cours pris.
		$nb_cours = $_POST["nb_cours"];
		for($i=1;$i<=$nb_cours;$i++){
			$cours = "cours_".$i;
			$id_cours = $_POST[$cours];
			$cours = mysql_query("SELECT * FROM cours WHERE id = '$id_cours'");
			$cours = mysql_fetch_array($cours);
			$prix = $cours['prix'];
			mysql_query("INSERT INTO inscriptions_cours VALUES(NULL, NOW( ), '$id_inscription', '$id_cours', '$prix', '1')")or die(mysql_error());
		}

		// Enregistrement des frais.
		$nb_frais = $_POST["nb_frais"];
		for($i=1;$i<=$nb_frais;$i++){
			$frais = "frais_".$i;
			$id_frais = $_POST[$frais];
			$frais = mysql_query("SELECT * FROM frais WHERE id = '$id_frais'");
			$frais = mysql_fetch_array($frais);
			$prix = $frais['prix'];
			mysql_query("INSERT INTO inscriptions_frais VALUES(NULL, NOW( ), '$id_inscription', '$id_frais', '$prix', '1')")or die(mysql_error());
		}

		// Enregistrement des grades.
		$nb_grade = $_POST["nb_grade"];
		for($i=1;$i<=$nb_grade;$i++){
			$grade = "grade_".$i;
			$id_grade = $_POST[$grade];
			mysql_query("INSERT INTO inscriptions_grades VALUES(NULL, NOW( ), '$id_inscription', '$id_grade', '1')")or die(mysql_error());
		}
?>
<body style="text-align:center" onload="print(<?php echo $id_inscription; ?>)">
<center>
<br><br><br><br><b>Enregistrement r&eacute;ussi</b><br><br>
<input type="button" value="Imprimer" onclick="print(<?php echo $id_inscription; ?>)"><br>
Pour information : Ctrl + p, ouvre la fen&egrave;tre d'impression de la page en cours
<?php
}else{
$nom=$_POST["nom"];
$prenom=$_POST["prenom"];
?>
<body style="text-align:center">
<center>
<br><br><br><br><b>L'enregistrement n'a pas abouti,<br>car le membre <?php echo $nom." ".$prenom; ?> est déjà inscrit pour cette saison : <?php echo $saison; ?></b><br><br>
<?php
}
?>
</center>
</body>
</html>