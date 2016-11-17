<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="utf-8">
        <title>Accueil Cpasbon</title>

        <!-- Données du Theme -->

        <!----webfonts---->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>




        <!-- Fin de Données du Theme -->

        <!-- Penser a Rajouter toute les meta -->

        <!-- import de knacss -->
        <link rel="stylesheet" href="css/knacss.css">

        <!-- css perso -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style3.css">
    </head>
<body>
    <!----start-header---->
    <div class="header" id="move-top">
        <div class="wrap">
        <div class="header-left">
            <!----start-logo---->
            <div class="logo">
            <a href="index.php"><h2>CPasBon!</h2>
            <p>1rue de l'adresse, 33150 Cenon</p><br>
            <p>06.66.66.99</p>
            </a>
        </div>
            <!----//End-logo---->
        </div>
        <div class="header-right">
            <!----start-top-nav---->
            <div class="top-nav">
                <ul>
                    <li class="active"><a href="#work">Accueil</a></li>
                    <li><a href="listRecipeFront.php">Recettes</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <!----//End-top-nav---->
            <!----start-search-box--->
            <div class="search">
                <div class="search-box">
                    <div id="sb-search" class="sb-search">
                        <form>
                            <input class="sb-search-input" placeholder="Votre recette..." type="search" name="search" id="search">
                            <input class="sb-search-submit" type="submit" value="">
                            <span class="sb-icon-search"> </span>
                        </form>
                    </div>
                </div>
                <!----search-scripts---->
                <script src="js/modernizr.custom.js"></script>
                <script src="js/classie.js"></script>
                <script src="js/uisearch.js"></script>
                <script>
                    new UISearch( document.getElementById( 'sb-search' ) );
                </script>
                <!----//search-scripts---->
            </div>
            </div>
            <!----//End-search-box--->
            <div class="clear"> </div>
        </div>
        <div class="clear"> </div>
    </div>
    <!----//End-header---->
