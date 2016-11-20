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
        <div class="recipeView pbl">
            <div class="grid-2-small-1 recipe-top">
                <div class="recipeIll pam">
                    <h1>Recette : <?= ucfirst($recette['title']);?></h1>
                    <img src="<?= $recette['url_img'];?>" alt="">
                </div>
                <div class="one-fifth infos pam">
                    <div class="info">
                        <div><b>Date de création : </b><?= date('d/m/Y H:i', strtotime($recette['date_creation']));?></div>
                        <div><b>Auteur : </b> <?= ucfirst($recette['username']);?></div>
                    </div>
                    <div class="ingredients">
                        <span><b>Ingrédients : </b></span>
                        <?php $ingredients = explode(',',$recette['ingredient']); ?>
                        <ul>
                            <?php foreach ($ingredients as $ingredient): ?>
                                <li><?= $ingredient; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if (isset($is_logged) && $is_logged == 'admin'): ?>
                        <div class="recipeAdmin mtl">
                            <!-- admin seulement -->
                            <a href="admin/update_recipe.php?id=<?= $recette['id']?>"><button type="button" class="mtm mbm pas">Modifier la recette</button></a>
                            <a href="admin/delete_recipe.php?id=<?= $recette['id']?>"><button type="button" class="mtm mbm pas">Supprimmer la recette</button></a>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <h3>Instructions :</h3>
            <p class="content">
                        <?= $recette['preparation'];?>
            </p>
        </div>

    </div>




<?php require_once 'footer.php' ; ?>
