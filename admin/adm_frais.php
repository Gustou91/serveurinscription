<?php include "../restrict/config.php";?>
<?php
//DESC   ASC
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$frais = mysql_query("SELECT * FROM frais WHERE actif = '1' ORDER BY classement;");
$frais_sup = mysql_query("SELECT * FROM frais WHERE actif = '0' ORDER BY classement;");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
//compte le nombre de frais
$ctrl_frais = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM frais WHERE actif = '1'");
$ctrl_frais = mysql_fetch_array($ctrl_frais);
$ctrl_frais = $ctrl_frais['nbre_entrees'];
//compte le nombre de frais suprim&eacute;s
$ctrl_frais_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM frais WHERE actif = '0'");
$ctrl_frais_sup = mysql_fetch_array($ctrl_frais_sup);
$ctrl_frais_sup = $ctrl_frais_sup['nbre_entrees'];
mysql_close();
//fin travail sur BDD
?>
<script type="text/javascript">
		function OpenBooking_modif(id) {
			window.open("../act_modif_frais.php?id_frais=" + id, "modif_frais", "width=415, height=330, left=" + (screen.width-415)/2 + ", top=" + (screen.height-330)/2);
		}
		function OpenBooking_sup(id) {
			window.open("../act_sup_frais.php?id_frais=" + id, "sup_frais", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("../act_retablir_frais.php?id_frais=" + id, "retablir_frais", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_ajouter() {
			window.open("../ajout_frais.php", "ajouter_frais", "width=420, height=330, left=" + (screen.width-420)/2 + ", top=" + (screen.height-330)/2);
		}
</script>
<body>
<form method="post" action="adm_frais.php">
<center>
<?php
if ($ctrl_frais == 0){
echo "<br>Aucun frais n'est actifs dans la base de donn&eacute;es.<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="frais">Liste des frais activ&eacute;s</a></span><br><a href="#frais_sup">Aller directement aux frais suprim&eacute;es</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Tarifs (€)</th>
	<th>Obligatoire</th>
	<th>Caution</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($frais)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle['nom']; ?></center></td>
<td><center><?php echo ($boucle['prix']*1); ?></center></td>
<td><center><?php if($boucle['obligatoire']==1){echo "Oui";}else{echo "Non";}; ?></center></td>
<td><center><?php if($boucle['caution']==1){echo "Oui";}else{echo "Non";}; ?></center></td>
<td><center><?php if(($boucle['obs']) != NULL) {echo nl2br($boucle['obs']);} ?></center></td>
<td style="text-align:center">
<button onClick="OpenBooking_modif(<?php echo $boucle['id']; ?>)">Modifier</button>&nbsp;
<button onClick="OpenBooking_sup(<?php echo $boucle['id']; ?>)">Suprimer</button>
</td>
</tr>
<?php
$variable++;
}
?>
</table><br><br>
<?php if ($ctrl_frais_sup == 0){ ?>
<button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>
<?php
}
if ($ctrl_frais_sup != 0){
?>
<center>
<span id="title" style="font-size:24px"><a name="frais_sup">Liste des frais Supprim&eacute;s</a></span><br><a href="#frais">Aller directement aux frais actifs</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Tarifs (€)</th>
	<th>Obligatoire</th>
	<th>Caution</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($frais_sup)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle_sup['nom']; ?></center></td>
<td><center><?php echo $boucle_sup['prix']; ?></center></td>
<td><center><?php if($boucle['obligatoire']==1){echo "Oui";}else{echo "Non";}; ?></center></td>
<td><center><?php if($boucle['caution']==1){echo "Oui";}else{echo "Non";}; ?></center></td>
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
</body>
<?php
}
if (($ctrl_frais == 0) AND ($ctrl_frais_sup == 0)){
?>
<br><br><button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>