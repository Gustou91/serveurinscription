<?php include "../restrict/config.php";?>
<body>
<center>
<table><tr>
<td>
<form name="activites" method="post" action="adm_activites.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Activit&eacute;s">
		</form>
</td><td width=5></td><td>
<form name="cours" method="post" action="adm_cours.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Cours">
		</form>
</td><td width=5></td><td>
<form name="frais" method="post" action="adm_frais.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Divers frais">
		</form>
</td><td width=5></td><td>
<form name="membres" method="post" action="adm_membres.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Membres">
		</form>
</td><td width=5></td><td>
<form name="inscriptions" method="post" action="adm_inscriptions.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Inscriptions">
		</form>
</td><td width=5></td><td>
<form name="parametres" method="post" action="adm_villes.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Villes">
		</form>
		</td><td width=5></td><td>
<form name="parametres" method="post" action="adm_cp.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="CP">
		</form>
</td><td width=5></td><td>
<form name="parametres" method="post" action="adm_banques.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Banques">
		</form>
</td><td width=5></td><td>
<form name="parametres" method="post" action="parametres.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Param&egrave;tres">
</form>
</td><td width=5></td><td>
<form name="recettes" method="post" action="recettes.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Recettes">
		</form>
</td><td width=5></td><td>
<form name="nettoyer" method="post" action="nettoyer.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Nettoyer">
		</form>
</td>
<?php
if(strpos($_SERVER["SERVER_SOFTWARE"], "(Raspbian)") != false){
?>
<td width=5></td><td>
<form name="Sauvegarder" method="post" action="backup.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Sauvegarder">
		</form>
</td>
<td width=5></td><td>
<form name="Eteindre" method="post" action="shutdown.php" target="adm_site">
		<input type="hidden" name="pass" value="<?php echo $_REQUEST["pass"];?>">
		<input type="submit" value="Eteindre">
		</form>
</td>
<?php
}
?>
</tr>
</table>
</center>
</body>