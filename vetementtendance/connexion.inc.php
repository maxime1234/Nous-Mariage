<?php
header('Content-type: text/html; charset=anssi');
// d�finition des variables de connexion au serveur phpnet.org
$serveur = "127.0.0.1";  // Adresse ip du serveur Mysql
$utilisateur = "root";  // Votre login d'acc�s � la base de donn�es
$motdepasse = "";  // Votre mot de passe r�seau
$base = "vetement tendance"; //Nom de votre base de donn�es 


// Connexion au serveur de base de donn�es Mysql
$connexionServeur = mysql_connect($serveur, $utilisateur, $motdepasse);

//Si la connexion r�ussie, "true" est affect� � la variable $connexionServeur
//Si la connexion �choue, "false" est affect� � la variable $connexionServeur


// Test de la variable $connexionServeur
 if($connexionServeur==false) // Echec de la connexion au serveur
 {  
    echo 'Un probl�me est survenu.<br /><br />';
	echo 'La connexion au serveur '.$serveur.' a �chou�.';
 }
 else
 {
     // S�lection de la base de donn�es
     $selectionBase= mysql_select_db($base, $connexionServeur);
     
	 // test de la variable $selectionBase
     if($selectionBase==false)	// Echec de la s�lection de la base de donn�es
		{  
			echo 'Erreur dans la s�lection de la base de donn�es '.$base.' !';
             
			 // fermeture de la connexion
             mysql_close($connexionServeur);
		}
 }

 ?>
