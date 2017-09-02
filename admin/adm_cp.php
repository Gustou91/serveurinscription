<?php include "../restrict/config.php";?>
<?php
//DESC   ASC
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$cp = mysql_query("SELECT * FROM cp WHERE actif = '1' ORDER BY cp;");
$cp_sup = mysql_query("SELECT * FROM cp WHERE actif = '0' ORDER BY cp;");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
//compte le nombre de cp
$ctrl_cp = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM cp WHERE actif = '1'");
$ctrl_cp = mysql_fetch_array($ctrl_cp);
$ctrl_cp = $ctrl_cp['nbre_entrees'];
//compte le nombre de cp suprim&eacute;s
$ctrl_cp_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM cp WHERE actif = '0'");
$ctrl_cp_sup = mysql_fetch_array($ctrl_cp_sup);
$ctrl_cp_sup = $ctrl_cp_sup['nbre_entrees'];

//fin travail sur BDD
?>
<html>
<script type="text/javascript">
		function OpenBooking_sup(id) {
			window.open("../act_sup_cp.php?id_cp=" + id, "sup_cp", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("../act_retablir_cp.php?id_cp=" + id, "retablir_cp", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_ajouter() {
			window.open("../ajout_cp.php?adm_cp", "ajouter_cp", "resizable=no, width=500, height=320, left=" + (screen.width-500)/2 + ", top=" + (screen.height-320)/2);
		}
</script>
<body>
<form method="post" action="adm_cp.php">
<center>
<?php
if ($ctrl_cp == 0){
echo "<br>Aucune activit&eacute;s n'est actives dans la base de donn&eacute;es.<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="cp">Liste des CP actifs</a></span><br><a href="#cp_sup">Aller directement aux CP suprim&eacute;s</a>
<table  class="table4" summary="">
<tr>
	<th>CP</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($cp)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle['cp']; ?></center></td>
<td><center><?php if(($boucle['obs']) != NULL) {echo nl2br($boucle['obs']);} ?></center></td>
<td style="text-align:center">
<button onClick="OpenBooking_sup(<?php echo $boucle['id']; ?>)">Supprimer</button>
</td>
</tr>
<?php
$variable++;
}
?>
</table><br><br>
<?php if ($ctrl_cp_sup == 0){ ?>
<button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>
<?php
}
if ($ctrl_cp_sup != 0){
?>
<center>
<span id="title" style="font-size:24px"><a name="cp_sup">Liste des CP Supprim&eacute;s</a></span><br><a href="#cp">Aller directement CP actifs</a>
<table  class="table4" summary="">
<tr>
	<th>CP</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($cp_sup)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle_sup['cp']; ?></center></td>
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
if (($ctrl_cp == 0) AND ($ctrl_cp_sup == 0)){
?>
<br><br><button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } 
mysql_close();
?>
</body>
</html>