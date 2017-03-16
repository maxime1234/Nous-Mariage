<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ANSI"/>
<title>Vetement tendance</title>
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/superfish.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/tms-0.4.1.js"></script>
<script src="js/slider.js"></script>
<script type="text/javascript" src="js2/move-top.js"></script>
<script type="text/javascript" src="js2/easing.js"></script>
	<script type="text/javascript" src="js/jsSimpleDatePickr.js"></script>
	<script type="text/javascript" src="js/jsSimpleDatePickrInit.js"></script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<link rel="stylesheet" href="css/ie.css"> 
<![endif]-->
</head>
<body>
<div class="main-indents">
  <div class="main">
    <!-- Header -->
    <header>
      <h1 class="logo"><a href="index.html">Vetement tendance</a></h1>
      <nav>
        <ul class="sf-menu">
			<li class="current"><a href="index.html">accueil</a></li>
			<li><a href="contacts.html">Contact</a></li>
			<li> <a href="Hommes.html">Homme</a>
				<ul>
					<li><a href="chaussure homme.html">chaussure</a></li>
					<li><a href="pantalon homme.html">pantalon</a></li>
					<li><a href="haut homme.html">haut</a></li>
				</ul>
			</li>
			<li><a href="Femmes.html">Femme</a>
				<ul>
				  <li><a href="chaussure femme.html">chaussure</a></li>
				  <li><a href="pantalon femme.html">pantalon</a></li>
				  <li><a href="haut femme.html">haut</a></li>
				</ul>
			</li>
			<li><a href="Enfants.html">Enfant</a>
				<ul>
				  <li><a href="chaussure enfant.html">chaussure</a></li>
				  <li><a href="pantalon.html">pantalon</a></li>
				  <li><a href="haut enfant.html">haut</a></li>
				</ul>
			</li>
			<li><a href="inscription.html">Inscription</a></li>
			<li><a href="formulaireAuthentification.php">Connexion</a></li>
			<li><a href="panier.php">Panier <img src="images/panier.jpg" WIDTH='25 pixel' HEIGHT='25 pixel' /></a></li>			
        </ul>
      </nav>
      <div class="clear"></div>
    </header>
<?php
    // Dans ce script nous utilisons les sessions
    session_start();

    // Chargement du caddie
    if (isset($_SESSION["caddie"])) {
        $caddie = $_SESSION["caddie"];
    } else {
        $caddie = array();
    }     
    
    if ($_GET["action"]=="destroy") {
        // on a demander à tout supprimer
        session_destroy();
        header("Location: ".$_SERVER["PHP_SELF"]);
        die();
    }

    if (isset($_GET["raz"])) {
        // On a demandé à reinitialiser une valeur
        switch ($_GET["raz"]) {
            case "pomme":
                unset($caddie["pommes"]);
                break;
            case "poire":
                unset($caddie["poires"]);
                break;
            case "banane":
                unset($caddie["bananes"]);
                break;
            }
        // "sauvegarde" des modifications    
        $_SESSION["caddie"] = $caddie;    
        header("Location: ".$_SERVER["PHP_SELF"]);
        die();
    }
    
    if (isset($_GET["achat"])) {
        // On a demandé à incrémenter une valeur    
        switch ($_GET["achat"]) {
            case "pomme":
                $caddie["pommes"]++;
                 break;
            case "poire":
                $caddie["poires"]++;
                 break;
            case "banane":
                $caddie["bananes"]++;
                 break;
        }
        // "sauvegarde" des modifications    
        $_SESSION["caddie"] = $caddie;
        header("Location: ".$_SERVER["PHP_SELF"]);
        die();
   }     
?>
Nb Pommes:<?php echo $caddie["pommes"];?><br />
<a href="<?php echo $_SERVER["PHP_SELF"];?>?achat=pomme">Acheter une pomme</a>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?raz=pomme">RAZ</a><br />

Nb Poires:<?php echo $caddie["poires"];?><br />
<a href="<?php echo $_SERVER["PHP_SELF"];?>?achat=poire">Acheter une poire</a>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?raz=poire">RAZ</a><br />

Nb Bananes:<?php echo $caddie["bananes"];?><br />
<a href="<?php echo $_SERVER["PHP_SELF"];?>?achat=banane">Acheter une banane</a>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?raz=banane">RAZ</a><br />

<br/>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?action=destroy">Détruire la session</a><br/>