<?php
header('Content-type: text/html; charset=anssi');
// définition des variables de connexion au serveur phpnet.org
$serveur = "127.0.0.1";  // Adresse ip du serveur Mysql
$utilisateur = "root";  // Votre login d'accès à la base de données
$motdepasse = "";  // Votre mot de passe réseau
$base = "vetement tendance"; //Nom de votre base de données 


// Connexion au serveur de base de données Mysql
$connexionServeur = mysql_connect($serveur, $utilisateur, $motdepasse);

//Si la connexion réussie, "true" est affecté à la variable $connexionServeur
//Si la connexion échoue, "false" est affecté à la variable $connexionServeur


// Test de la variable $connexionServeur
 if($connexionServeur==false) // Echec de la connexion au serveur
 {  
    echo 'Un problème est survenu.<br /><br />';
	echo 'La connexion au serveur '.$serveur.' a échoué.';
 }
 else
 {
     // Sélection de la base de données
     $selectionBase= mysql_select_db($base, $connexionServeur);
     
	 // test de la variable $selectionBase
     if($selectionBase==false)	// Echec de la sélection de la base de données
		{  
			echo 'Erreur dans la sélection de la base de données '.$base.' !';
             
			 // fermeture de la connexion
             mysql_close($connexionServeur);
		}
 }

 ?>
