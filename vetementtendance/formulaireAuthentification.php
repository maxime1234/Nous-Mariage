<html>
	<head> 
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<?php include("include/script.php");?>
	</head> 
	<body BGCOLOR="#CCEEFF ">

	<div class="main-indents">
	  <div class="main">
	    <!-- Header -->
	    <?php include('include/entete.php');?>
	<!--Connexion-->

		<h1>Authentification</h1>
		

	<form method="post" action="authentification.php">

	<div align="center" >

	 	<table>
					
			<tr >
				<td width='200'>Login</td>
				<td width='200'><input type="text" name="identifiant" /></td>
			<tr/>
		
			<tr>
				<td>Mot de passe</td>
				<td><input type="password" name="mdp" /></td>
			<tr/>
				
			<tr>
				<td colspan="2"><div align="center"><input type="submit" name="connexion" value="Valider"></div></td>
			</tr>
					
		</table>
	</div>
	</div>
	</div>
	</form>

	<br /><br />
	L'authentification est requise pour accèder à certaines pages sécurisées du site internet.
	<br /><br />
	<?php include('include/footer.php');?>