<?php
include "restrict/config.php";
if((isset($_REQUEST["id_activite"]) && !empty($_REQUEST["id_activite"]))){
$id = $_REQUEST["id_activite"];
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
$activite = mysql_query("SELECT * FROM activites WHERE id = $id");
$activite = mysql_fetch_array($activite);
$tarifs = mysql_query("SELECT * FROM tarifs_activites WHERE id_activites = $id AND actif='1' ORDER BY nom");
$tarifs_sup = mysql_query("SELECT * FROM tarifs_activites WHERE id_activites = $id AND actif='0' ORDER BY nom");
//compte le nombre de tarifs
$ctrl_tarifs = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM tarifs_activites WHERE id_activites = $id  AND actif='1'");
$ctrl_tarifs = mysql_fetch_array($ctrl_tarifs);
$ctrl_tarifs = $ctrl_tarifs['nbre_entrees'];
//compte le nombre de tarifs suprim&eacute;s
$ctrl_tarifs_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM tarifs_activites WHERE id_activites = $id AND actif = '0'");
$ctrl_tarifs_sup = mysql_fetch_array($ctrl_tarifs_sup);
$ctrl_tarifs_sup = $ctrl_tarifs_sup['nbre_entrees'];
mysql_close();
}
else{ echo "<center>Il y a eu une erreur dans la lecture de la base de donn&eacute;e, l'activit&eacute; n'existe plus...</center>";}
?>
<script type="text/javascript">
		function OpenBooking_ajouter(id) {
			window.open("ajout_tarifs.php?id_activite=" + id, "ajout_tarifs", "width=415, height=330, left=" + (screen.width-415)/2 + ", top=" + (screen.height-430)/2);
		}
		function OpenBooking_sup(id) {
			window.open("act_sup_tarifs.php?id_tarif=" + id, "sup_tarif", "width=125, height=75, left=" + (screen.width-125)/2 + ", top=" + (screen.height-75)/2);
		}
		function OpenBooking_modif(id) {
			window.open("act_modif_tarifs.php?id_tarif=" + id + "&id_activite=<?php echo $id; ?>", "modif_tarifs", "width=415, height=330, left=" + (screen.width-415)/2 + ", top=" + (screen.height-430)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("act_retablir_tarifs.php?id_tarif=" + id, "retablir_tarif", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
</script>
<body>
<center>
Ensenble des tarifs concernant l'activit&eacute;<br><font color=red><b><?php echo $activite['nom']; ?></b></font><br>
<?php
if ($ctrl_tarifs == 0){
echo "<br><br>Aucun tarifs n'est enregistr&eacute;";
}
else{
?>
<span id="title" style="font-size:24px"><a name="tarifs">Liste des tarifs activ&eacute;s</a></span><br><a href="#tarifs_sup">Aller directement aux tarifs suprim&eacute;s</a>
<table border=1 class="table4">
<tr>
	<th>Intitul&eacute;</th>
	<th>Tarif (€)</th>
	<th>Obligatoire</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($tarifs)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td><center><?php echo $boucle['nom']; ?></center></td>
<td><center><?php echo ($boucle['prix']/1); ?></center></td>
<td><center><?php if($boucle['obligatoire']==1){echo "Oui";}else{echo "Non";}; ?></center></td>
<td><center><?php if(($boucle['obs']) != NULL) {echo nl2br($boucle['obs']);} ?></center></td>
<td style="text-align:center">
<button onClick="OpenBooking_modif(<?php echo $boucle['id']; ?>)">Modifier</button>&nbsp;
<button onClick="OpenBooking_sup(<?php echo $boucle['id']; ?>)">Supprimer</button>
</td>
</tr>
<?php
$variable++;
}
?>
</table><br>
<?php }
if ($ctrl_tarifs_sup != 0){
?>
<span id="title" style="font-size:24px"><a name="tarifs_sup">Liste des tarifs Supprim&eacute;es</a></span><br><a href="#tarifs">Aller directement aux tarifs actifs</a>
<table border=1 class="table4">
<tr>
	<th>Intitul&eacute;</th>
	<th>Tarif (€)</th>
	<th>Obligatoire</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($tarifs_sup)){
if($variable%2){$couleur = "#FFFF99";}else{$couleur = "#99FFCC";}
?>
<tr style="background:<?php echo $couleur;?>;">
<td><center><?php echo $boucle_sup['nom']; ?></center></td>
<td><center><?php echo $boucle_sup['prix']; ?></center></td>
<td><center><?php if($boucle_sup['obligatoire']==1){echo "Oui";}else{echo "Non";}; ?></center></td>
<td><center><?php if(($boucle_sup['obs']) != NULL) {echo nl2br($boucle_sup['obs']);} ?></center></td>
<td style="text-align:center"><button onClick="OpenBooking_retablir(<?php echo $boucle_sup['id']; ?>)">R&eacute;tablir</button></td>
</td>
</tr>
<?php
$variable++;
}
?>
</table>
</form>
<?php
}
?>
<br><br><button onClick="OpenBooking_ajouter(<?php echo $id; ?>)">Ajouter</button>&nbsp;&nbsp;
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_activites.php';">
</center>
</body>
</html>