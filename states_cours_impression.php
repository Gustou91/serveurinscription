<html>
<head>
</head>
<?php
include "restrict/config1.php";
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);mysql_set_charset( 'ansi' );
$parametres = mysql_query("SELECT * FROM generale WHERE nom='imprimer'");
$parametres = mysql_fetch_array($parametres);
?>
<body <?php if($parametres['valeur'] == "OUI"){echo "onload=\"window.print()\""; }?>>
<center><input type="button" value="Retour" onclick="history.go( -1 );return true;">
<?php include "restrict/config1.php";

$ok=0;
if(isset($_POST['id_cours']) && !empty($_POST['id_cours'])){
$ok++;
$id_cours=$_POST['id_cours'];
}
if(isset($_POST['annee_1']) && !empty($_POST['annee_1']) ){
$ok++;
$annee_1=$_POST['annee_1'];
}
if(isset($_POST['annee_2']) && !empty($_POST['annee_2']) ){
$ok++;
$annee_2=$_POST['annee_2'];
}
if($ok == 3){
	$colonne_1 = $_POST['colonne_1'];
	$colonne_2 = $_POST['colonne_2'];
	$colonne_3 = $_POST['colonne_3'];
	$colonne_4 = $_POST['colonne_4'];
	$colonne_5 = $_POST['colonne_5'];
	$colonne_6 = $_POST['colonne_6'];
	
	if($colonne_1 == "adresse"){$colonne_1_entete = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$colonne_1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$colonne_1_entete = $colonne_1;}
	if($colonne_2 == "adresse"){$colonne_2_entete = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$colonne_2."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$colonne_2_entete = $colonne_2;}
	if($colonne_3 == "adresse"){$colonne_3_entete = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$colonne_3."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$colonne_3_entete = $colonne_3;}
	if($colonne_4 == "adresse"){$colonne_4_entete = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$colonne_4."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$colonne_4_entete = $colonne_4;}
	if($colonne_5 == "adresse"){$colonne_5_entete = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$colonne_5."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$colonne_5_entete = $colonne_5;}
	if($colonne_6 == "adresse"){$colonne_6_entete = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$colonne_6."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$colonne_6_entete = $colonne_6;}
		
	if($_POST['classement'] == ""){
		$classement = "";
	}elseif($_POST['classement'] == "1"){
		$classement = $colonne_1;
	}elseif($_POST['classement'] == "2"){
		$classement = $colonne_2;
	}elseif($_POST['classement'] == "3"){
		$classement = $colonne_3;
	}elseif($_POST['classement'] == "4"){
		$classement = $colonne_4;
	}elseif($_POST['classement'] == "5"){
		$classement = $colonne_5;
	}elseif($_POST['classement'] == "6"){
		$classement = $colonne_6;
	}
function build_sorter($classement) {
    return function ($a, $b) use ($classement) {
        return strcasecmp($a[$classement], $b[$classement]);
    };
}
	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'ansi' );
	$saison = $annee_1."/".$annee_2;
	$cours = mysql_query("SELECT * FROM cours WHERE id = '$id_cours'");
	$cours = mysql_fetch_array($cours);
	echo "Saison : ".$annee_1." / ".$annee_2;
	?>
	</center>
	<table border=1 width=100%>
	<?php
	echo "<th width=1><b>".$colonne_1_entete."</b></th>";
	if($colonne_2 <> "")
		echo "<th width=1><b>".$colonne_2_entete."</b></th>";
	if($colonne_3 <> "")
		echo "<th width=1><b>".$colonne_3_entete."</b></th>";
	if($colonne_4 <> "")
		echo "<th width=1><b>".$colonne_4_entete."</b></th>";
	if($colonne_5 <> "")
		echo "<th width=1><b>".$colonne_5_entete."</b></th>";
	if($colonne_6 <> "")
		echo "<th width=1><b>".$colonne_6_entete."</b></th>";
	echo "<th width=100%></th>";

	$variable=0;
	$array;
	$inscription_cours = mysql_query("SELECT id_inscriptions FROM inscriptions_cours WHERE id_cours = '$id_cours' AND actif='1'");
	while($boucle_inscription_cours = mysql_fetch_array($inscription_cours)){
		$id_inscription = $boucle_inscription_cours['id_inscriptions'];
		$inscription = mysql_query("SELECT id_membre FROM inscriptions WHERE saison = '$saison' AND id = '$id_inscription' AND actif = '1'");
		$inscription = mysql_fetch_array($inscription);
		$id_membre = $inscription['id_membre'];
		$membre = mysql_query("SELECT * FROM membres WHERE id = '$id_membre'");
		$membre = mysql_fetch_array($membre);
		if(isset($membre['id'])){
			if($colonne_1 <> ""){
				if($colonne_1 == "aaaa/mm/jj"){
					if($membre["mm"]<10){$mois="0".$membre["mm"];}else{$mois=$membre["mm"];}
					if($membre["jj"]<10){$jour="0".$membre["jj"];}else{$jour=$membre["jj"];}
					$array[$variable]=array($colonne_1 => $membre["aaaa"]."/".$mois."/".$jour);
				}elseif($colonne_1 == "tel"){
					if($membre["tel_port"] <> "" && $membre["tel_dom"] <> ""){
						$array[$variable]=array($colonne_1 => "<b>".$membre["tel_port"]."</b> (".$membre["tel_dom"].")");
					}else{
						$array[$variable]=array($colonne_1 => "<b>".$membre["tel_port"]."</b>".$membre["tel_dom"]);
					}
				}elseif($colonne_1 == "adresse"){
					$array[$variable]=array($colonne_1 => $membre["adresse"]." ".$membre["cp"]." ".$membre["ville"]);
				}elseif($colonne_1 == "urgence"){
					$array[$variable]=array($colonne_1 => $membre["urgence"]." (".$membre["tel_urg"].")");
				}else{
					$array[$variable]=array($colonne_1 => $membre[$colonne_1]);
				}
			}
			if($colonne_2 <> ""){
				if($colonne_2 == "aaaa/mm/jj"){
					if($membre["mm"]<10){$mois="0".$membre["mm"];}else{$mois=$membre["mm"];}
					if($membre["jj"]<10){$jour="0".$membre["jj"];}else{$jour=$membre["jj"];}
					$array[$variable]+=array($colonne_2 => $membre["aaaa"]."/".$mois."/".$jour);
				}elseif($colonne_2 == "tel"){
					if($membre["tel_port"] <> "" && $membre["tel_dom"] <> ""){
						$array[$variable]+=array($colonne_2 => "<b>".$membre["tel_port"]."</b> (".$membre["tel_dom"].")");
					}else{
						$array[$variable]+=array($colonne_2 => "<b>".$membre["tel_port"]."</b>".$membre["tel_dom"]);
					}
				}elseif($colonne_2 == "adresse"){
					$array[$variable]+=array($colonne_2 => $membre["adresse"]." ".$membre["cp"]." ".$membre["ville"]);
				}elseif($colonne_2 == "urgence"){
					$array[$variable]+=array($colonne_2 => $membre["urgence"]." (".$membre["tel_urg"].")");
				}else{
					$array[$variable]+=array($colonne_2 => $membre[$colonne_2]);
				}
			}
			if($colonne_3 <> ""){
				if($colonne_3 == "aaaa/mm/jj"){
					if($membre["mm"]<10){$mois="0".$membre["mm"];}else{$mois=$membre["mm"];}
					if($membre["jj"]<10){$jour="0".$membre["jj"];}else{$jour=$membre["jj"];}
					$array[$variable]+=array($colonne_3 => $membre["aaaa"]."/".$mois."/".$jour);
				}elseif($colonne_3 == "tel"){
					if($membre["tel_port"] <> "" && $membre["tel_dom"] <> ""){
						$array[$variable]+=array($colonne_3 => "<b>".$membre["tel_port"]."</b> (".$membre["tel_dom"].")");
					}else{
						$array[$variable]+=array($colonne_3 => "<b>".$membre["tel_port"]."</b>".$membre["tel_dom"]);
					}
				}elseif($colonne_3 == "adresse"){
					$array[$variable]+=array($colonne_3 => $membre["adresse"]." ".$membre["cp"]." ".$membre["ville"]);
				}elseif($colonne_3 == "urgence"){
					$array[$variable]+=array($colonne_3 => $membre["urgence"]." (".$membre["tel_urg"].")");
				}else{
					$array[$variable]+=array($colonne_3 => $membre[$colonne_3]);
				}
			}
			if($colonne_4 <> ""){
				if($colonne_4 == "aaaa/mm/jj"){
					if($membre["mm"]<10){$mois="0".$membre["mm"];}else{$mois=$membre["mm"];}
					if($membre["jj"]<10){$jour="0".$membre["jj"];}else{$jour=$membre["jj"];}
					$array[$variable]+=array($colonne_4 => $membre["aaaa"]."/".$mois."/".$jour);
				}elseif($colonne_4 == "tel"){
					if($membre["tel_port"] <> "" && $membre["tel_dom"] <> ""){
						$array[$variable]+=array($colonne_4 => "<b>".$membre["tel_port"]."</b> (".$membre["tel_dom"].")");
					}else{
						$array[$variable]+=array($colonne_4 => "<b>".$membre["tel_port"]."</b>".$membre["tel_dom"]);
					}
				}elseif($colonne_4 == "adresse"){
					$array[$variable]+=array($colonne_4 => $membre["adresse"]." ".$membre["cp"]." ".$membre["ville"]);
				}elseif($colonne_4 == "urgence"){
					$array[$variable]+=array($colonne_4 => $membre["urgence"]." (".$membre["tel_urg"].")");
				}else{
					$array[$variable]+=array($colonne_4 => $membre[$colonne_4]);
				}
			}
			if($colonne_5 <> ""){
				if($colonne_5 == "aaaa/mm/jj"){
					if($membre["mm"]<10){$mois="0".$membre["mm"];}else{$mois=$membre["mm"];}
					if($membre["jj"]<10){$jour="0".$membre["jj"];}else{$jour=$membre["jj"];}
					$array[$variable]+=array($colonne_5 => $membre["aaaa"]."/".$mois."/".$jour);
				}elseif($colonne_5 == "tel"){
					if($membre["tel_port"] <> "" && $membre["tel_dom"] <> ""){
						$array[$variable]+=array($colonne_5 => "<b>".$membre["tel_port"]."</b> (".$membre["tel_dom"].")");
					}else{
						$array[$variable]+=array($colonne_5 => "<b>".$membre["tel_port"]."</b>".$membre["tel_dom"]);
					}
				}elseif($colonne_5 == "adresse"){
					$array[$variable]+=array($colonne_5 => $membre["adresse"]." ".$membre["cp"]." ".$membre["ville"]);
				}elseif($colonne_5 == "urgence"){
					$array[$variable]+=array($colonne_5 => $membre["urgence"]." (".$membre["tel_urg"].")");
				}else{
					$array[$variable]+=array($colonne_5 => $membre[$colonne_5]);
				}
			}
			if($colonne_6 <> ""){
				if($colonne_6 == "aaaa/mm/jj"){
					if($membre["mm"]<10){$mois="0".$membre["mm"];}else{$mois=$membre["mm"];}
					if($membre["jj"]<10){$jour="0".$membre["jj"];}else{$jour=$membre["jj"];}
					$array[$variable]+=array($colonne_6 => $membre["aaaa"]."/".$mois."/".$jour);
				}elseif($colonne_6 == "tel"){
					if($membre["tel_port"] <> "" && $membre["tel_dom"] <> ""){
						$array[$variable]+=array($colonne_6 => "<b>".$membre["tel_port"]."</b> (".$membre["tel_dom"].")");
					}else{
						$array[$variable]+=array($colonne_6 => "<b>".$membre["tel_port"]."</b>".$membre["tel_dom"]);
					}
				}elseif($colonne_6 == "adresse"){
					$array[$variable]+=array($colonne_6 => $membre["adresse"]." ".$membre["cp"]." ".$membre["ville"]);
				}elseif($colonne_6 == "urgence"){
					$array[$variable]+=array($colonne_6 => $membre["urgence"]." (".$membre["tel_urg"].")");
				}else{
					$array[$variable]+=array($colonne_6 => $membre[$colonne_6]);
				}
			}
			$variable++;
		}
	}
	
	usort($array, build_sorter($classement));

	for ($i=0;$i<count($array);$i++){
		echo "<tr height=30><td>".$array[$i][$colonne_1]."</td>";
		if($colonne_2 <> "")
			echo "<td>".$array[$i][$colonne_2]."</td>";
		if($colonne_3 <> "")
			echo "<td>".$array[$i][$colonne_3]."</td>";
		if($colonne_4 <> "")
			echo "<td>".$array[$i][$colonne_4]."</td>";
		if($colonne_5 <> "")
			echo "<td>".$array[$i][$colonne_5]."</td>";
		if($colonne_6 <> "")
			echo "<td>".$array[$i][$colonne_6]."</td>";
		echo "<td>&nbsp;</td></tr>";
	}
	?>
	</table>
	<?php
}else
{

}
?>
</body>
</html>