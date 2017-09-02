<?php
include "../restrict/config.php";
echo "<br><br><center><b>Le backup est fini</b></center>";
echo "<br><center>Le fichier se trouve ici : \\\\serveur\web\Backups</center>";
backup($adresse, $bdd, $user, $pass);
/*
 * Make a gzipped backup of the whole database
 */
function backup($host, $db, $user, $pass) {
    //$host = HOST;
    //$db = DB;
    //$user = USER;
    //$pass = PASS;
    $file = 'backup_'.@date("Y-m-d-H-i").'.sql';
    die(system("mysqldump --add-drop-table --create-options --skip-lock-tables --extended-insert --quick --set-charset --host=$host --user=$user --password=$pass $db > ../Backups/$file"));
}
?>