<?php
//   requete pour affichage des infos
$query = $bdd->query('SELECT * FROM contact_information ');
if ($query->execute()) {
	$info = $query->fetchAll(PDO::FETCH_ASSOC);
}
 ?>
<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="utf-8">
        <!-- si ont passe un variable $headerAdd['title'] alors ont affiche cette variable sinon accueil -->
        <title><?= (isset($headerAdd['title']) && !empty($headerAdd['title']))? $headerAdd['title'] : 'Accueil' ?> | Cpasbon</title>

        <!-- Penser a Rajouter toute les meta -->

        <!-- libraairie externe-->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/knacss.css">
        
        <link href="https://fonts.googleapis.com/css?family=Slabo+27px|Yellowtail" rel="stylesheet">


        <!-- css perso -->
        <link rel="stylesheet" href="css/style.css">




    </head>
<body>
    <div class="topbar">
        <div class="wrapper grid-2">
            <div class="logo one-third">
                <h2><?= $info[0]['value']; ?></h2>
                <span><?= $info[1]['value'] . ' <br> ' . $info[2]['value'] . '  ' .$info[3]['value']?></span>
                <span><a href="tel:<?= $info[4]['value']; ?>"><?= $info[4]['value']; ?></a></span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listRecipeFront.php">Recettes</a></li>
                    <li><a href="contact.php">Nous Contacter</a></li>
                </ul><br>
                <form method="get" action="listRecipeFront.php" class="searchListRecipes" >
                       <div class="searchPlacement">
                           <input type="search" name="search" class="" placeholder="Pâtes aux .....">
                           <span class="">
                               <button class="" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                           </span>
                       </div>
                </form>
            </nav>
        </div>
    </div>
