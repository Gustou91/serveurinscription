<?php include "../restrict/config.php";?>
<?php
//DESC   ASC
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$villes = mysql_query("SELECT * FROM villes WHERE actif = '1' ORDER BY ville;");
$villes_sup = mysql_query("SELECT * FROM villes WHERE actif = '0' ORDER BY ville;");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
//compte le nombre de villes
$ctrl_villes = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM villes WHERE actif = '1'");
$ctrl_villes = mysql_fetch_array($ctrl_villes);
$ctrl_villes = $ctrl_villes['nbre_entrees'];
//compte le nombre de villes suprim&eacute;s
$ctrl_villes_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM villes WHERE actif = '0'");
$ctrl_villes_sup = mysql_fetch_array($ctrl_villes_sup);
$ctrl_villes_sup = $ctrl_villes_sup['nbre_entrees'];

//fin travail sur BDD
?>
<html>
<script type="text/javascript">
		function OpenBooking_modif(id) {
			window.open("../act_modif_ville.php?id_ville=" + id, "modif_ville", "width=415, height=320, left=" + (screen.width-415)/2 + ", top=" + (screen.height-420)/2);
		}
		function OpenBooking_sup(id) {
			window.open("../act_sup_ville.php?id_ville=" + id, "sup_ville", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("../act_retablir_ville.php?id_ville=" + id, "retablir_ville", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_ajouter() {
			window.open("../ajout_ville.php", "ajouter_ville", "resizable=no, width=500, height=320, left=" + (screen.width-500)/2 + ", top=" + (screen.height-320)/2);
		}
</script>
<body>
<form method="post" action="adm_villes.php">
<center>
<?php
if ($ctrl_villes == 0){
echo "<br>Aucune activit&eacute;s n'est actives dans la base de donn&eacute;es.<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="villes">Liste des villes et leur CP actifs</a></span><br><a href="#villes_sup">Aller directement aux villes et leur CP suprim&eacute;es</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>CP</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($villes)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
$id_cp=$boucle['id_cp'];
$cp = mysql_query("SELECT cp FROM cp WHERE id='$id_cp'");
$cp = mysql_fetch_array($cp);
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle['ville']; ?></center></td>
<td height="15"><center><?php echo $cp['cp']; ?></center></td>
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
</table><br><br>
<?php if ($ctrl_villes_sup == 0){ ?>
<button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>
<?php
}
if ($ctrl_villes_sup != 0){
?>
<center>
<span id="title" style="font-size:24px"><a name="villes_sup">Liste des villes et leurs CP Supprim&eacute;s</a></span><br><a href="#villes">Aller directement aux villes et leurs CP actifs</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>CP</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($villes_sup)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
$id_cp=$boucle_sup['id_cp'];
$cp = mysql_query("SELECT cp FROM cp WHERE id='$id_cp'");
$cp = mysql_fetch_array($cp);
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle_sup['ville']; ?></center></td>
<td height="15"><center><?php echo $cp['cp']; ?></center></td>
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
if (($ctrl_villes == 0) AND ($ctrl_villes_sup == 0)){
?>
<br><br><button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } 
mysql_close();
?>
</body>
</html>