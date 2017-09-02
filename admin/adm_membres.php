<?php include "../restrict/config.php";?>

<?php
//DESC   ASC
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$membres = mysql_query("SELECT * FROM membres WHERE actif = '1' ORDER BY nom");
$membres_sup = mysql_query("SELECT * FROM membres WHERE actif = '0' ORDER BY nom");
$couleur_01 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_01'");
$couleur_01 = mysql_fetch_array($couleur_01);
$couleur_02 = mysql_query("SELECT valeur FROM generale WHERE nom='couleur_02'");
$couleur_02 = mysql_fetch_array($couleur_02);
//compte le nombre de membres
$ctrl_membres = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM membres WHERE actif = '1'");
$ctrl_membres = mysql_fetch_array($ctrl_membres);
$ctrl_membres = $ctrl_membres['nbre_entrees'];
//compte le nombre de membres suprim&eacute;s
$ctrl_membres_sup = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM membres WHERE actif = '0'");
$ctrl_membres_sup = mysql_fetch_array($ctrl_membres_sup);
$ctrl_membres_sup = $ctrl_membres_sup['nbre_entrees'];
//fin travail sur BDD
?>
<script type="text/javascript">
		function OpenBooking_modif(id) {
			window.open("../act_modif_membre.php?id_membre=" + id, "modif_membre", "width=790, height=480, left=" + (screen.width-790)/2 + ", top=" + (screen.height-480)/2);
		}
		function OpenBooking_sup(id) {
			window.open("../act_sup_membres.php?page=1&id_membre=" + id, "sup_membre", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_retablir(id) {
			window.open("../act_retablir_membres.php?id_membre=" + id, "retablir_membre", "width=250, height=100, left=" + (screen.width-250)/2 + ", top=" + (screen.height-100)/2);
		}
		function OpenBooking_ajouter() {
			window.open("../ajout_membre.php?page=adm_membres", "ajouter_membre", "width=750, height=560, left=" + (screen.width-500)/2 + ", top=" + (screen.height-560)/2);
		}
</script>
<body>
<form method="post" action="adm_membres.php">
<center>
<?php
if ($ctrl_membres == 0){
echo "<br>Aucun membre n'est actif dans la base de donn&eacute;es.<br>";
}
else{
?>
<span id="title" style="font-size:24px"><a name="membres">Liste des membres activ&eacute;s</a></span><br><a href="#membres_sup">Aller directement aux membres supprim&eacute;s</a>
<table  class="table4" summary="">
<tr>
	<th>ID</th>
	<th>Nom</th>
	<th>Prenom</th>
	<th>Sexe</th>
	<th>Naissance</th>
	<th width=43>Poids</th>
	<th>Repr&eacute;sentants</th>
	<th>Profession 1</th>
	<th>Profession 2</th>
	<th>Adresse</th>
	<th>mail</th>
	<th>T&eacute;l&eacute;phone</th>
	<th>Portable</th>
	<th>Urgence</th>
	<th>T&eacute;l&eacute;phone</th>
	<th>Observations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle = mysql_fetch_array($membres)){
if($boucle['cp']>9500){
$cp = $boucle['cp'];
}else{
$id_cp=$boucle['cp'];
$cp = mysql_query("SELECT cp FROM cp WHERE id='$id_cp'");
$cp = mysql_fetch_array($cp);
$cp = $cp['cp'];
}
if($boucle['ville']>0){
$id_ville=$boucle['ville'];
$ville = mysql_query("SELECT ville FROM villes WHERE id='$id_ville'");
$ville = mysql_fetch_array($ville);
$ville = $ville['ville'];
}else{
$ville = $boucle['ville'];
}
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle['id']; ?></center></td>
<td><center><?php echo $boucle['nom']; ?></center></td>
<td><center><?php echo $boucle['prenom']; ?></center></td>
<td><center><?php echo $boucle['sexe']; ?></center></td>
<td><center><?php echo $boucle['jj']; ?>/<?php echo $boucle['mm']; ?>/<?php echo $boucle['aaaa']; ?></center></td>
<td><center><?php echo $boucle['poids']." kg"; ?></center></td>
<td><center><?php echo $boucle['representants']; ?></center></td>
<td><center><?php echo $boucle['profession1']; ?></center></td>
<td><center><?php echo $boucle['profession2']; ?></center></td>
<td><center><?php echo $boucle['adresse']; ?><br><?php echo $cp; ?> <?php echo $ville; ?></center></td>
<td><center><A HREF="mailto:<?php echo $boucle['mail']; ?>"><?php echo $boucle['mail']; ?></a></center></td>
<td><center><?php echo $boucle['tel_dom']; ?></center></td>
<td><center><?php echo $boucle['tel_port']; ?></center></td>
<td><center><?php echo $boucle['urgence']; ?></center></td>
<td><center><?php echo $boucle['tel_urg']; ?></center></td>
<td><center><?php if(($boucle['obs']) != NULL) {echo nl2br(stripslashes($boucle['obs']));} ?></center></td>
<td style="text-align:center">
<button onClick="OpenBooking_modif(<?php echo $boucle['id']; ?>)">Modif</button><br>
<button onClick="OpenBooking_sup(<?php echo $boucle['id']; ?>)">Sup</button>
</td>
</tr>
<?php
$variable++;
}
?>
</table><br><br>
<?php if ($ctrl_membres_sup == 0){ ?>
<button onClick="OpenBooking_ajouter()">Ajouter</button>
<?php } ?>
</center>
<?php
}
if ($ctrl_membres_sup != 0){
?>
<center>
<span id="title" style="font-size:24px"><a name="membres_sup">Liste des membres Supprim&eacute;es</a></span><br><a href="#membres">Aller directement aux activit&eacute;s actives</a>
<table  class="table4" summary="">
<tr>
	<th>Nom</th>
	<th>Prenom</th>
	<th>Sexe</th>
	<th>Naissance</th>
	<th>Poids</th>
	<th>Repr&eacute;sentants</th>
	<th>Profession 1</th>
	<th>Profession 2</th>
	<th>Adresse</th>
	<th>mail</th>
	<th>T&eacute;l&eacute;phone</th>
	<th>Portable</th>
	<th>Urgence</th>
	<th>T&eacute;l&eacute;phone</th>
	<th>Obsercations</th>
	<th></th>
</tr>
<?php
$variable = 0;
while($boucle_sup = mysql_fetch_array($membres_sup)){
if($variable%2){$couleur = $couleur_01['valeur'];}else{$couleur = $couleur_02['valeur'];}
?>
<tr style="background:<?php echo $couleur;?>;">
<td height="15"><center><?php echo $boucle_sup['nom']; ?></center></td>
<td><center><?php echo $boucle_sup['prenom']; ?></center></td>
<td><center><?php echo $boucle_sup['sexe']; ?></center></td>
<td><center><?php echo $boucle_sup['jj']; ?>/<?php echo $boucle_sup['mm']; ?>/<?php echo $boucle_sup['aaaa']; ?></center></td>
<td><center><?php echo $boucle_sup['poids']; ?> kg</center></td>
<td><center><?php echo $boucle_sup['representants']; ?></center></td>
<td><center><?php echo $boucle_sup['profession1']; ?></center></td>
<td><center><?php echo $boucle_sup['Profession2']; ?></center></td>
<td><center><?php echo $boucle_sup['adresse']; ?><br><?php echo $boucle_sup['cp']; ?> <?php echo $boucle_sup['ville']; ?></center></td>
<td><center><?php echo $boucle_sup['mail']; ?></center></td>
<td><center><?php echo $boucle_sup['tel_dom']; ?></center></td>
<td><center><?php echo $boucle_sup['tel_port']; ?></center></td>
<td><center><?php echo $boucle_sup['urgence']; ?></center></td>
<td><center><?php echo $boucle_sup['tel_urg']; ?></center></td>
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
</body>
<?php
mysql_close();
}
?>