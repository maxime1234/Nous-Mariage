<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset="utf-8">
	<title>Vétement tendance / Inscription</title>
	<?php include("include/script.php");?>
</head> 
<body BGCOLOR="#CCEEFF ">

<div class="main-indents">
  <div class="main">
        <!-- Header -->
    <?php include("include/entete.php");?>
<!--articles-->

<!-- Bloc Contenu -->
<div id="contenu">
		<center><h1>Formulaire de saisie</h1></center>



<form method="post" action="traitementInscription.php">

<div align="center" >

 	<table>
		
		<tr>
			<td width='200'>Nom :</td>
			<td width='200'><input type="text" name="nom" ></td>
		</tr>
			
		<tr>
			<td width='200'>Adresse :</td>
			<td width='200'><input type="text" name="adresse" ></td>
		</tr>
		
		<tr>
			<td width='200'>Ville :</td>
			<td width='200'><input type="text" name="ville" ></td>
		</tr>
		
		<tr>
			<td width='200'>Code Postal :</td>
			<td width='200'><input type="text" name="cp" ></td>
		</tr>
		
		<tr>
			<td width='200'>Adresse mail :</td>
			<td width='200'><input type="text" name="mail" ></td>
		</tr>
		
		<tr>
			<td width='200'>identifiant :</td>
			<td width='200'><input type="text" name="identifiant" ></td>
		</tr>
		
		<tr>
			<td width='200'>Mot de passe :</td>
			<td width='200'><input type="text" name="mdp" ></td>
		</tr>
		
		
		<tr>
			<td colspan="2"><div align="center"><input type="submit" name="connexion" value="Valider"><input type="reset" value="Réinitialiser"></div></td>
		</tr>
				
	</table>
</div>
	
</form>
	<br />

<!-- Fin bloc Contenu -->	
<!-- Footer -->
      <?php include("include/footer.php");?>
</div>
</body>
