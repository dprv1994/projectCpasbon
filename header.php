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
    </head>
<body>
    <div class="topbar">
        <div class="wrapper grid-2">
            <div class="logo one-third">
                <h2>CPasBon</h2>
                <span>1 rue de l'adresse, 33150 Cenon</span>
                <span>06.66.66.99</span>
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
