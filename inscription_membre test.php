<?php include "restrict/config.php";?>

<html>
<head>
<title>USM</title>
</head>
<script type="text/javascript">
		function OpenBooking_ville(page) {
			window.open("ajout_ville.php?page=" + page, "adm_ville", "width=500, height=325, left=" + (screen.width-500)/2 + ", top=" + (screen.height-325)/2);
		}
		function OpenBooking_cp(page) {
			window.open("ajout_cp.php?page=" + page, "adm_cp", "width=500, height=325, left=" + (screen.width-500)/2 + ", top=" + (screen.height-325)/2);
		}
</script>
<script type="text/javascript">
	/**
	 * Permet d'envoyer des données en GET ou POST en utilisant les XmlHttpRequest
	 */
	function sendData(param, page)
	{
		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else
		//définition de l'endroit d'affichage:
		var content = document.getElementById("contenu");
		XhrObj.open("POST", page);
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
		}
		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param);
	}//fin fonction SendData
    </script>
<body style="text-align:center" onload="document.forms.formulaire.nom.focus(); calcul_mois(); calcul_ans()">
<center>
<?php
$suivant=0;
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);
$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;
echo "FEUILLE D'INSCRIPTION<br><b><font color=red>Saison ".$annee_actu." - ".$annee_suivante."</font></b><br>Etape 1 / 4";
//&eacute;criture dans la base client
if(	isset($_POST["nom"]) && !empty($_POST["nom"]) &&
	isset($_POST["prenom"]) && !empty($_POST["prenom"]) &&
	isset($_POST["representants"]) && !empty($_POST["representants"]) &&
	isset($_POST["adresse"]) && !empty($_POST["adresse"]) &&
	isset($_POST["cp"]) && !empty($_POST["cp"]) &&
	isset($_POST["ville"]) && !empty($_POST["ville"]) &&
	isset($_POST["mail"]) && !empty($_POST["mail"]) &&
	isset($_POST["urgence"]) && !empty($_POST["urgence"]) &&
	isset($_POST["jj"]) && !empty($_POST["jj"]) &&
	isset($_POST["mm"]) && !empty($_POST["mm"]) &&
	isset($_POST["aaaa"]) && !empty($_POST["aaaa"])){
//control si client existe

$nom = strtoupper(mysql_real_escape_string(htmlspecialchars($_POST['nom'])));
$prenom = mysql_real_escape_string(htmlspecialchars($_POST['prenom']));
if(isset($_POST['sexe'])){
$sexe = mysql_real_escape_string(htmlspecialchars($_POST['sexe']));
}else{$sexe="";}
$jj = mysql_real_escape_string(htmlspecialchars($_POST['jj']));
$mm = mysql_real_escape_string(htmlspecialchars($_POST['mm']));
$aaaa = mysql_real_escape_string(htmlspecialchars($_POST['aaaa']));
$poids = mysql_real_escape_string(htmlspecialchars($_POST['poids']));
$representants = mysql_real_escape_string(htmlspecialchars($_POST['representants']));
$adresse = mysql_real_escape_string(htmlspecialchars($_POST['adresse']));
$cp = mysql_real_escape_string(htmlspecialchars($_POST['cp']));
$ville = mysql_real_escape_string(htmlspecialchars($_POST['ville']));
$mail = mysql_real_escape_string(htmlspecialchars($_POST['mail']));
$tel_dom = mysql_real_escape_string(htmlspecialchars($_POST['tel_dom']));
$tel_port = mysql_real_escape_string(htmlspecialchars($_POST['tel_port']));
$urgence = mysql_real_escape_string(htmlspecialchars($_POST['urgence']));
$tel_urg = mysql_real_escape_string(htmlspecialchars($_POST['tel_urg']));
$obs = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['obs'])));
//travail sur BDD
$membres = mysql_query("SELECT * FROM membres WHERE nom = '$nom' AND prenom = '$prenom'");
$membres = mysql_fetch_array($membres);
//fin travail sur BDD
if ($membres != NULL){
?>
<script>alert ("Le membre \n<?php echo $nom; ?> <?php echo $prenom; ?>\na déjà été inscrit le\n<?php echo $membres['date']; $actif=$membres['actif']; if ($actif == 0) { ?>\n \nMais il est supprimé, allez dans la partie administrative pour le rétablir.<?php }; ?>")</script>
<?php
$_POST = "";
}
//fin control si membre existe
elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
?>
<script>alert ("Il y a eu une erreur de saisie\nconcernant l'adresse mail.")</script>
<?php
}else {
//inscription du membre dans la base
mysql_query("INSERT INTO membres VALUES(NULL, NOW( ), '$nom', '$prenom', '$sexe', '$jj', '$mm', '$aaaa', '$poids', '$representants', '$adresse', '$cp', '$ville', '$mail', '$tel_dom', '$tel_port', '$urgence', '$tel_urg', '$obs', '1')")or die(mysql_error());
//fin d'inscription du client dans la base
$id_membre = mysql_query("SELECT * FROM membres WHERE nom = '$nom' AND prenom = '$prenom'");
$id_membre = mysql_fetch_array($id_membre);
$id_membre = $id_membre["id"];
mysql_close();
//fin travail sur BDD
$_POST = "";
$suivant=1;
}}
//donn&eacute;e manquante pour un nouveau client
else{
if(	isset($_POST["nom"]) &&
	isset($_POST["prenom"]) &&
	isset($_POST["representants"]) &&
	isset($_POST["adresse"]) &&
	isset($_POST["cp"]) &&
	isset($_POST["ville"]) &&
	isset($_POST["mail"]) &&
	isset($_POST["urgence"]) &&
	isset($_POST["jj"]) &&
	isset($_POST["mm"]) &&
	isset($_POST["aaaa"])){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le nouveau membre")</script>
<?php
}}
//fin donn&eacute;e manquante pour un nouveau client
//fin &eacute;criture dans la base client
?>
<body>
<script type="text/javascript">
function Autotab(id, texte, longueur)
{
    if (texte.length > longueur) {
        document.getElementById('id_'+id).focus();
    }
}
function calcul_mois()
{
	var now = new Date;
	var mois = now.getMonth() - document.getElementById('id_2').value + 1;
	if(mois < 0)
	{
		mois = 13 + mois;
	}
	document.getElementById('mois').innerHTML = mois;
}
function calcul_ans()
{
	var now = new Date;
	var mois = now.getMonth() - document.getElementById('id_2').value + 1;
	var ans = now.getFullYear() - document.getElementById('id_3').value;
	if(mois < 0)
	{
		ans = ans - 1;
	}
	document.getElementById('ans').innerHTML = ans;
}
</script>
<fieldset align="center" style="height=max; width=max">
<legend>Ajouter un nouveau membre&nbsp;</legend>

<?php if ($suivant == 0){ ?>
	<form method="post" action="inscription_membre.php" name="formulaire">
	<br>
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="15" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"]; } ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Pr&eacute;nom : </b></font><input type="text" name="prenom" size="15" value="<?php if(isset($_POST["prenom"])){ echo $_POST["prenom"]; } ?>">
	</td>
	<td width=10></td>
	<td align=left>
		<input type="radio" name="sexe" value="M" id="1" <?php if(isset($_POST["sexe"]) =="M"){echo "checked";}?>> <label for="1">Masculin</label>
		<input type="radio" name="sexe" value="F" id="2" <?php if(isset($_POST["sexe"]) =="F"){echo "checked";}?>> <label for="2">F&eacute;minin</label>
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td colspan="3" align=left>
		<font color=red><b>Date de naissance (jj/mm/aaaa) :</b></font>
		<input type="text" name="jj" size="1" value="<?php if(isset($_POST["jj"])){ echo $_POST["jj"]; } ?>" maxlength="2" onkeyup="Autotab(2, this.value, this.size)" id="id_1">
		<input type="text" name="mm" size="1" value="<?php if(isset($_POST["mm"])){ echo $_POST["mm"]; } ?>" maxlength="2" onkeyup="Autotab(3, this.value, this.size); calcul_mois(); calcul_ans()" id="id_2">
		<input type="text" name="aaaa" size="2" value="<?php if(isset($_POST["aaaa"])){ echo $_POST["aaaa"]; } ?>" maxlength="4" onkeyup="calcul_ans(); calcul_mois()" id="id_3">
		&nbsp;&nbsp;Soit <b><font color=red id="ans" ></font></b> ans et <b><font color=red id="mois"></font></b> mois.
	</td>
	<td></td>
	<td align=left>
		Poids : <input type="text" name="poids" size="1" value="<?php if(isset($_POST["poids"])){ echo $_POST["poids"]; } ?>" maxlength="3"> Kg
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td  colspan="5" align=left>
		<font color=red><b>Nom des repr&eacute;sentants l&eacute;gaux : </b></font><input type="text" name="representants" size="50" value="<?php if(isset($_POST["representants"])){ echo $_POST["representants"]; } ?>">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td align=left>
		<font color=red><b>Adresse : </b></font><input type="text" name="adresse" size="30" value="<?php if(isset($_POST["adresse"])){ echo $_POST["adresse"]; } ?>">
	</td>
	<td></td>
	<td align=left>
		<font color=red><b>Ville : </b></font>
		<select size='1' name='ville' title="Choix de la ville" OnChange="sendData('id='+this.value,'requete_ville_to_cp.php')" onKeyUp="sendData('id='+this.value,'requete_ville_to_cp.php')">
		<?php
		$i=0; // variable de test
		$j=0; // variable pour garder la valeur du premier enregistrement catégorie pour l'affichage

		mysql_connect($adresse, $user, $pass);
		mysql_select_db($bdd);
		if(isset($_POST["ville"]))
		{
			$id_ville=$_POST["ville"];
			if ($id_ville==0)
			{
				echo "<option value=0>- ville -</option>";
			}
			else
			{
				$ville = mysql_query("SELECT * FROM villes WHERE id = '$id_ville';");
				$ville = mysql_fetch_array($ville);
				echo "<option value=".$ville[2].">".$ville[3]."</option>";
			}
		}
		else
		{
			echo "<option value=0>- ville -</option>";
		}
			$ville = mysql_query("SELECT * FROM villes WHERE actif = '1' ORDER BY ville;");
			while($boucle = mysql_fetch_array($ville)){
			echo "<option value=".$boucle[2].">".$boucle[3]."</option>";
			if ($i==0) { $j=$boucle[0]; $i=1; }
		}
		?>
		</select>
	</td>
	<td></td>
	<td align=left id="contenu" width=300>
	<font color=red><b>CP : </b></font>
	<?php  
  // affichage des sous-catégorie appartenant à la première catégorie.
		
    $rq="Select * from cp where (id=".$j.");";
    $result= mysql_query ($rq) or die ("Select impossible");
     // $i = initialise le variable i
    $i=0;
    $cp = mysql_fetch_array($result);
	 echo "<input type=\"text\" name=\"cp\" size=\"4\" maxlength=\"5\" value=\"CP\">";  
   ?>
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td align=left>
		<font color=red><b>Mail : </b></font><input type="text" name="mail" size="25" value="<?php if(isset($_POST["mail"])){ echo $_POST["mail"]; } ?>">
	</td>
	<td></td>
	<td align=left>
		Tel. Domicile : <input type="text" name="tel_dom" size="9" value="<?php if(isset($_POST["tel_dom"])){ echo $_POST["tel_dom"]; } ?>" maxlength="10">
	</td>
	<td></td>
	<td align=left>
		Tel. Portable : <input type="text" name="tel_port" size="9" value="<?php if(isset($_POST["tel_port"])){ echo $_POST["tel_port"]; } ?>" maxlength="10">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td colspan="3" align=left >
		<font color=red><b>Personne &agrave; pr&eacute;venir en cas d'urgence : </b></font><input type="text" name="urgence" size="30" value="<?php if(isset($_POST["urgence"])){ echo $_POST["urgence"]; } ?>">
	</td>
	<td></td>
	<td align=left>
		Tel. : <input type="text" name="tel_urg" size="9" value="<?php if(isset($_POST["tel_urg"])){ echo $_POST["tel_urg"]; } ?>" maxlength="10">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	</table>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"]; } else{ echo "RAS"; } ?></textarea><br><br>
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">
	</form>
<?php }
else { 
?>
	<br><br>Membre enregistr&eacute; avec success<br><br>
	<input type="button" name="inscription_inscription" value="Suivant" onclick="self.location.href='inscription_inscription.php?id_membre=<?php echo $id_membre; ?>'"> 
<?php } ?>
</fieldset>
<br>
<?php
		$parametres = mysql_query("SELECT * FROM generale WHERE nom='ajout_ville'");
		$parametres = mysql_fetch_array($parametres);
		if($parametres['valeur']=="OUI")
		{
		echo "<button onClick=\"OpenBooking_ville('inscription_membre')\">Ajouter ville</button>&nbsp;";
		echo "<button onClick=\"OpenBooking_cp('inscription_membre')\">Ajouter CP</button>";
		}
		mysql_close();
?>
</center>
</body>
</html>