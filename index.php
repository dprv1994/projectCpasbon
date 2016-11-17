<?php
require_once 'inc/connect.php';

$req = $bdd->prepare('SELECT * FROM recipe ORDER BY date_creation LIMIT 3');
$req->execute();
$recettes = $req->fetchAll(PDO::FETCH_ASSOC);


 ?>


<?php require_once 'header.php'; ?>

        <div class="slider">
            <div class="wrapper">
                <img src="http://lorempixel.com/g/400/200" alt="" />
            </div>
        </div>
        <div class="recettes">
            <div class="wrapper recettesFlex">
                <h1>Les recettes des chefs</h1>
                <div class="containerRecipes grid-3">
                    <?php foreach ($recettes as $recette): ?>
                        <div class="recipe">
                            <div class="recipeContent">
                                <div class="img"><img src="<?= $recette['url_img']; ?>" alt="illustration recette <?= $recette['title']; ?>" /></div>
                                <h2><?= $recette['title']; ?></h2>
                                <span><a href="#">Lire la recette</a></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="listRecipeFront.php"><button class="boutonRecettes">Découvrir toutes les recettes des chefs</button></a>
            </div>
        </div>

<?php require_once 'footer.php'; ?>
