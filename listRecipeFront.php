<?php
require_once 'inc/session.php';
require_once 'inc/connect.php';

////////////////////////////////////////////////////////
//                  SEARCH                          //
$get = [];
$sql = '';

if(!empty($_GET['search'])){
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
$titlePage = (!isset($get['search']))? 'Liste Des Recettes' : 'Recherche \' '.$get['search'].' \'';

$headerAdd = [
    'title'  => $titlePage
];
require_once 'header.php' ; ?>

<div class="listRecipes">
    <div class="wrapper">
        <h1><?= (isset($get['search']))? 'Recherche d\'une recette : \' '.$get['search'].' \'' : 'La liste des recettes' ?></h1>

        <div class="grid-3-small-2 has-gutter">
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

                    <div class="ficheRecipe-Container">
                        <div class="ficheRecipe">
                            <div class="ficheRecipe-content">
                                <h2><a href="RecipeFront.php?id=<?= $value['id'];?>"><?= $title;?></a></h2>
                                <span class="author"> de <?= $username;?></span>
                            </div>
                            <img src="<?= $value['url_img'];?>" alt="">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Affichage d'un message d'exuse si il n'y a pas de resutat : -->
                Aucune recette trouvé désolé !!
            <?php endif; ?>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<?php require_once 'footer.php' ; ?>
