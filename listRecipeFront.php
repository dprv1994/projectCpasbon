<?php
require_once 'inc/session.php';
require_once 'inc/connect.php';
$query = $bdd->prepare('SELECT * FROM recipe ORDER BY date_creation');
if ($query->execute()) {
	$preparation = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>


<?php require_once 'header.php' ; ?>

<div class="search">
    <div class="wrapper"></div>
</div>
<div class="listRecipes">
    <div class="wrapper">
        <h1>Liste des recettes</h1>
        <div class="grid-4">

            <?php foreach ($preparation as $value): ?>
                <div class="ficheRecipe">
                    <h1><a href="RecipeFront.php?id=<?= $value['id'];?>"><?= $value['title'];?></a><small class="author"><?= $value['id_autor'];?></small></h1>
                    <img src="<?= $value['url_img'];?>" alt="">
                    <?php if (isset($is_logged)): ?>
                        <a href="admin/update_recipe.php?id=<?= $value['id'];?>"><button type="button" name="button">Modifier</button></a>
                        <a href="admin/delete_recipe.php?id=<?= $value['id'];?>"><button type="button" name="button">Supprimer</button></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php' ; ?>
