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

        <!-- import de knacss -->
        <link rel="stylesheet" href="css/knacss.css">

        <!-- css perso -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap2.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/half-slider.css" rel="stylesheet">

    </head>
<body>
    <div class="topbar">
        <div class="wrapper grid-2">
            <div class="logo one-third">
                <h2><?= $info[0]['value']; ?></h2>
                <span><?= $info[1]['value'] . ' , ' . $info[2]['value'] . ' , ' .$info[3]['value']?></span>
                <span><?= $info[4]['value']; ?></span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listRecipeFront.php">Recettes</a></li>
                    <li><a href="contact.php">Nous Contacter</a></li>
                </ul>
            </nav>
        </div>
    </div>
