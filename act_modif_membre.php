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
<?php
include "restrict/config.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$variable = 0;
if(isset($_POST['sexe'])){
$sexe = mysql_real_escape_string(htmlspecialchars($_POST['sexe']));
}else{$sexe="";}
//&eacute;criture dans la base BOX
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
	isset($_POST["aaaa"]) && !empty($_POST["aaaa"]) &&
	isset($_POST["sexe"]) && !empty($_POST["sexe"])){
//control si le BOX existe
$nom = strtoupper(mysql_real_escape_string(htmlspecialchars($_POST['nom'])));
$prenom = ucwords(mysql_real_escape_string(htmlspecialchars($_POST['prenom'])));

$jj = mysql_real_escape_string(htmlspecialchars($_POST['jj']));
$mm = mysql_real_escape_string(htmlspecialchars($_POST['mm']));
$aaaa = mysql_real_escape_string(htmlspecialchars($_POST['aaaa']));
$poids = mysql_real_escape_string(htmlspecialchars($_POST['poids']));
$representants = mysql_real_escape_string(htmlspecialchars($_POST['representants']));
$profession1 = mysql_real_escape_string(htmlspecialchars($_POST['profession1']));
$profession2 = mysql_real_escape_string(htmlspecialchars($_POST['profession2']));
$adresse = mysql_real_escape_string(htmlspecialchars($_POST['adresse']));
$cp = mysql_real_escape_string(htmlspecialchars($_POST['cp']));
$ville = mysql_real_escape_string(htmlspecialchars($_POST['ville']));
$mail = mysql_real_escape_string(htmlspecialchars($_POST['mail']));
$tel_dom = mysql_real_escape_string(htmlspecialchars($_POST['tel_dom']));
$tel_port = mysql_real_escape_string(htmlspecialchars($_POST['tel_port']));
$urgence = mysql_real_escape_string(htmlspecialchars($_POST['urgence']));
$tel_urg = mysql_real_escape_string(htmlspecialchars($_POST['tel_urg']));
$obs = mysql_real_escape_string(htmlspecialchars(addslashes($_POST['obs'])));
$id_membre = $_POST["id_membre"];
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
?>
<script>alert ("Il y a eu une erreur de saisie\nconcernant l'adresse mail.")</script>
<?php
}else{
//inscription de l'activite dans la base
mysql_query("UPDATE membres SET nom='$nom', prenom='$prenom', sexe='$sexe', jj='$jj', mm='$mm', aaaa='$aaaa', poids='$poids', representants='$representants', profession1='$profession1', profession2='$profession2', adresse='$adresse', cp='$cp', ville='$ville', mail='$mail', tel_dom='$tel_dom', tel_port='$tel_port', urgence='$urgence', tel_urg='$tel_urg', obs='$obs' WHERE id='$id_membre'")or die(mysql_error());
//fin d'inscription de l'activite dans la base
}
mysql_close();
//fin travail sur BDD
$variable = 1;
$_POST = "";
}
//donn&eacute;e manquante pour une nouvelle activite
elseif(	isset($_POST["nom"]) &&
		isset($_POST["prenom"]) &&
		isset($_POST["representants"]) &&
		isset($_POST["adresse"]) &&
		isset($_POST["cp"]) &&
		isset($_POST["ville"]) &&
		isset($_POST["mail"]) &&
		isset($_POST["urgence"]) &&
		isset($_POST["jj"]) &&
		isset($_POST["mm"]) &&
		isset($_POST["aaaa"]) &&
		($sexe == "")){
?>
<script>alert ("Il manque au moins une donnée\nconcernant le membre")</script>
<?php
}
if ($variable == 1){
?>
<center><br>
Membre modifi&eacute; avec succes<br><br>
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_membres.php';">
</center>
<?php
}
elseif((isset($_REQUEST["id_membre"]) && !empty($_REQUEST["id_membre"]))){
$id = $_REQUEST["id_membre"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$membre = mysql_query("SELECT * FROM membres WHERE id='$id'");
$membre = mysql_fetch_array($membre);
mysql_close();

//fin donn&eacute;e manquante pour une activite
//fin &eacute;criture dans la base activites
?>
<body onload="calcul_ans()">
<script type="text/javascript">
function Autotab(id, texte, longueur)
{
    if (texte.length > longueur) {
        document.getElementById('id_'+id).focus();
    }
}
function calcul_ans()
{
	var now = new Date;
	var ans = now.getFullYear() - document.getElementById('id_3').value;
	document.getElementById('ans').innerHTML = ans;
}
</script>
<center>
<fieldset align="center" style="height=max; width=max">
<legend>Modifier <?php if($membre['sexe'] == "M"){echo "Mr. ";} elseif($membre['sexe'] == "F"){echo "Mme. ";} echo $membre['nom']; echo "&nbsp;"; echo $membre['prenom']?>&nbsp;</legend>

	<form method="post" action="act_modif_membre.php">
	<br>
	<table border=0>
	<tr>
	<td align=left>
		<font color=red><b>Nom : </b></font><input type="text" name="nom" size="15" value="<?php if(isset($_POST["nom"])){ echo $_POST["nom"];}else {echo $membre['nom'];} ?>" style=text-transform:uppercase>
	</td>
	<td width=10></td>
	<td align=left>
		<font color=red><b>Pr&eacute;nom : </b></font><input type="text" name="prenom" size="15" value="<?php if(isset($_POST["prenom"])){ echo $_POST["prenom"];}else {echo $membre['prenom'];} ?>" style=text-transform:capitalize>
	</td>
	<td width=10></td>
	<td align=left>
		<input type="radio" name="sexe" value="M" id="1" <?php if((isset($_POST["sexe"])=="M") or ($membre['sexe']=="M")){echo "checked";}?>> <label for="M"><font color=red>Masculin</font></label>
		<input type="radio" name="sexe" value="F" id="2" <?php if((isset($_POST["sexe"])=="F") or ($membre['sexe']=="F")){echo "checked";}?>> <label for="F"><font color=red>F&eacute;minin</font></label>
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td colspan="3" align=left>
		<font color=red><b>Date de naissance (jj/mm/aaaa) :</b></font>
		<input type="text" name="jj" size="1" value="<?php if(isset($_POST["jj"])){ echo $_POST["jj"];}else {echo $membre['jj'];} ?>" maxlength="2" onkeyup="Autotab(2, this.value, this.size)" id="id_1">
		<input type="text" name="mm" size="1" value="<?php if(isset($_POST["mm"])){ echo $_POST["mm"];}else {echo $membre['mm'];} ?>" maxlength="2" onkeyup="Autotab(3, this.value, this.size);" id="id_2">
		<input type="text" name="aaaa" size="2" value="<?php if(isset($_POST["aaaa"])){ echo $_POST["aaaa"];}else {echo $membre['aaaa'];} ?>" maxlength="4" onkeyup="calcul_ans()" id="id_3">
		&nbsp;&nbsp;Soit <b><font color=red id="ans" ></font></b> ans.
	</td>
	<td></td>
	<td align=left>
		Poids : <input type="text" name="poids" size="1" value="<?php if(isset($_POST["poids"])){ echo $_POST["poids"];}else {echo $membre['poids'];} ?>" maxlength="3"> Kg
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td  colspan="5" align=left>
		<font color=red><b>Nom des repr&eacute;sentants l&eacute;gaux : </b></font><input type="text" name="representants" size="50" value="<?php if(isset($_POST["representants"])){ echo $_POST["representants"];}else {echo $membre['representants'];} ?>">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td align=left>
		<font>Profession N°1: </font><input type="text" name="profession1" size="25" value="<?php if(isset($_POST["profession1"])){ echo $_POST["profession1"]; }else {echo $membre['profession1'];} ?>">
	</td><td></td>
	<td colspan="3" align=left>
		<font>Profession N°2: </font><input type="text" name="profession2" size="25" value="<?php if(isset($_POST["profession2"])){ echo $_POST["profession2"]; }else {echo $membre['profession2'];} ?>">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td align=left>
		<font color=red><b>Adresse : </b></font><input type="text" name="adresse" size="30" value="<?php if(isset($_POST["adresse"])){ echo $_POST["adresse"];}else {echo $membre['adresse'];} ?>">
	</td>
	<td></td>
	<td align=left>
		<font color=red><b>Ville : </b></font>
		<select size='1' name='ville' title="Choix de la ville" OnChange="sendData('id='+this.value,'requete_ville_to_cp.php')" onKeyUp="sendData('id='+this.value,'requete_ville_to_cp.php')">
		<?php
		$i=0; // variable de test
		$j=0; // variable pour garder la valeur du premier enregistrement catégorie pour l'affichage
		echo "<option value=0>- ville -</option>";
		mysql_connect($adresse, $user, $pass);
		mysql_select_db($bdd);mysql_set_charset( 'ansi' );
		$ville = mysql_query("SELECT * FROM villes WHERE actif = '1' ORDER BY ville;");
		while($boucle = mysql_fetch_array($ville)){
		if($membre['ville'] == $boucle[0]){
			echo "<option value='".$boucle[0]."' selected>".$boucle[3]."</option>";
		}else{
			echo "<option value='".$boucle[0]."'>".$boucle[3]."</option>";
		}
		if ($i==0) { $j=$boucle[0]; $i=1; }
		}
		?>
		</select>
	</td>
	<td></td>
	<td align=left id="contenu" width=200>
	<font color=red><b>CP : </b></font>
	<?php  
	// affichage des sous-catégorie appartenant à la première catégorie.
		
    $rq="Select * from cp where (id=".$j.");";
    $result= mysql_query ($rq) or die ("Select impossible");
     // $i = initialise le variable i
    $i=0;
    $cp = mysql_fetch_array($result);
	if(isset($_POST["cp"])){ $retour_cp=$_POST["cp"]; }else{ $retour_cp=$membre['cp']; }
	echo "<input type=\"text\" name=\"cp\" size=\"4\" maxlength=\"5\" value=\"".$retour_cp."\">";  
	?></td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td align=left>
		<font color=red><b>Mail : </b></font><input type="text" name="mail" size="25" value="<?php if(isset($_POST["mail"])){ echo $_POST["mail"];}else {echo $membre['mail'];} ?>">
	</td>
	<td></td>
	<td align=left>
		Tel. Domicile : <input type="text" name="tel_dom" size="9" value="<?php if(isset($_POST["tel_dom"])){ echo $_POST["tel_dom"];}else {echo $membre['tel_dom'];} ?>" maxlength="10">
	</td>
	<td></td>
	<td align=left>
		Tel. Portable : <input type="text" name="tel_port" size="9" value="<?php if(isset($_POST["tel_port"])){ echo $_POST["tel_port"];}else {echo $membre['tel_port'];} ?>" maxlength="10">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<td colspan="3" align=left >
		<font color=red><b>Personne &agrave; pr&eacute;venir en cas d'urgence : </b></font><input type="text" name="urgence" size="30" value="<?php if(isset($_POST["urgence"])){ echo $_POST["urgence"];}else {echo $membre['urgence'];} ?>">
	</td>
	<td></td>
	<td align=left>
		Tel. : <input type="text" name="tel_urg" size="9" value="<?php if(isset($_POST["tel_urg"])){ echo $_POST["tel_urg"];}else {echo $membre['tel_urg'];} ?>" maxlength="10">
	</td>
	</tr>
	<tr height=10>
	<td></td><td></td><td></td><td></td>
	</tr>
	</table>
		Observations : <br><textarea name="obs" cols="33" rows="5"><?php if(isset($_POST["obs"])){ echo $_POST["obs"];} else {echo stripslashes($membre['obs']);} ?></textarea><br><br>
		<input type="submit" value="Enregistrer">&nbsp;&nbsp;&nbsp;<input type="reset" value="Effacer">&nbsp;&nbsp;&nbsp;<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_membres.php';">
		<input type="hidden" name="id_membre" value="<?php echo $id;?>">
	</form>
</fieldset>
</center>
<?php } ?>
</body>
</html>