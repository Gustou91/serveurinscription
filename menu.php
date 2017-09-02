<?php include "restrict/config.php";?>
<head>

</head>
<body>
<script type="text/javascript">
		function OpenBooking_version() {
			window.open("version.php", "version", "width=700, height=" + (screen.height) + ", left=" + (screen.width-700)/2 + ", top=0, scrollbars=yes");
		}
		function OpenBooking_cnil() {
			window.open("cnil.php", "cnil", "width=700, height=435, left=" + (screen.width-700)/2 + ", top=" + (screen.height-435)/2);
		}
</script>

<center>
<table border=0 height=100% align=center>
<tr><td>
<center>
<?php
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );

$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;
$saison = $annee_actu."/".$annee_suivante;
echo "<font color=blue size=3>saison</font><br><b><font color=red size=5>".$saison."</font></b>";
?>
</center>
</td></tr>
<tr valign=top><td>
<table border=0>
<tr height=10><td></td></tr>
<tr><td align=center>
<form name="10" method="post" action="intro.php" target="site">
		<input type="submit" value="Home">
		</form>
</td></tr>
<tr><td align=center>
<hr>

<tr><td align=center>
<form name="10" method="post" action="inscription_membre.php" target="site">
		<input type="submit" value="Membre & inscription">
		</form>
</td></tr>
<tr><td align=center>
<hr>
<form name="20" method="post" action="ajout_membre.php" target="site">
		<input type="submit" value="Membre">
		</form>
</td></tr>
<tr height=10><td></td></tr>
<tr><td align=center>
<form name="30" method="post" action="ajout_inscription.php" target="site">
		<input type="submit" value="Inscription">
		</form>
</td></tr>
<tr><td align=center>
<hr>
<form name="40" method="post" action="consulter_membres.php" target="site">
		<input type="submit" value="Consulter Membres">
		</form>
</td></tr>
<tr height=10><td></td></tr>
<tr><td align=center>
<form name="50" method="post" action="consulter_inscriptions.php" target="site">
		<input type="submit" value="Consulter Inscriptions"><br>
		<select size='1' name='saison' title="Choix de la saison à afficher">
<?php

$saisons = mysql_query("SELECT saison FROM inscriptions WHERE actif = '1' ORDER BY saison DESC");
$saison="";
while($boucle_saison = mysql_fetch_array($saisons)){
if ($saison !=$boucle_saison['saison']){
$saison = $boucle_saison['saison'];
echo "<option value=".$saison.">".$saison."</option>";
}}
//mysql_close()
?>


</td></tr>
<tr><td align=center>
<hr>
</form>
<form name="60" method="post" action="admin/index.php" target="site">
<input type="submit" value="Administrer">
</form>

</td></tr>
<tr height=10><td></td></tr>
<tr><td align=center>
<form name="70" method="post" action="recherche_anniversaire.php" target="site">
		<fieldset align="center" style="height=max; width=max">
<legend><font color=blue><b>Anniversaires</b></font></legend>
<table border=0>
<tr><td align=right>de </td><td>
<input type="text" name="de_aaaa" size="3" value="<?php echo $annee_actu-20;?>" maxlength="4">
</td></tr><tr><td align=right>à </td><td>
<input type="text" name="a_aaaa" size="3" value="<?php echo $annee_actu-10;?>" maxlength="4">
</td></tr><tr><td colspan=2>
<input type="radio" name="type" value="saison" id="1" > <label for="1">Par Saison</label><br>
</td></tr><tr><td colspan=2>
<input type="radio" name="type" value="general" id="2" checked> <label for="2">G&eacute;n&eacute;ral</label>
</td></tr>
</table>
<input type="submit" value="Rechercher">
</fieldset>
</form>
</td></tr>
<tr height=10><td></td></tr>
<tr><td align=center>
<form name="50" method="post" action="states_nombre_inscrit.php" target="site">
		<input type="submit" value="Stats"><br>
		<select size='1' name='saison' title="Choix de la saison à afficher">
<?php

$saison = mysql_query("SELECT valeur FROM generale WHERE nom = 'saison'");
$saison = mysql_fetch_array($saison);
$annee_actu=$annee_actu+$saison[0];
$annee_suivante=$annee_actu+1;

$saisons = mysql_query("SELECT saison FROM inscriptions WHERE actif = '1' ORDER BY saison DESC");

while($boucle_saison = mysql_fetch_array($saisons)){
if ($saison !=$boucle_saison['saison']){
$saison = $boucle_saison['saison'];
echo "<option value=".$saison.">".$saison."</option>";
}}
$version = mysql_query("SELECT valeur FROM generale WHERE nom = 'version_actuelle'");
$version = mysql_fetch_array($version);
$cnil = mysql_query("SELECT valeur FROM generale WHERE nom = 'cnil'");
$cnil = mysql_fetch_array($cnil);
mysql_close()
?>
</select>
</form>
</td></tr>
</table>
</td></tr>
<tr><td>
<table border=0 align=center>
<tr><td>
<a href="javascript:OpenBooking_version()"><font size=2>Version : <?php echo $version['valeur']; ?></font></a> | <a href="javascript:OpenBooking_cnil()"><font size=2>La loi CNIL</font></a>
</td></tr>
</table>
</td></tr>
</table>
</center>
</body>