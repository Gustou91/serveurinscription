<?php
// données serveur
$adresse = "127.0.0.1";
$bdd = "voco";
$user = "voco";
$pass = "gaillon";
// fin données serveur

//fvariables dates
$time = time();
$annee_actu = date('Y',time());

$num_semaine_actu = date('W',time());

$num_mois_actu = date('m',time());
$pr_nom_mois = $num_mois_actu - 0;
mysql_connect($adresse, $user, $pass);
mysql_select_db($bdd);
$parametres = mysql_query("SELECT * FROM generale WHERE nom='mois_saison'");
$parametres = mysql_fetch_array($parametres);
if($parametres['valeur'] > $pr_nom_mois)
{
$annee_actu = $annee_actu-1;
}
$mois_long = array ('', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
$mois_court = array ('', 'Janv', 'Fevr', 'Mars', 'Avri', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Octo', 'Nove', 'Déce');
$nom_long_mois_actu = $mois_long[$pr_nom_mois];
$nom_court_mois_actu = $mois_court[$pr_nom_mois];

$num_jour_semaine = date('w',time());
$semaine_long = array ('Dimache', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
$semaine_court = array ('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
$nom_long_jour_actu = $semaine_long[$num_jour_semaine];
$nom_court_jour_actu = $semaine_court[$num_jour_semaine];

$num_jour_actu = date('d',time());
// fin variables date
?>
