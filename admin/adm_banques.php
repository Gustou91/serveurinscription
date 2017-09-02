<?php include "../restrict/config.php";?>
<?php
//DESC   ASC
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$banques = mysql_query("SELECT * FROM banques WHERE actif = '1' ORDER BY banque;");
$banques_sup = mysql_query("SELECT * FROM banques WHERE actif = '0' ORDER BY banque;");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
//compte le nombre de banques
$ctrl_banques = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM banques WHERE actif = '1'");
$ctrl_banques = mysql_fetch_array($ctrl_banques);
$ctrl_banques = $ctrl_banques['nbre_entrees'];
//compte le nombre de banques suprimées
$ctrl_banques_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM banques WHERE actif = '0'");
$ctrl_banques_sup = mysql_fetch_array($ctrl_banques_sup);
$ctrl_banques_sup = $ctrl_banques_sup['nbre_entrees'];
mysql_close();
//fin travail sur BDD
?>
<html>
<script type="text/javascript">
		function OpenBooking_modif(id) {
			window.open("../act_modif_banque.php?id_banque=" + id, "modif_banques", "width=415, height=320, left=" + (screen.width-415)/2 + ", top=" + (screen.height-420)/2);
		}
		function OpenBooking_sup(id) {
			window.open("../act_sup_banque.php?id_banque=" + id, "sup_banques", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("../act_retablir_banque.php?id_banque=" + id, "retablir_banques", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_ajouter() {
			window.open("../ajout_banque.php", "ajouter_banques", "resizable=no, width=500, height=320, left=" + (screen.width-500)/2 + ", top=" + (screen.height-320)/2);
		}
</script>
<body>
<form method="post" action="adm_banques.php">
<center>
<?php
if ($ctrl_banques == 0){
echo "<br>Aucune banques n'est actives dans la base de donn&eacute;es.<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="banques">Liste des banques activ&eacute;s</a></span><br><a href="#banques_sup">Aller directement aux banques suprim&eacute;es</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($banques)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle['banque']; ?></center></td>
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
<?php if ($ctrl_banques_sup == 0){ ?>
<button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>
<?php
}
if ($ctrl_banques_sup != 0){
?>
<center>
<span id="title" style="font-size:24px"><a name="banques_sup">Liste des banques Supprim&eacute;es</a></span><br><a href="#banques">Aller directement aux banques actives</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($banques_sup)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle_sup['banque']; ?></center></td>
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
if (($ctrl_banques == 0) AND ($ctrl_banques_sup == 0)){
?>
<br><br><button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</body>
</html>