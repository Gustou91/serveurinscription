<?php 

	include "../restrict/config.php";

	mysql_connect($adresse, $user, $pass);
	mysql_select_db($bdd);mysql_set_charset( 'ansi' );
	$valeur = 0;
	
	if(	isset($_POST["pass"]) && !empty($_POST["pass"])){
		$pass=$_POST["pass"];
		$pass=MD5($pass);
		//echo $pass;
		$parametres = mysql_query("SELECT * FROM generale WHERE nom='password'");
		$parametres = mysql_fetch_array($parametres);
		//if (true){
		if ($pass == $parametres['valeur']){
			$valeur = 1;
?>
<frameset ROWS="40,*" border=0>
	<frame name="adm_menu" src="menu.php?pass=<?php echo $pass; ?>" noresize>
	<frame name="adm_site" src="intro.php">
</frameset>
<?php 	} else {
			echo "<center>password incorrect</center>"; 
		}
	}
	if ($valeur == 0){
?>
<html>
	<body onload="document.forms.password.pass.focus()">
		<form name="password" method="post" action="index.php">
			<center>
				PASSWORD<br>
				<input type="password" name="pass" size="10"><br>
				<input type="submit" value="Envoyer">
			</center>
		</form>
	</body>
</html>
<?php
}
?>