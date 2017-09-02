<center>
<?php
include "restrict/config1.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$general = mysql_query("SELECT * FROM generale");
echo '<table border=1>';
while($boucle_general = mysql_fetch_array($general)){
echo '<tr><td>'.$boucle_general['id'].'</td><td>'.$boucle_general['date'].'</td><td>'.$boucle_general['nom'].'</td><td>'.$boucle_general['valeur'].'</td></tr>';
}
echo '</table>';
?>
</center>