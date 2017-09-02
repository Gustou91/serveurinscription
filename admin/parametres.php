<html>
	<?php include "../restrict/config.php";?>
	<body>
		<form method="post" action="parametres.php">
	<?php
		mysql_connect($adresse, $user, $pass);
		mysql_select_db($bdd);mysql_set_charset( 'ansi' );

		function Liste_deroulante_mois($mois){
			setlocale (LC_TIME, 'fr_FR.ansi','fra');
			for($i = 1; $i <= 12; $i++ ){
				if($i == $mois){
					$value .= '<option value="'.$i.'" Selected>'.ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1, 2000))).'</option>';
				}else{
					$value .= '<option value="'.$i.'">'.ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1, 2000))).'</option>';
				}
			}
			return $value;
		}

		if(	isset($_POST["pass"]) && !empty($_POST["pass"])){
			$pass_bdd = mysql_query("SELECT valeur FROM generale WHERE nom='password'");
			$pass_bdd = mysql_fetch_array($pass_bdd);
			$pass_bdd = $pass_bdd['valeur'];
			$pass = $_POST["pass"];
			if($pass == $pass_bdd)
			//if(true)
			{
	?>
			<input type="hidden" name="pass" value="<?php echo $_POST["pass"];?>">
	<?php

		$variable = 0;
		//&eacute;criture dans la base
		if(	isset($_POST["pass_1"]) && !empty($_POST["pass_1"]) &&
			isset($_POST["pass_2"]) && !empty($_POST["pass_2"])){
				
			$pass_1 = mysql_real_escape_string(htmlspecialchars($_POST['pass_1']));
			$pass_2 = mysql_real_escape_string(htmlspecialchars($_POST['pass_2']));
			if ($pass_1 == $pass_2){
				$password = MD5($pass_1);
				//echo $pass;
				mysql_query("UPDATE generale SET valeur='$password' WHERE nom='password'");
			} else {
	?>

	<script>alert ("Mot de passe inchangé.\nLes deux champs n'ont pas été identiques.")</script>
	<?php
			}
		}

		if(	isset($_POST["titre_1"]) && !empty($_POST["titre_1"]) &&
			isset($_POST["titre_2"]) && !empty($_POST["titre_2"]) &&
			isset($_POST["couleur_01"]) && !empty($_POST["couleur_01"]) &&
			isset($_POST["couleur_02"]) && !empty($_POST["couleur_02"]) &&
			isset($_POST["ligne_contrat_01"]) && !empty($_POST["ligne_contrat_01"]) &&
			isset($_POST["sous_ligne_contrat_01"]) && !empty($_POST["sous_ligne_contrat_01"]) &&
			isset($_POST["ligne_contrat_02"]) && !empty($_POST["ligne_contrat_02"]) &&
			isset($_POST["sous_ligne_contrat_02"]) && !empty($_POST["sous_ligne_contrat_02"]) &&
			isset($_POST["ligne_contrat_03"]) && !empty($_POST["ligne_contrat_03"]) &&
			isset($_POST["sous_ligne_contrat_03"]) && !empty($_POST["sous_ligne_contrat_03"])&&      
			isset($_POST["ligne_contrat_04"]) && !empty($_POST["ligne_contrat_04"]) &&
			isset($_POST["sous_ligne_contrat_04"]) && !empty($_POST["sous_ligne_contrat_04"])&&
			isset($_POST["date_1"]) && !empty($_POST["date_1"]) &&
			isset($_POST["date_2"]) && !empty($_POST["date_2"]) &&
			isset($_POST["date_3"]) && !empty($_POST["date_3"]) && 
			isset($_POST["date_4"]) && !empty($_POST["date_4"]) &&
			isset($_POST["reduction"]) && !empty($_POST["reduction"]) &&
			isset($_POST["reduc_manu"]) && !empty($_POST["reduc_manu"]) &&
			isset($_POST["sup_membre"]) && !empty($_POST["sup_membre"]) &&
			isset($_POST["modif_membre"]) && !empty($_POST["modif_membre"]) &&
			isset($_POST["sup_inscription"]) && !empty($_POST["sup_inscription"]) &&
			isset($_POST["modif_inscription"]) && !empty($_POST["modif_inscription"]) &&
			isset($_POST["imprimer"]) && !empty($_POST["imprimer"]) &&
			isset($_POST["image_site"]) && !empty($_POST["image_site"]) &&
			isset($_POST["image_contrat"]) && !empty($_POST["image_contrat"]) &&
			isset($_POST["cnil"]) && !empty($_POST["cnil"]) &&
			isset($_POST["ajout_ville"]) && !empty($_POST["ajout_ville"]) &&
			isset($_POST["ajout_banque"]) && !empty($_POST["ajout_banque"])&&
			isset($_POST["prelevement_1"]) && !empty($_POST["prelevement_1"])&&
			isset($_POST["prelevement_2"]) && !empty($_POST["prelevement_2"])&&
			isset($_POST["prelevement_3"]) && !empty($_POST["prelevement_3"])&&
			isset($_POST["prelevement_4"]) && !empty($_POST["prelevement_4"])&&
			isset($_POST["mois_saison"]) && !empty($_POST["mois_saison"])&&
			isset($_POST["moduler_cheque"]) && !empty($_POST["moduler_cheque"])&&
			isset($_POST["largeur_impression"]) && !empty($_POST["largeur_impression"])&&
			isset($_POST["prelevement_1_modifiable"]) && !empty($_POST["prelevement_1_modifiable"])&&
			isset($_POST["prelevement_2_modifiable"]) && !empty($_POST["prelevement_2_modifiable"])&&
			isset($_POST["prelevement_3_modifiable"]) && !empty($_POST["prelevement_3_modifiable"])&&
			isset($_POST["prelevement_4_modifiable"]) && !empty($_POST["prelevement_4_modifiable"])&&
			isset($_POST["position_entete"]) && !empty($_POST["position_entete"])){
	
				$titre_1 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['titre_1'])));
				$titre_2 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['titre_2'])));
				$couleur_01 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['couleur_01'])));
				$couleur_02 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['couleur_02'])));
				$saison = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['saison'])));
				$ligne_contrat_01 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['ligne_contrat_01'])));
				$sous_ligne_contrat_01 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['sous_ligne_contrat_01'])));
				$ligne_contrat_02 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['ligne_contrat_02'])));
				$sous_ligne_contrat_02 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['sous_ligne_contrat_02'])));
				$ligne_contrat_03 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['ligne_contrat_03'])));
				$sous_ligne_contrat_03 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['sous_ligne_contrat_03'])));
				$ligne_contrat_04 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['ligne_contrat_04'])));
				$sous_ligne_contrat_04 = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['sous_ligne_contrat_04'])));
				$date_1 = mysql_real_escape_string(htmlspecialchars($_POST['date_1']));
				$date_2 = mysql_real_escape_string(htmlspecialchars($_POST['date_2'])); 
				$date_3 = mysql_real_escape_string(htmlspecialchars($_POST['date_3']));
				$date_4 = mysql_real_escape_string(htmlspecialchars($_POST['date_4']));
				$reduction = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['reduction'])));
				$reduc_manu = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['reduc_manu'])));
				$sup_inscription = mysql_real_escape_string(htmlspecialchars($_POST['sup_inscription']));
				$modif_inscription = mysql_real_escape_string(htmlspecialchars($_POST['modif_inscription']));
				$sup_membre = mysql_real_escape_string(htmlspecialchars($_POST['sup_membre']));
				$modif_membre = mysql_real_escape_string(htmlspecialchars($_POST['modif_membre']));
				$imprimer = mysql_real_escape_string(htmlspecialchars($_POST['imprimer']));
				$image_site = mysql_real_escape_string(htmlspecialchars($_POST['image_site']));
				$image_contrat = mysql_real_escape_string(htmlspecialchars($_POST['image_contrat']));
				$cnil = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['cnil'])));
				$ajout_ville = mysql_real_escape_string(htmlspecialchars($_POST['ajout_ville']));
				$ajout_banque = mysql_real_escape_string(htmlspecialchars($_POST['ajout_banque']));
				$prelevement_1 = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_1']));
				$prelevement_2 = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_2']));
				$prelevement_3 = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_3']));
				$prelevement_4 = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_4']));
				$mois_saison = mysql_real_escape_string(htmlspecialchars($_POST['mois_saison']));
				$moduler_cheque = mysql_real_escape_string(htmlspecialchars($_POST['moduler_cheque']));
				$largeur_impression = mysql_real_escape_string(htmlspecialchars($_POST['largeur_impression']));
				$prelevement_1_modifiable = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_1_modifiable']));
				$prelevement_2_modifiable = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_2_modifiable']));
				$prelevement_3_modifiable = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_3_modifiable']));
				$prelevement_4_modifiable = mysql_real_escape_string(htmlspecialchars($_POST['prelevement_4_modifiable']));
				$position_entete = mysql_real_escape_string(htmlspecialchars($_POST['position_entete']));

				//inscription de l'activite dans la base
				mysql_query("UPDATE generale SET valeur='$titre_1' WHERE nom='titre_1'");
				mysql_query("UPDATE generale SET valeur='$titre_2' WHERE nom='titre_2'");
				mysql_query("UPDATE generale SET valeur='$couleur_01' WHERE nom='couleur_01'");
				mysql_query("UPDATE generale SET valeur='$couleur_02' WHERE nom='couleur_02'");
				mysql_query("UPDATE generale SET valeur='$saison' WHERE nom='saison'");
				mysql_query("UPDATE generale SET valeur='$ligne_contrat_01' WHERE nom='ligne_contrat_01'");
				mysql_query("UPDATE generale SET valeur='$sous_ligne_contrat_01' WHERE nom='sous_ligne_contrat_01'");
				mysql_query("UPDATE generale SET valeur='$ligne_contrat_02' WHERE nom='ligne_contrat_02'");
				mysql_query("UPDATE generale SET valeur='$sous_ligne_contrat_02' WHERE nom='sous_ligne_contrat_02'");
				mysql_query("UPDATE generale SET valeur='$ligne_contrat_03' WHERE nom='ligne_contrat_03'");
				mysql_query("UPDATE generale SET valeur='$sous_ligne_contrat_03' WHERE nom='sous_ligne_contrat_03'");
				mysql_query("UPDATE generale SET valeur='$ligne_contrat_04' WHERE nom='ligne_contrat_04'");
				mysql_query("UPDATE generale SET valeur='$sous_ligne_contrat_04' WHERE nom='sous_ligne_contrat_04'");
				mysql_query("UPDATE generale SET valeur='$date_1' WHERE nom='date_1'");
				mysql_query("UPDATE generale SET valeur='$date_2' WHERE nom='date_2'");
				mysql_query("UPDATE generale SET valeur='$date_3' WHERE nom='date_3'");
				mysql_query("UPDATE generale SET valeur='$date_4' WHERE nom='date_4'");
				mysql_query("UPDATE generale SET valeur='$reduction' WHERE nom='reduction'");
				mysql_query("UPDATE generale SET valeur='$reduc_manu' WHERE nom='reduction_manuelle'");
				mysql_query("UPDATE generale SET valeur='$sup_inscription' WHERE nom='sup_inscription'");
				mysql_query("UPDATE generale SET valeur='$modif_inscription' WHERE nom='modif_inscription'");
				mysql_query("UPDATE generale SET valeur='$sup_membre' WHERE nom='sup_membre'");
				mysql_query("UPDATE generale SET valeur='$modif_membre' WHERE nom='modif_membre'");
				mysql_query("UPDATE generale SET valeur='$imprimer' WHERE nom='imprimer'");
				mysql_query("UPDATE generale SET valeur='$image_site' WHERE nom='image_site'");
				mysql_query("UPDATE generale SET valeur='$image_contrat' WHERE nom='image_contrat'");
				mysql_query("UPDATE generale SET valeur='$cnil' WHERE nom='cnil'");
				mysql_query("UPDATE generale SET valeur='$ajout_ville' WHERE nom='ajout_ville'");
				mysql_query("UPDATE generale SET valeur='$ajout_banque' WHERE nom='ajout_banque'");
				mysql_query("UPDATE generale SET valeur='$prelevement_1' WHERE nom='prelevement_1'");
				mysql_query("UPDATE generale SET valeur='$prelevement_2' WHERE nom='prelevement_2'");
				mysql_query("UPDATE generale SET valeur='$prelevement_3' WHERE nom='prelevement_3'");
				mysql_query("UPDATE generale SET valeur='$prelevement_4' WHERE nom='prelevement_4'");
				mysql_query("UPDATE generale SET valeur='$mois_saison' WHERE nom='mois_saison'");
				mysql_query("UPDATE generale SET valeur='$moduler_cheque' WHERE nom='moduler_cheque'");
				mysql_query("UPDATE generale SET valeur='$largeur_impression' WHERE nom='largeur_impression'");
				mysql_query("UPDATE generale SET valeur='$prelevement_1_modifiable' WHERE nom='prelevement_1_modifiable'");
				mysql_query("UPDATE generale SET valeur='$prelevement_2_modifiable' WHERE nom='prelevement_2_modifiable'");
				mysql_query("UPDATE generale SET valeur='$prelevement_3_modifiable' WHERE nom='prelevement_3_modifiable'");
				mysql_query("UPDATE generale SET valeur='$prelevement_4_modifiable' WHERE nom='prelevement_4_modifiable'");
				mysql_query("UPDATE generale SET valeur='$position_entete' WHERE nom='position_entete'");

				//fin d'inscription de l'activite dans la base
				//fin travail sur BDD
				$variable = 1;
				$_POST = "";
			}
			//donnée manquante
			elseif(	isset($_POST["titre_1"])&&
				isset($_POST["titre_2"]) &&
				isset($_POST["couleur_01"]) &&
				isset($_POST["couleur_02"]) &&
				isset($_POST["ligne_contrat_01"])&&
				isset($_POST["sous_ligne_contrat_01"]) &&
				isset($_POST["ligne_contrat_02"])&&
				isset($_POST["sous_ligne_contrat_02"]) &&
				isset($_POST["ligne_contrat_03"]) &&
				isset($_POST["sous_ligne_contrat_03"]) &&
				isset($_POST["ligne_contrat_04"]) &&
				isset($_POST["sous_ligne_contrat_04"]) &&
				isset($_POST["date_1"]) &&
				isset($_POST["date_2"]) &&
				isset($_POST["date_3"]) &&
				isset($_POST["date_4"]) &&
				isset($_POST["reduction"]) &&
				isset($_POST["reduc_manu"]) &&
				isset($_POST["sup_inscription"]) &&
				isset($_POST["modif_inscription"]) &&
				isset($_POST["sup_membre"]) &&
				isset($_POST["modif_membre"]) &&
				isset($_POST["imprimer"]) &&
				isset($_POST["image_site"]) &&
				isset($_POST["image_contrat"]) &&
				isset($_POST["cnil"]) &&
				isset($_POST["ajout_ville"]) &&
				isset($_POST["ajout_banque"])&&
				isset($_POST["prelevement_1"])&&
				isset($_POST["prelevement_2"])&&
				isset($_POST["prelevement_3"])&&
				isset($_POST["prelevement_4"])&&
				isset($_POST["mois_saison"])&&
				isset($_POST["moduler_cheque"])&&
				isset($_POST["largeur_impression"])&&
				isset($_POST["prelevement_1_modifiable"])&&
				isset($_POST["prelevement_2_modifiable"])&&
				isset($_POST["prelevement_3_modifiable"])&&
				isset($_POST["prelevement_4_modifiable"])&&
				isset($_POST["position_entete"])){
	?>
	<script>alert ("Il manque au moins une\ndonnée à renseigner")</script>
	<?php
			}
	?>
<center>
	<table border=0>
		<tr><td colspan=3><center>Configuration des diff&eacute;rents param&egrave;tres</center></td></tr>
		<tr><td colspan=3><center>Le nom de l'image de fond des impressions doit etre ici : www/img/fond.jpg</center></td></tr>
		<tr><td height="25"></td><td></td></tr>
		<tr>
			<td colspan=3>
				<center><input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Annul&eacute;"></center>
			</td>
		</tr>

		<tr><td height="10"></td><td></td></tr>
		<tr>
			<td align="right">
				Titre de Gauche
			</td>
			<td width="15"></td>
			<td>
	<?php
		$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='titre_1'");
		$parametres = mysql_fetch_array($parametres);
	?>
				<textarea name="titre_1" cols="60" rows="10"><?php if(isset($_POST["titre_1"])){ echo stripslashes($_POST["titre_1"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
			</td>
		</tr>

		<tr><td height="10"></td><td></td></tr>
		<tr>
			<td align="right">
				Nom de l'image d'accueil (dossier www/img/)
			</td>
			<td width="15"></td>
			<td>
	<?php
		$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='image_site'");
		$parametres = mysql_fetch_array($parametres);
	?>
<input type="text" name="image_site" size="15" value="<?php if(isset($_POST["image_site"])){ echo stripslashes($_POST["image_site"]); } else {echo stripslashes($parametres['valeur']);}?>">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Titre de droite
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='titre_2'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="titre_2" cols="60" rows="10"><?php if(isset($_POST["titre_2"])){ echo stripslashes($_POST["titre_2"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Couleur de la premi&egrave;re ligne des tableaux
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="text" name="couleur_02" size="8" value="<?php if(isset($_POST["couleur_02"])){ echo stripslashes($_POST["couleur_02"]); } else {echo stripslashes($parametres['valeur']);}?>">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Largeur des impressions
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='largeur_impression'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="text" name="largeur_impression" size="8" value="<?php if(isset($_POST["largeur_impression"])){ echo stripslashes($_POST["largeur_impression"]); } else {echo stripslashes($parametres['valeur']);}?>">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Couleur de la deuxi&egrave;me ligne des tableaux
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="text" name="couleur_01" size="8" value="<?php if(isset($_POST["couleur_01"])){ echo stripslashes($_POST["couleur_01"]); } else {echo stripslashes($parametres['valeur']);}?>">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Changer le mot de passe :
</td>
<td width="15"></td>
<td>
<input type="password" name="pass_1" size="10">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Confirmer le nouveau mot de passe :
</td>
<td width="15"></td>
<td>
<input type="password" name="pass_2" size="10">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
<?php $annee_suivante=$annee_actu+1; ?>
Saison actuelle : <?php echo $annee_actu."-".$annee_suivante ?>
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='saison'");
$parametres = mysql_fetch_array($parametres);
?>
+/- <input type="text" name="saison" size="1" value="<?php if(isset($_POST["saison"])){ echo stripslashes($_POST["saison"]); } else {echo stripslashes($parametres['valeur']);}?>"> an(s)
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Changement de saison à partir de :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='mois_saison'");
$parametres = mysql_fetch_array($parametres);
echo '<select name="mois_saison" size="1">';
echo Liste_deroulante_mois($parametres['valeur']);
echo "</select>";
?>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
<?php 
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='reduction'");
$parametres = mysql_fetch_array($parametres);
$valeur = ($parametres['valeur']-1)*100;
?>
Reduction actuelle des cours : <?php echo $valeur." %"; ?>
</td>
<td width="15"></td>
<td>
<input type="text" name="reduction" size="1" value="<?php if(isset($_POST["reduction"])){ echo stripslashes($_POST["reduction"]); } else {echo stripslashes($parametres['valeur']);}?>">
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Possibilite de modifier la valeur des chèques :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='moduler_cheque'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="moduler_cheque" value="OUI" id="1" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="1">OUI</label>
<input type="radio" name="moduler_cheque" value="NON" id="2" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="2">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Afficher la fenètre d'impression automatiquement :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='imprimer'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="imprimer" value="OUI" id="1" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="1">OUI</label>
<input type="radio" name="imprimer" value="NON" id="2" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="2">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Possibilit&eacute; de faire une r&eacute;duction manuelle :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='reduction_manuelle'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="reduc_manu" value="OUI" id="3" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="3">OUI</label>
<input type="radio" name="reduc_manu" value="NON" id="4" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="4">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Autoriser la modification des membres :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='modif_membre'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="modif_membre" value="OUI" id="5" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="5">OUI</label>
<input type="radio" name="modif_membre" value="NON" id="6" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="6">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Possibilit&eacute; de supprimer un membre :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sup_membre'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="sup_membre" value="OUI" id="7" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="7">OUI</label>
<input type="radio" name="sup_membre" value="NON" id="8" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="8">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Autoriser la modification des inscriptions :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='modif_inscription'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="modif_inscription" value="OUI" id="9" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="9">OUI</label>
<input type="radio" name="modif_inscription" value="NON" id="10" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="10">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Possibilit&eacute; de supprimer une inscription :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sup_inscription'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="sup_inscription" value="OUI" id="11" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="11">OUI</label>
<input type="radio" name="sup_inscription" value="NON" id="12" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="12">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Possibilité d'ajouter une ville et son CP :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='ajout_ville'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="ajout_ville" value="OUI" id="13" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="13">OUI</label>
<input type="radio" name="ajout_ville" value="NON" id="14" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="14">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Possibilité d'ajouter une banque :
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='ajout_banque'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="ajout_banque" value="OUI" id="17" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="17">OUI</label>
<input type="radio" name="ajout_banque" value="NON" id="18" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="18">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Nom de l'image d'entête du contrat (dossier www/img/)
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='image_contrat'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="text" name="image_contrat" size="15" value="<?php if(isset($_POST["image_contrat"])){ echo stripslashes($_POST["image_contrat"]); } else {echo stripslashes($parametres['valeur']);}?>">
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='position_entete'");
$parametres = mysql_fetch_array($parametres);
$gauche_select="";
$milieu_select="";
$droite_select="";
if($parametres['valeur'] == "gauche"){$gauche_select = " selected";}
elseif($parametres['valeur'] == "milieu"){$milieu_select = " selected";}
else{$droite_select = " selected";}
?>
<select name="position_entete" size="1">
<option value="gauche"<?php echo $gauche_select ?>>A gauche</option>
<option value="milieu"<?php echo $milieu_select ?>>Au milieu</option>
<option value="droite"<?php echo $droite_select ?>>A droite</option>
</select>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Date du paiement N°1 :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_1'");
$parametres = mysql_fetch_array($parametres);
echo '<select name="prelevement_1" size="1">';
echo Liste_deroulante_mois($parametres['valeur']);
echo '</select>';
?>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Paiement N°1 modifiable :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_1_modifiable'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="prelevement_1_modifiable" value="OUI" id="27" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="27">OUI</label>
<input type="radio" name="prelevement_1_modifiable" value="NON" id="28" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="28">NON</label>
</td>
</tr><tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Date du paiement N°2 :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_2'");
$parametres = mysql_fetch_array($parametres);
echo '<select name="prelevement_2" size="1">';
echo Liste_deroulante_mois($parametres['valeur']);
echo '</select>';
?>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Paiement N°2 modifiable :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_2_modifiable'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="prelevement_2_modifiable" value="OUI" id="29" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="29">OUI</label>
<input type="radio" name="prelevement_2_modifiable" value="NON" id="30" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="30">NON</label>
</td>
</tr><tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Date du paiement N°3 :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_3'");
$parametres = mysql_fetch_array($parametres);
echo '<select name="prelevement_3" size="1">';
echo Liste_deroulante_mois($parametres['valeur']);
echo '</select>';
?>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Paiement N°3 modifiable :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_3_modifiable'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="prelevement_3_modifiable" value="OUI" id="31" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="31">OUI</label>
<input type="radio" name="prelevement_3_modifiable" value="NON" id="32" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="32">NON</label>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Date du paiement N°4 :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_4'");
$parametres = mysql_fetch_array($parametres);
echo '<select name="prelevement_4" size="1">';
echo Liste_deroulante_mois($parametres['valeur']);
echo '</select>';
?>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Paiement N°4 modifiable :
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='prelevement_4_modifiable'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="prelevement_4_modifiable" value="OUI" id="33" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="33">OUI</label>
<input type="radio" name="prelevement_4_modifiable" value="NON" id="34" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="34">NON</label>
</td>
</tr>
<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Premier paragraphe du contrat
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='ligne_contrat_01'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="ligne_contrat_01" cols="60" rows="10"><?php if(isset($_POST["ligne_contrat_01"])){ echo stripslashes($_POST["ligne_contrat_01"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Afficher la date
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='date_1'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="date_1" value="OUI" id="21" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="21">OUI</label>
<input type="radio" name="date_1" value="NON" id="22" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="22">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Sous paragraphe du premier paragraphe
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sous_ligne_contrat_01'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="sous_ligne_contrat_01" cols="60" rows="10"><?php if(isset($_POST["sous_ligne_contrat_01"])){ echo stripslashes($_POST["sous_ligne_contrat_01"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Deuxi&egrave;me paragraphe du contrat
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='ligne_contrat_02'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="ligne_contrat_02" cols="60" rows="10"><?php if(isset($_POST["ligne_contrat_02"])){ echo stripslashes($_POST["ligne_contrat_02"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Afficher la date
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='date_2'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="date_2" value="OUI" id="23" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="23">OUI</label>
<input type="radio" name="date_2" value="NON" id="24" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="24">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Sous paragraphe du deuxi&egrave;me paragraphe
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sous_ligne_contrat_02'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="sous_ligne_contrat_02" cols="60" rows="10"><?php if(isset($_POST["sous_ligne_contrat_02"])){ echo stripslashes($_POST["sous_ligne_contrat_02"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Troisi&egrave;me paragraphe du contrat
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='ligne_contrat_03'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="ligne_contrat_03" cols="60" rows="10"><?php if(isset($_POST["ligne_contrat_03"])){ echo stripslashes($_POST["ligne_contrat_03"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Afficher la date
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='date_3'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="date_3" value="OUI" id="25" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="25">OUI</label>
<input type="radio" name="date_3" value="NON" id="26" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="26">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Sous paragraphe du troisi&egrave;me paragraphe
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sous_ligne_contrat_03'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="sous_ligne_contrat_03" cols="60" rows="10"><?php if(isset($_POST["sous_ligne_contrat_03"])){ echo stripslashes($_POST["sous_ligne_contrat_03"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Quartrième paragraphe du contrat
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='ligne_contrat_04'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="ligne_contrat_04" cols="60" rows="10"><?php if(isset($_POST["ligne_contrat_03"])){ echo stripslashes($_POST["ligne_contrat_04"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Afficher la date
</td>
<td></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='date_4'");
$parametres = mysql_fetch_array($parametres);
?>
<input type="radio" name="date_4" value="OUI" id="25" <?php if($parametres['valeur']=="OUI"){echo "checked"; } ?>> <label for="37">OUI</label>
<input type="radio" name="date_4" value="NON" id="26" <?php if($parametres['valeur']=="NON"){echo "checked"; } ?>> <label for="38">NON</label>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Sous paragraphe du quatrième paragraphe
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='sous_ligne_contrat_04'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="sous_ligne_contrat_04" cols="60" rows="10"><?php if(isset($_POST["sous_ligne_contrat_04"])){ echo stripslashes($_POST["sous_ligne_contrat_04"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>

<tr><td height="10"></td><td></td></tr>
<tr>
<td align="right">
Paragraphe consacré à la CNIL
</td>
<td width="15"></td>
<td>
<?php
$parametres = mysql_query("SELECT valeur FROM generale WHERE nom='cnil'");
$parametres = mysql_fetch_array($parametres);
?>
<textarea name="cnil" cols="60" rows="10"><?php if(isset($_POST["cnil"])){ echo stripslashes($_POST["cnil"]); } else {echo stripslashes($parametres['valeur']);} ?></textarea>
</td>
</tr>
</table>
<br>
<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Annul&eacute;">
</form>
<?php
if ($variable == 1){
?>
<script>alert ("Modifications enregistrées\navec succes")</script>
<?php
}
?>
</center>
<?php 
}else{
echo "<center><br><br>Il y a eu un problème d'autentification,<br>merci de cliquer sur le bouton paramètres du menu principal.</center>";
}}
 ?>
</body>
</html>