<?php
require_once 'inc/connect.php';

$req = $bdd->prepare('SELECT * FROM recipe ORDER BY date_creation LIMIT 3');
$req->execute();
$recettes = $req->fetchAll(PDO::FETCH_ASSOC);

$slides = $bdd->prepare('SELECT * FROM contact_information WHERE data LIKE "slide_%"');
if ($slides->execute()) {
    $slideGroup = $slides->fetchAll(PDO::FETCH_ASSOC);
}
 ?>


<?php require_once 'header.php'; ?>

        <section class="slider_contain">
            <div class="wrapper slider">
                <?php foreach ($slideGroup as $slideUnit): ?>
                    <?php $slide = explode(',',$slideUnit['value']); ?>
                    <div class="slidesContainer">
                        <img src="<?= $slide['2']; ?>" alt="" width="640px" height="310px" />
                        <div class="slideContent">
                            <h2><?= $slide['0']; ?></h2>
                            <span><?= $slide['1']; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="recettes">
            <div class="wrapper recettesFlex">
                <h1>Les recettes des chefs</h1>
                <div class="containerRecipes grid-3">
                    <?php foreach ($recettes as $recette): ?>
                        <div class="recipe">
                            <div class="recipeContent">
                                <div class="img"><img src="<?= $recette['url_img']; ?>" alt="illustration recette <?= $recette['title']; ?>" /></div>
                                <h2><?= $recette['title']; ?></h2>
                                <span><a href="RecipeFront.php?id=<?= $recette['id'];?>">Lire la recette</a></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="listRecipeFront.php"><button class="boutonRecettes">Découvrir toutes<br>les recettes des chefs</button></a>
            </div>
        </section>

<?php require_once 'footer.php'; ?>
