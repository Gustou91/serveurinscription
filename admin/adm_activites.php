<?php include "../restrict/config.php";?>
<?php
//DESC   ASC
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$activites = mysql_query("SELECT * FROM activites WHERE actif = '1' ORDER BY nom;");
$activites_sup = mysql_query("SELECT * FROM activites WHERE actif = '0' ORDER BY nom;");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
//compte le nombre de activites
$ctrl_activites = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM activites WHERE actif = '1'");
$ctrl_activites = mysql_fetch_array($ctrl_activites);
$ctrl_activites = $ctrl_activites['nbre_entrees'];
//compte le nombre de activites suprim&eacute;s
$ctrl_activites_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM activites WHERE actif = '0'");
$ctrl_activites_sup = mysql_fetch_array($ctrl_activites_sup);
$ctrl_activites_sup = $ctrl_activites_sup['nbre_entrees'];
mysql_close();
//fin travail sur BDD
?>
<html>
<script type="text/javascript">
		function OpenBooking_modif(id) {
			window.open("../act_modif_activite.php?id_activite=" + id, "modif_activite", "width=415, height=320, left=" + (screen.width-415)/2 + ", top=" + (screen.height-420)/2);
		}
		function OpenBooking_sup(id) {
			window.open("../act_sup_activite.php?id_activite=" + id, "sup_activite", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("../act_retablir_activite.php?id_activite=" + id, "retablir_activite", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_tarifs(id) {
			window.open("../act_tarifs_activite.php?id_activite=" + id, "tarifs_activite", "scrollbars=1, width=650, height=400, left=" + (screen.width-650)/2 + ", top=" + (screen.height-400)/2);
		}
		function OpenBooking_ajouter() {
			window.open("../ajout_activite.php", "ajouter_activite", "resizable=no, width=500, height=320, left=" + (screen.width-500)/2 + ", top=" + (screen.height-320)/2);
		}
		function OpenBooking_grade(id) {
			window.open("../act_grades_activite.php?id_activite=" + id, "tarifs_activite", "scrollbars=1, width=650, height=600, left=" + (screen.width-650)/2 + ", top=" + (screen.height-600)/2);
		}
</script>
<body>
<form method="post" action="adm_activites.php">
<center>
<?php
if ($ctrl_activites == 0){
echo "<br>Aucune activit&eacute;s n'est actives dans la base de donn&eacute;es.<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="activites">Liste des activit&eacute;s activ&eacute;s</a></span><br><a href="#activites_sup">Aller directement aux activites suprim&eacute;es</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($activites)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle['nom']; ?></center></td>
<td><center><?php if(($boucle['obs']) != NULL) {echo nl2br($boucle['obs']);} ?></center></td>
<td style="text-align:center">
<button onClick="OpenBooking_modif(<?php echo $boucle['id']; ?>)">Modifier</button>&nbsp;
<button onClick="OpenBooking_tarifs(<?php echo $boucle['id']; ?>)">Tarifs</button>&nbsp;
<button onClick="OpenBooking_grade(<?php echo $boucle['id']; ?>)">Grade</button>&nbsp;
<button onClick="OpenBooking_sup(<?php echo $boucle['id']; ?>)">Supprimer</button>
</td>
</tr>
<?php
$variable++;
}
?>
</table><br><br>
<?php if ($ctrl_activites_sup == 0){ ?>
<button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>
<?php
}
if ($ctrl_activites_sup != 0){
?>
<center>
<span id="title" style="font-size:24px"><a name="activites_sup">Liste des activit&eacute;s Supprim&eacute;es</a></span><br><a href="#activites">Aller directement aux activit&eacute;s actives</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($activites_sup)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle_sup['nom']; ?></center></td>
<td><center><?php if(($boucle_sup['obs']) != NULL) {echo nl2br($boucle_sup['obs']);} ?></center></td>
<td style="text-align:center"><button onClick="OpenBooking_retablir(<?php echo $boucle_sup['id']; ?>)">R&eacute;tablir</button></td>
</tr>
<?php
$variable++;
}
?>
</table>
</form>
<br><br><button onClick="OpenBooking_ajouter()">Ajouter</button>
</center>
<?php
}
if (($ctrl_activites == 0) AND ($ctrl_activites_sup == 0)){
?>
<br><br><button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</body>
</html>