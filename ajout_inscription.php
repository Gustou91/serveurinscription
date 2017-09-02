<?php include "restrict/config.php";?>
<html>
<head>
<title>USM</title>
</head>
<body style="text-align:center">
<script type="text/javascript">
function Autotab(id, texte, longueur)
{
    if (texte.length > longueur) {
        document.getElementById('id_'+id).focus();
    }
}
function banque(valeur, id)
{
	if (id == 1)
	{
		document.getElementById('banque_2').value=valeur;
		document.getElementById('banque_3').value=valeur;
		document.getElementById('banque_4').value=valeur;
	}else if (id == 2)
	{
		document.getElementById('banque_3').value=valeur;
		document.getElementById('banque_4').value=valeur;
	}else if (id == 3)
	{
		document.getElementById('banque_4').value=valeur;
	}
}
</script>
<center>
<?php

	require_once "includes/log4php/Logger.php";

	Logger::configure('init/config.xml');
	$log = Logger::getLogger('TRACE');
	$logError = Logger::getLogger('ERROR');

	$log->trace("AjoutInscription - Début Ajout inscription.");

	function Liste_deroulante_mois($mois, $num,$modifiable){
		
		setlocale (LC_TIME, 'fr_FR.ansi','fra');
		if($modifiable == "NON"){
			$value = '<select name="p'.$num.'_date" size="1" disabled>';
		}else{
			$value = '<select name="p'.$num.'_date" size="1">';
		}
		for($i = 1; $i <= 12; $i++ ){
			if($i == $mois){
				$value .= '<option value="'.$i.'" Selected>'.ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1, 2000))).'</option>';
			}else{
				$value .= '<option value="'.$i.'">'.ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1, 2000))).'</option>';
			}
		}
		$value .= '</select>';
		return $value;
	}


	function getParam($nomParam) {
		
		Logger::configure('init/config.xml');
		$log = Logger::getLogger('TRACE');
		$logError = Logger::getLogger('ERROR');
		
		$parametres = mysql_query("SELECT * FROM generale WHERE nom='".$nomParam."'");
		
		if (!$parametres) {
			
			$log->trace("getParam: Erreur de chargement du paramètre ".$nomParam);
			return "";
			
		} else {
			
			$parametres = mysql_fetch_array($parametres);
			$log->trace("getParam: Paramètre ".$nomParam." = ".$parametres['valeur']);
			return $parametres['valeur'];
			
		}

	}
	
	
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'ansi' );
	
	if((isset($_GET["id_membre"]) && !empty($_GET["id_membre"]))){
		$selectedMembreId = $_GET["id_membre"];
		$log->trace("AjoutInscription - Id du membre = ".$selectedMembreId);
	} else {
		$selectedMembreId = "";
	}
	if((isset($_GET["nb_trimestre"]) && !empty($_GET["nb_trimestre"]))){
		$nbTrimestre = $_GET["nb_trimestre"];
		$log->trace("AjoutInscription - Nombre de trimestres = ".$nbTrimestre);
	} else {
		$nbTrimestre = "";
	}
	if((isset($_GET["id_grade"]) && !empty($_GET["id_grade"]))){
		$idGrade = $_GET["id_grade"];
		$log->trace("AjoutInscription - Grade = ".$idGrade);
	} else {
		$idGrade = "";
	}
	if((isset($_GET["list_activite"]) && !empty($_GET["list_activite"]))){
		$listActivite = explode("/", $_GET["list_activite"]);
		$log->trace("AjoutInscription - Liste des activités = ".$_GET["list_activite"]);
	} else {
		$listActivite = array();
		$log->trace("AjoutInscription - Pas d'activités");
	}
	if((isset($_GET["listCours"]) && !empty($_GET["listCours"]))){
		$listCours = explode("/", $_GET["listCours"]);
		$log->trace("AjoutInscription - Liste des cours = ".$_GET["listCours"]);
	} else {
		$listCours = array();
		$log->trace("AjoutInscription - Pas de cours");
	}	
	if((isset($_GET["listFrais"]) && !empty($_GET["listFrais"]))){
		$listFrais = explode("/", $_GET["listFrais"]);
		$log->trace("AjoutInscription - Liste des frais = ".$_GET["listFrais"]);
	} else {
		$listFrais = array();
		$log->trace("AjoutInscription - Pas de frais");
	}	
	if((isset($_GET["passeport"]) && !empty($_GET["passeport"]))){
		$passeport = $_GET["passeport"];
		$log->trace("AjoutInscription - passeport = ".$passeport);
	} else {
		$passeport = "";
		$log->trace("AjoutInscription - Pas d'info passeport");
	}
	if((isset($_GET["photo"]) && !empty($_GET["photo"]))){
		$photo = $_GET["photo"];
		$log->trace("AjoutInscription - photo = ".$photo);
	} else {
		$photo = "";
		$log->trace("AjoutInscription - Pas d'info photo");
	}
	if((isset($_GET["certificat"]) && !empty($_GET["certificat"]))){
		$certificat = $_GET["certificat"];
		$log->trace("AjoutInscription - certificat = ".$certificat);
	} else {
		$certificat = "";
		$log->trace("AjoutInscription - Pas d'info certificat");
	}
	if((isset($_GET["certificat_jj"]) && !empty($_GET["certificat_jj"]))){
		$certificat_jj = $_GET["certificat_jj"];
		$log->trace("AjoutInscription - certificat_jj = ".$certificat_jj);
	} else {
		$certificat_jj = "";
		$log->trace("AjoutInscription - Pas d'info certificat_jj");
	}
	if((isset($_GET["certificat_mm"]) && !empty($_GET["certificat_mm"]))){
		$certificat_mm = $_GET["certificat_mm"];
		$log->trace("AjoutInscription - certificat_mm = ".$certificat_mm);
	} else {
		$certificat_mm = "";
		$log->trace("AjoutInscription - Pas d'info certificat_mm");
	}
	if((isset($_GET["certificat_aaaa"]) && !empty($_GET["certificat_aaaa"]))){
		$certificat_aaaa = $_GET["certificat_aaaa"];
		$log->trace("AjoutInscription - certificat_aaaa = ".$certificat_aaaa);
	} else {
		$certificat_aaaa = date('Y',time());
		$log->trace("AjoutInscription - Pas d'info certificat_aaaa");
	}
	if((isset($_GET["caution"]) && !empty($_GET["caution"]))){
		$caution = $_GET["caution"];
		$log->trace("AjoutInscription - caution = ".$caution);
	} else {
		$caution = "";
		$log->trace("AjoutInscription - Pas d'info caution");
	}	
	if((isset($_GET["caution_num"]) && !empty($_GET["caution_num"]))){
		$caution_num = $_GET["caution_num"];
		$log->trace("AjoutInscription - caution_num = ".$caution_num);
	} else {
		$caution_num = "";
		$log->trace("AjoutInscription - Pas d'info caution_num");
	}
	if((isset($_GET["id_caution_banque"]) && !empty($_GET["id_caution_banque"]))){
		$id_caution_banque = $_GET["id_caution_banque"];
		$log->trace("AjoutInscription - id_caution_banque = ".$id_caution_banque);
	} else {
		$id_caution_banque = "";
		$log->trace("AjoutInscription - Pas d'info id_caution_banque");
	}
	if((isset($_GET["p1_date"]) && !empty($_GET["p1_date"]))){
		$p1_date = $_GET["p1_date"];
		$log->trace("AjoutInscription - p1_date = ".$p1_date);
	} else {		
		$p1_date = getParam("prelevement_1");
		$log->trace("AjoutInscription - Pas d'info p1_date");
	}	
	if((isset($_GET["p1_num"]) && !empty($_GET["p1_num"]))){
		$p1_num = $_GET["p1_num"];
		$log->trace("AjoutInscription - p1_num = ".$p1_num);
	} else {
		$p1_num = "";
		$log->trace("AjoutInscription - Pas d'info p1_num");
	}
	if((isset($_GET["p1_banque"]) && !empty($_GET["p1_banque"]))){
		$p1_banque = $_GET["p1_banque"];
		$log->trace("AjoutInscription - p1_banque = ".$p1_banque);
	} else {
		$p1_banque = "";
		$log->trace("AjoutInscription - Pas d'info p1_banque");
	}
	if((isset($_GET["p2_date"]) && !empty($_GET["p2_date"]))){
		$p2_date = $_GET["p2_date"];
		$log->trace("AjoutInscription - p2_date = ".$p2_date);
	} else {
		$p2_date = getParam("prelevement_2");
		$log->trace("AjoutInscription - Pas d'info p2_date");
	}	
	if((isset($_GET["p2_num"]) && !empty($_GET["p2_num"]))){
		$p2_num = $_GET["p2_num"];
		$log->trace("AjoutInscription - p2_num = ".$p2_num);
	} else {
		$p2_num = "";
		$log->trace("AjoutInscription - Pas d'info p2_num");
	}
	if((isset($_GET["p2_banque"]) && !empty($_GET["p2_banque"]))){
		$p2_banque = $_GET["p2_banque"];
		$log->trace("AjoutInscription - p2_banque = ".$p2_banque);
	} else {
		$p2_banque = "";
		$log->trace("AjoutInscription - Pas d'info p2_banque");
	}	
	if((isset($_GET["p3_date"]) && !empty($_GET["p3_date"]))){
		$p3_date = $_GET["p3_date"];
		$log->trace("AjoutInscription - p3_date = ".$p3_date);
	} else {
		$p3_date = getParam("prelevement_3");
		$log->trace("AjoutInscription - Pas d'info p3_date");
	}	
	if((isset($_GET["p3_num"]) && !empty($_GET["p3_num"]))){
		$p3_num = $_GET["p3_num"];
		$log->trace("AjoutInscription - p3_num = ".$p3_num);
	} else {
		$p3_num = "";
		$log->trace("AjoutInscription - Pas d'info p3_num");
	}
	if((isset($_GET["p3_banque"]) && !empty($_GET["p3_banque"]))){
		$p3_banque = $_GET["p3_banque"];
		$log->trace("AjoutInscription - p3_banque = ".$p3_banque);
	} else {
		$p3_banque = "";
		$log->trace("AjoutInscription - Pas d'info p3_banque");
	}	
	if((isset($_GET["p4_date"]) && !empty($_GET["p4_date"]))){
		$p4_date = $_GET["p4_date"];
		$log->trace("AjoutInscription - p4_date = ".$p4_date);
	} else {
		$p4_date = getParam("prelevement_4");
		$log->trace("AjoutInscription - Pas d'info p4_date");
	}	
	if((isset($_GET["p4_num"]) && !empty($_GET["p4_num"]))){
		$p4_num = $_GET["p4_num"];
		$log->trace("AjoutInscription - p4_num = ".$p4_num);
	} else {
		$p4_num = "";
		$log->trace("AjoutInscription - Pas d'info p4_num");
	}
	if((isset($_GET["p4_banque"]) && !empty($_GET["p4_banque"]))){
		$p4_banque = $_GET["p4_banque"];
		$log->trace("AjoutInscription - p4_banque = ".$p4_banque);
	} else {
		$p4_banque = "";
		$log->trace("AjoutInscription - Pas d'info p4_banque");
	}	
	if((isset($_GET["obs"]) && !empty($_GET["obs"]))){
		$obs = $_GET["obs"];
		$log->trace("AjoutInscription - obs = ".$obs);
	} else {
		$obs = "RAS";
		$log->trace("AjoutInscription - Pas d'info obs");
	}
	
	$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
	$saison = mysql_fetch_array($saison);
	$annee_actu=$annee_actu+$saison[0];
	$annee_suivante=$annee_actu+1;
	echo "FEUILLE D'INSCRIPTION POUR<br>";
	$membre = mysql_query("SELECT id, nom, prenom, aaaa FROM membres WHERE actif = '1' ORDER BY nom");
?>
<form method="post" name="formulaire">
<select size='1' name='id_membre' title="Si membre absent : d&eacute;j&agrave; inscrit pour la saison?">
<option value=0>-- Membres --</option>
<?php
	$saison = $annee_actu."/".$annee_suivante;
	while($boucle_membre = mysql_fetch_array($membre)){
		$id_membre = $boucle_membre['id'];
		$inscription = mysql_query("SELECT id_membre FROM inscriptions WHERE id_membre = '$id_membre' AND saison = '$saison' AND actif = '1'");
		$inscription = mysql_fetch_array($inscription);
		if($inscription['id_membre']!=$id_membre){
			//$log->trace("AjoutInscription - Le membre ".$boucle_membre['id']." ".$boucle_membre['nom']." ".$boucle_membre['prenom']." n'est pas inscrit.");
			if($selectedMembreId == $id_membre){
				$selected = "selected";			
				//$log->trace("AjoutInscription - Le membre ".$boucle_membre['id']." ".$boucle_membre['nom']." ".$boucle_membre['prenom']." est déjà sélectionné.");
			} else {
				$selected = "";
				//$log->trace("AjoutInscription - Le membre ".$boucle_membre['id']." n'est pas déjà sélectionné.");
			}
			echo "<option value=".$boucle_membre['id']." ".$selected."> ".$boucle_membre['nom']." ".$boucle_membre['prenom']." (".(($annee_actu)-($boucle_membre['aaaa']))." ans)</option>";
		}
	}
?>
</select>
<?php
echo "<br><b><font color=red>Saison ".$annee_actu." - ".$annee_suivante."</font></b><br>Etape 1 / 3<br><br>";
$nb_activite=1;
$nb_cours=1;
$nb_frais=1;
$nb_grade=1;

?>

<table border=0>
<tr>
<td>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Activit&eacute;s &nbsp;</b></font></legend>
<?php
	$activites = mysql_query("SELECT * FROM activites WHERE actif = '1' ORDER BY nom");
?>
<table class="table4" summary="">
<?php
	$Nb_POST_grade = 0;
	while($boucle_activite = mysql_fetch_array($activites)){
		$id_activite = $boucle_activite['id'];
		$tarifs_activites = mysql_query("SELECT * FROM tarifs_activites WHERE id_activites = '$id_activite' AND actif = '1' ORDER BY nom");
		$grades = mysql_query("SELECT * FROM grades WHERE id_activites = '$id_activite' AND actif = '1' ORDER BY classement");
		$Nb_POST_grade++;
?>
<tr title="<?php echo "Observations : ".$boucle_activite['obs']; ?>">
<th colspan=3>
<font color=red><?php echo $boucle_activite['nom']; ?></font>
&nbsp;<select size='1' name='grade_<?php echo $Nb_POST_grade; ?>'>
<option value=0>-- grades --</option>
<?php
		while($boucle_grade = mysql_fetch_array($grades)){
			$selected = $idGrade == $boucle_grade['id'] ? "selected" : "";
			echo "<option value=".$boucle_grade['id']." ".$selected.">".$boucle_grade['nom']."</option>";
		}
?>
</select>
</th>
</tr>
<?php
		$nb_grade++;
		
		
		while($boucle_tarif_activite = mysql_fetch_array($tarifs_activites)){
			
			//$log->trace("AjoutInscription - Tarif activité: ".$boucle_tarif_activite['id']);
			//$log->trace("AjoutInscription - Obligatoire   : ".$boucle_tarif_activite['obligatoire']);
			
			if ( (in_array( $boucle_tarif_activite['id'], $listActivite, false))
			  || ($boucle_tarif_activite['obligatoire'] == 1) ) {
				$checked = "checked";
			} else {
				$checked = "";
			}
?>
<tr title="<?php echo "Observations : ".$boucle_tarif_activite['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="activite_<?php echo $nb_activite; ?>" value="<?php echo $boucle_tarif_activite['id']; ?>" <?php echo $checked ?>>
</td>
<td align=center>
<?php 
			echo ($boucle_tarif_activite['prix']*1); 
			echo " € ";
?>
</td>
<td>
<?php 
			echo $boucle_tarif_activite['nom']; ?>
</td>
</tr>
<?php
			$nb_activite++;
		}
	}
?>
</table>
</fieldset>
</td>
<td width=15>
</td>
<td>
<fieldset align="center" style="height=max; width=max">
<?php 
	$parametres = mysql_query("SELECT * FROM generale WHERE nom='reduction'");
	$parametres = mysql_fetch_array($parametres);
	$valeur = ($parametres['valeur']-1)*100;

?>
<legend><font color=blue><b>Cours </b></font><input type="checkbox" name="reduc"><?php echo $valeur." "; ?>%&nbsp;&nbsp;
Nb de trimestres : 
<select size='1' name='nb_trimestre'>
<option value=3 <?php if($nbTrimestre == "3"){ echo("selected"); }?>> - 3 - </option>
<option value=2 <?php if($nbTrimestre == "2"){ echo("selected"); }?>> - 2 - </option>
<option value=1 <?php if($nbTrimestre == "1"){ echo("selected"); }?>> - 1 - </option>
</select>&nbsp;
</legend>
<center>
Les prix indiqu&eacute;s concernent une ann&eacute;e compl&eacute;te,<br>soit 3 trimestres, et seront divis&eacute;s automatiquement si besoin.<br>
<?php
	$cours = mysql_query("SELECT * FROM cours WHERE actif = '1' ORDER BY classement");
?>
<table class="table4" summary="">
<?php
	while($boucle_cours = mysql_fetch_array($cours)){
		
		//$log->trace("AjoutInscription - Cours       : ".$boucle_cours['id']);
		//$log->trace("AjoutInscription - Obligatoire : ".$boucle_cours['obligatoire']);
		
		if ( (in_array( $boucle_cours['id'], $listCours, false))
		  || ($boucle_cours['obligatoire'] == 1) ) {
			$checked = "checked";
		} else {
			$checked = "";
		}
		
?>
<tr title="<?php echo "Observations : ".$boucle_cours['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="cours_<?php echo $nb_cours; ?>" value="<?php echo $boucle_cours['id']; ?>" <?php echo $checked ?>>
</td>
<td align=center>
<?php echo ($boucle_cours['prix']*1); 
	echo " € ";
?>
</td>
<td>
<?php echo $boucle_cours['nom']; ?>
</td>
</tr>
<?php
		$nb_cours++;
	}
?>
</table>
</center>
</fieldset>
</td>
<td width=15>
</td>
<td>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Frais Divers &nbsp;</b></font></legend>
<?php
	$frais = mysql_query("SELECT * FROM frais WHERE actif = '1' ORDER BY classement");
?>
<table class="table4" summary="">
<?php
	while($boucle_frais = mysql_fetch_array($frais)){
		
		//$log->trace("AjoutInscription - Frais : ".$boucle_frais['id']);
		//$log->trace("AjoutInscription - Frais : ".$boucle_frais['obligatoire']);
		
		if ( (in_array( $boucle_frais['id'], $listFrais, false))
		  || ($boucle_frais['obligatoire'] == 1) ) {
			$checked = "checked";
		} else {
			$checked = "";
		}
?>
<tr title="<?php echo "Observations : ".$boucle_frais['obs']; ?>">
<td width=20 align=center>
<input type="checkbox" name="frais_<?php echo $nb_frais; ?>" value="<?php echo $boucle_frais['id']; ?>" <?php echo $checked ?>>
</td>
<td align=center>
<?php echo ($boucle_frais['prix']*1); 
echo " € ";
?>
</td>
<td>
<?php echo $boucle_frais['nom']; ?>
</td>
</tr>
<?php
$nb_frais++;
}
?>
</table>
</fieldset>
</td>
</tr>

<tr>
<td height=10 colspan=5>
</td>
</tr>
<tr>
<td height=20 colspan=5>
<center>
<input type="button" onClick="document.formulaire.action='simulations.php';document.formulaire.target='simulation';document.formulaire.submit();" value="simulation">
</center>
</td>
</tr>
<tr>
<td height=5 colspan=5>
</td>
</tr>

<tr>
<td colspan=5>
<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Autres &nbsp;</b></font></legend>
<center>
<table border=0>
<tr>
<td colspan=3 align=center>
Passeport fait, donn&eacute; et rempli :&nbsp;
<input type="radio" name="passeport" value="OUI" <?php if ($passeport == "OUI") echo "checked" ?> id="1"><label for="1">OUI</label>
<input type="radio" name="passeport" value="NON" <?php if ($passeport == "NON") echo "checked" ?> id="2"><label for="2">NON</label>
</td>
</tr>
<tr>
<td height=10>
</td>
<td>
</td>
</tr>
<tr>
<td colspan=3 align=center>
Photo :&nbsp;
<input type="radio" name="photo" value="OUI" <?php if ($photo == "OUI") echo "checked" ?> id="3"><label for="3">OUI</label>
<input type="radio" name="photo" value="NON" <?php if ($photo == "NON") echo "checked" ?> id="4"><label for="4">NON</label>
</td>
</tr>
<tr>
<td height=10>
</td>
<td>
</td>
</tr>
<tr>
<td colspan=3 align=center>
certificat :&nbsp;
<input type="radio" name="certificat" value="OUI" <?php if ($certificat == "OUI") echo "checked" ?> id="7"><label for="7">OUI</label>
<input type="radio" name="certificat" value="NON" <?php if ($certificat == "NON") echo "checked" ?> id="8"><label for="8">NON</label>
(jj/mm/aaaa) : 
<input type="text" name="certificat_jj" size="1" maxlength="2" value="<?php echo $certificat_jj; ?>" onkeyup="Autotab(2, this.value, this.size)" id="id_1"> 
<input type="text" name="certificat_mm" size="1" maxlength="2" value="<?php echo $certificat_mm; ?>" onkeyup="Autotab(3, this.value, this.size)" id="id_2"> 
<input type="text" name="certificat_aaaa" size="2" maxlength="4" value="<?php echo $certificat_aaaa; ?>" id="id_3">
</td>
</tr>
<tr>
<td height=10>
</td>
<td>
</td>
</tr>
<tr>
<td align="center" colspan=3>
Caution :&nbsp;
<input type="radio" name="caution" value="espece" <?php if ($caution == "espece") echo "checked" ?> id="9"><label for="9">Esp&egrave;ces </label>
<input type="radio" name="caution" value="cheque" <?php if ($caution == "cheque") echo "checked" ?> id="10"><label for="10">Ch&egrave;que 
N° : </label><input type="text" name="caution_num" value="<?php echo $caution_num; ?>" size="10"> Banque :
	<select size='1' name='caution_banque' title="Choix de la Banque">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
				
				$selected = ($id_caution_banque == $boucle['id']) ? "selected" : "";
				echo "<option value=".$boucle['id']." ".$selected.">".$boucle['banque']."</option>";
				
			}
		?>
	</select>
</td>
</tr>
<tr>
<td height=30>
</td>
<td></td>
</tr>
<tr>
<td colspan=3 align=center>
Si le paiement total se fait en esp&egrave;ce, ne remplissez pas ce qui suit.
</td>
</tr>
<tr>
<td colspan=3 height=5>
</td>
<tr>
<td align="right">
<?php
//$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_1'");
//$parametres = mysql_fetch_array($parametres);
$modifiable = mysql_query("SELECT * FROM generale WHERE nom='prelevement_1_modifiable'");
$modifiable = mysql_fetch_array($modifiable);
?>
Paiements N° <font color=red><b>1 </b></font><?php echo Liste_deroulante_mois($p1_date,1,$modifiable['valeur']) ?> :</td><td width=5></td><td>N° du cheque : <input type="text" name="p1_num" value="<?php echo $p1_num; ?>" size="10"> Banque :
<select size='1' name='p1_banque' title="Choix de la Banque" onchange="banque(this.value, 1)" id="banque_1">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
				$selected = ($p1_banque == $boucle['id']) ? "selected" : "";
				echo "<option value=".$boucle['id']." ".$selected.">".$boucle['banque']."</option>";
			}
		?>
</select>
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
<?php
//$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_2'");
//$parametres = mysql_fetch_array($parametres);
$modifiable = mysql_query("SELECT * FROM generale WHERE nom='prelevement_2_modifiable'");
$modifiable = mysql_fetch_array($modifiable);
?>
Paiements N° <font color=blue><b>2 </b></font><?php echo Liste_deroulante_mois($p2_date,2,$modifiable['valeur']) ?> :</td><td></td><td>N° du cheque : <input type="text" name="p2_num" value="<?php echo $p2_num; ?>" size="10"> Banque :
<select size='1' name='p2_banque' title="Choix de la Banque" onchange="banque(this.value, 2)" id="banque_2">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
				$selected = ($p2_banque == $boucle['id']) ? "selected" : "";
				echo "<option value=".$boucle['id']." ".$selected.">".$boucle['banque']."</option>";
			}
		?>
</select>
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
<?php
//$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_3'");
//$parametres = mysql_fetch_array($parametres);
$modifiable = mysql_query("SELECT * FROM generale WHERE nom='prelevement_3_modifiable'");
$modifiable = mysql_fetch_array($modifiable);
?>
Paiements N° <font color=green><b>3 </b></font><?php echo Liste_deroulante_mois($p3_date,3,$modifiable['valeur']) ?> :</td><td></td><td>N° du cheque : <input type="text" name="p3_num" value="<?php echo $p3_num; ?>" size="10"> Banque :
<select size='1' name='p3_banque' title="Choix de la Banque" onchange="banque(this.value, 3)" id="banque_3">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
				$selected = ($p3_banque == $boucle['id']) ? "selected" : "";
				echo "<option value=".$boucle['id']." ".$selected.">".$boucle['banque']."</option>";
			}
		?>
</select>
</td>
</tr>
<tr>
<td height=10>
</td>
<td></td>
</tr>
<tr>
<td align="right">
<?php
//$parametres = mysql_query("SELECT * FROM generale WHERE nom='prelevement_4'");
//$parametres = mysql_fetch_array($parametres);
$modifiable = mysql_query("SELECT * FROM generale WHERE nom='prelevement_4_modifiable'");
$modifiable = mysql_fetch_array($modifiable);
?>
Paiements N° <font color=DeepPink><b>4 </b></font><?php echo Liste_deroulante_mois($p4_date,4,$modifiable['valeur']) ?> :</td><td></td><td>N° du cheque : <input type="text" name="p4_num" value="<?php echo $p4_num; ?>" size="10"> Banque :
<select size='1' name='p4_banque' title="Choix de la Banque" id="banque_4">
		<option value=0>- Banque -</option>
		<?php
			$banque = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
			while($boucle = mysql_fetch_array($banque)){
				$selected = ($p4_banque == $boucle['id']) ? "selected" : "";
				echo "<option value=".$boucle['id']." ".$selected.">".$boucle['banque']."</option>";
			}
		?>
</select>
</td>
</tr>
<tr>
<td height=10 colspan=3>
</td>
</tr>
<tr>
<td align=center colspan=3>
Observations (précisez parrain et parrainé) : <br><textarea name="obs" cols="33" rows="5"><?php echo $obs; ?></textarea>
</td>
</tr>
<?php
$parametres = mysql_query("SELECT * FROM generale WHERE nom='reduction_manuelle'");
$parametres = mysql_fetch_array($parametres);
if ($parametres['valeur'] == "OUI"){
?>
<tr>
<td height=10 colspan=3>
</td>
</tr>
<tr>
<td align=center colspan=3>
Modification du prix possible (+/- x €): <input type="text" name="reduc_manu" size="2" value="0" title="Info: Un nombre d&eacute;cimal doit s'&eacute;crire avec un point."> €
</td>
</tr>
<?php } ?>
</table>
</center>
</fieldset>
</td>
</tr>
</table>
<br>
<input type="button" value="Pr&eacute;c&eacute;dent" onclick="Javascript:history.back();">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">&nbsp;&nbsp;&nbsp;<input type="button" value="Suivant" onClick="document.formulaire.action='recapitulatif.php';document.formulaire.target='site';document.formulaire.submit();">
<input type="hidden" name="nb_activite" value="<?php echo $nb_activite-1;?>">
<input type="hidden" name="nb_cours" value="<?php echo $nb_cours-1;?>">
<input type="hidden" name="nb_frais" value="<?php echo $nb_frais-1;?>">
<input type="hidden" name="nb_grade" value="<?php echo $nb_grade-1;?>">
</form>
</form>
</center>
</body>
</html>