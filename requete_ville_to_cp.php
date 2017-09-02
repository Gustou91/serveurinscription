<?php
header('Content-type: text') ; // on déclare ce qui va être afficher
 // test des POST emis
include "restrict/config.php";
if(isset($_POST['id']) && !empty($_POST['id']) ){
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'ansi' );
	$rq="SELECT * FROM villes WHERE id='".$_POST['id']."';";
	$result= mysql_query ($rq);
	$ville = mysql_fetch_array($result);
	$id_ville=$ville[2];
	$rq="SELECT * FROM cp WHERE id='".$id_ville."';";
    $result= mysql_query ($rq) or die ("Select impossible");
	$cp = mysql_fetch_array($result);
     // $i = initialise la variable i
    $i=0;
	echo "<font color=red><b>CP : </b></font>";
	
	if ($cp[2]>999)
	{
		echo "<input type=\"text\" name=\"cp\" size=\"4\" maxlength=\"2\" value=\"".utf8_encode($cp[2])."\">"; 
	}
	else
	{
		
		echo utf8_encode("Aucun Code Postal n'est<br>enregistré pour cette ville.");	
	}
}
else{
echo "<font color=red><b>CP : </b></font>";
echo "<input type=\"text\" name=\"cp\" size=\"4\" maxlength=\"5\" value=\"CP\">";
}
?>