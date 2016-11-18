<?php
require_once 'inc/session.php';
require_once 'inc/connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $query = $bdd->prepare('SELECT * FROM recipe WHERE id = :id');
    $query->bindValue(':id', $_GET['id']);
    if ($query->execute()) {
        $recette = $query->fetch(PDO::FETCH_ASSOC);
    }

}else {
    $notexist = true ;
    header('Location:listRecipeFront.php');
    die;
}

?>


<?php require_once 'header.php' ; ?>


    <div class="wrapper">
        <div class="recipeView">
            <h1><?= $recette['title'];?></h1>
            <img src="<?= $recette['url_img'];?>" alt="">
            <div class="grid-2">
                <div class="info">
                    <span>Date de creation : <?= date('d/m/Y H:i', strtotime($recette['date_creation']));?></span>
                    <span>Categorie : <?= $recette['category'];?></span><br>
                    <span>Auteur : <?= $recette['id_autor'];?></span><br>
                </div>
                <div class="ingredients">
                    <ul>
                        <li>ingredient 1</li>
                        <li>ingredient 2</li>
                        <li>ingredient 3</li>
                        <li>ingredient 4</li>
                        <li>ingredient 5</li>
                        <li>ingredient 6</li>
                    </ul>
                </div>
            </div>
            <p class="content">
                        <?= $recette['id_autor'];?>
            </p>
        </div>

        <!-- admin seulement -->
        <button type="button" name="button">Modifier la recette</button>
        <button type="button" name="button">Supprimmer la recette</button>
    </div>




<?php require_once 'footer.php' ; ?>
