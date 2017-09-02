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
$grades = mysql_query("SELECT * FROM grades WHERE id_activites = $id AND actif='1' ORDER BY classement");
$grades_sup = mysql_query("SELECT * FROM grades WHERE id_activites = $id AND actif='0' ORDER BY classement");
//compte le nombre de tarifs
$ctrl_grades = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM grades WHERE id_activites = $id  AND actif='1'");
$ctrl_grades = mysql_fetch_array($ctrl_grades);
$ctrl_grades = $ctrl_grades['nbre_entrees'];
//compte le nombre de tarifs suprim&eacute;s
$ctrl_grades_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM grades WHERE id_activites = $id AND actif = '0'");
$ctrl_grades_sup = mysql_fetch_array($ctrl_grades_sup);
$ctrl_grades_sup = $ctrl_grades_sup['nbre_entrees'];
mysql_close();
}
else{ echo "<center>Il y a eu une erreur dans la lecture de la base de donn&eacute;e, l'activit&eacute; n'existe plus...</center>";}
?>
<script type="text/javascript">
		function OpenBooking_ajouter(id) {
			window.open("ajout_grades.php?id_activite=" + id, "ajout_grades", "width=415, height=330, left=" + (screen.width-415)/2 + ", top=" + (screen.height-430)/2);
		}
		function OpenBooking_sup(id) {
			window.open("act_sup_grades.php?id_grade=" + id, "sup_grade", "width=125, height=75, left=" + (screen.width-125)/2 + ", top=" + (screen.height-75)/2);
		}
		function OpenBooking_modif(id) {
			window.open("act_modif_grades.php?id_grade=" + id + "&id_activite=<?php echo $id; ?>", "modif_grade", "width=415, height=335, left=" + (screen.width-415)/2 + ", top=" + (screen.height-335)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("act_retablir_grades.php?id_grade=" + id, "retablir_grade", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
</script>
<body>
<center>
Ensenble des grades concernant l'activit&eacute;<br><font color=red><b><?php echo $activite['nom']; ?></b></font><br>
<?php
if ($ctrl_grades == 0){
echo "Aucun grade n'est enregistr&eacute;<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="tarifs">Liste des grades activ&eacute;s</a></span><br><a href="#grades_sup">Aller directement aux grades supprim&eacute;s</a>
<table border=1 class="table4">
<tr>
	<th>Nom</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($grades)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td><center><?php echo $boucle['nom']; ?></center></td>
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
if ($ctrl_grades_sup != 0){
?>
<span id="title" style="font-size:24px"><a name="tarifs_sup">Liste des grades Supprim&eacute;es</a></span><br><a href="#grades">Aller directement aux grades actifs</a>
<table border=1 class="table4">
<tr>
	<th>Nom</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($grades_sup)){
if($variable%2){$couleur = "#FFFF99";}else{$couleur = "#99FFCC";}
?>
<tr style="background:<?php echo $couleur;?>;">
<td><center><?php echo $boucle_sup['nom']; ?></center></td>
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
</center>
<?php
}
?>
<center>
<button onClick="OpenBooking_ajouter(<?php echo $id; ?>)">Ajouter</button>&nbsp;&nbsp;
<input type="button" value="FERMER" onclick="Javascript:window.close(); opener.location = 'admin/adm_activites.php';">
</center>
</body>
</html>