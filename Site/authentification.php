<?php
	// création d'une session permettant de conserver des valeurs de page en page dans des variables de session
	session_start();		// cette instruction est nécessairement la première de la page
	
	/* A ADAPTER */
	$login=$_POST['identifiant'];		// récupération d'un login (à compléter avec le nom de contrôle de formulaire associé)
	$pwd=$_POST['mdp'];		// récupération d'un mot de passe (à compléter avec le nom de contrôle de formulaire associé)
	
	// appel du fichier de connexion au serveur de données, puis à la base de données
	include('connexion.inc.php');
	
	// stockage dans une variable d'une chaîne de caractères correspondant à une requête qui recherche l'utilisateur correspondant au login et au mot de passe fournis
	$reqSQL = "	SELECT identifiant, mdp
				FROM users
				WHERE identifiant = '$login'
				AND mdp = '$pwd' ;
			  ";		
	
	// exécution de la requête stockée dans $reqSQL par le SGBDR MySQL et récupération du jeu d'enregistrements résultat dans une variable
	$jeuEnr = mysql_query($reqSQL);
	// test du nombre d'enregistrements du jeu d'enregistrements résultat (1 si l'authentification est réussie, 0 sinon)
	/*
	if (mysqli_num_rows($jeuEnr)==0)
	
		{
			// affectation à une variable de session qui pourra être réappelée dans une autre page
			$_SESSION['$authentif']=False;
		header('location: echecAuthentification.php');
			
		}
	else
	
		{*/
			$_SESSION['$authentif']=$login;
			header('location: index.php');
		//}

?>
