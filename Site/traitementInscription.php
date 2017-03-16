<?php
//Connexion à la base de données
include('connexion.inc.php');

//Récupération des variables transmises par le formulaire
$nom=$_POST['nom'];
$adresse=$_POST['adresse'];
$ville=$_POST['ville'];
$codePostale=$_POST['cp'];
$adresseMail=$_POST['mail'];
$login=$_POST['identifiant'];
$psw=$_POST['mdp'];

// Ecriture de la requête pour insérer les variables dans la base
		$requete="insert into users (`nom`, `adresse`, `ville`, `cp`, `mail`, `identifiant`, `mdp`) values ('$nom', '$adresse', '$ville', $codePostale, '$adresseMail', '$login', '$psw');";

		$resultat=mysql_query($requete);
			
			//Test de la variable $resultat
			if($resultat!=false)
			    { header('Location: formulaireAuthentification.html'); }
			else
			    { echo "La requête $requete a échoué"; }

?>
