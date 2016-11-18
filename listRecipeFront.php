<?php
require_once 'inc/session.php';
require_once 'inc/connect.php';

////////////////////////////////////////////////////////
//                  SEARCH                          //
$get = [];
$sql = '';

if(!empty($_GET)){
	foreach ($_GET as $key => $value) {
		$get[$key] = trim(strip_tags($value));
	}
	if(isset($get['search']) && !empty($get['search'])){
		$sql = 'WHERE r.title LIKE :search OR r.preparation LIKE :search OR r.date_creation LIKE :search';
	}
}
//////////////////////////////////////////////////////////
//                  REQUETE MYSQL

$query = $bdd->prepare('
        SELECT r.*, u.firstname , u.lastname, u.username, u.avatar
        FROM recipe AS r
        LEFT JOIN users AS u
        ON r.id_autor = u.id '.$sql.'
        ORDER BY r.date_creation');

if(!empty($sql)){
	$query->bindValue(':search', '%'.$get['search'].'%');
}
if ($query->execute()) {
	$preparation = $query->fetchAll(PDO::FETCH_ASSOC);
}

//////////////////////////////////////////////////////////
//                  Fin du traitement

// ajout des meta dans le head via $headeradd
$headerAdd = [
    'title'  => 'Liste Des Recettes'
];
require_once 'header.php' ; ?>

<div class="search">
    <div class="wrapper"></div>
</div>
<div class="listRecipes">
    <div class="wrapper">
        <h1>La liste des recettes</h1>
        <form method="get" >
            <div class="">
               <input type="search" name="search" class="" placeholder="Pâtes aux .....">
               <span class="">
                 <button class="" type="submit">Recherche</button>
               </span>
             </div>
        </form>
        <div class="grid-4">
            <?php if (!empty($preparation)): ?>
                <!-- Affichage des recettes si il y a un resultat a la recherche ou pas de resultat : -->
                <?php foreach ($preparation as $value):
                    ////////////////////////////////////
                    // souslignage du texte si recherche

                    $title = (isset($get['search']) && !empty($get['search']))? preg_replace('/'.$get['search'].'/', '<mark>'.$get['search'].'</mark>', $value['title']) : $value['title'];
                    $username = (isset($get['search']) && !empty($get['search']))? preg_replace('/'.$get['search'].'/', '<mark>'.$get['search'].'</mark>', $value['username']) : $value['username'];
                    //
                    /////////////////////////////////////
                    ?>

                    <div class="ficheRecipe">
                        <h1><a href="RecipeFront.php?id=<?= $value['id'];?>"><?= $title;?></a><small class="author"><?= $username;?></small></h1>
                        <img src="<?= $value['url_img'];?>" alt="">
                        <?php if (isset($is_logged)): ?>
                            <a href="admin/update_recipe.php?id=<?= $value['id'];?>"><button type="button" name="button">Modifier la recette</button></a>
                            <a href="admin/delete_recipe.php?id=<?= $value['id'];?>"><button type="button" name="button">Supprimer la recette</button></a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Affichage d'un message d'exuse si il n'y a pas de resutat : -->
                Aucune recette trouvé désolé !!
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php' ; ?>
