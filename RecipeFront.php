<?php
require_once 'inc/session.php';
require_once 'inc/connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $query = $bdd->prepare('SELECT r.*, u.firstname , u.lastname, u.username, u.avatar FROM recipe AS r
            LEFT JOIN users AS u ON r.id_autor = u.id WHERE r.id = :id');
    $query->bindValue(':id', $_GET['id']);
    if ($query->execute()) {
        $recette = $query->fetch(PDO::FETCH_ASSOC);
    }else {
        header('Location:listRecipeFront.php');
        die;
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
                    <span>Auteur : <?= $recette['username'];?></span><br>
                </div>
                <div class="ingredients">

                    <?php $ingredients = explode(',',$recette['ingredient']); ?>
                    <ul>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li><?= $ingredient; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <p class="content">
                        <?= $recette['preparation'];?>
            </p>
            <?php if (isset($is_logged) && $is_logged == 'admin'): ?>
                <!-- admin seulement -->
                <button type="button" name="button">Modifier la recette</button>
                <button type="button" name="button">Supprimmer la recette</button>
            <?php endif; ?>
        </div>

    </div>




<?php require_once 'footer.php' ; ?>
