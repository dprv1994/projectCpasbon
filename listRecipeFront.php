<?php
require_once 'inc/session.php';
require_once 'inc/connect.php';

////////////////////////////////////////////////////////
//                  pagination                         //
$page = (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$max = 5;

$debut = ($page - 1) * $max; 




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


$count = $bdd->prepare('SELECT count(*) as total
            FROM recipe AS r
            LEFT JOIN users AS u
            ON r.id_autor = u.id
            '.$sql);
//////////////////////////////////////////////////////////
//                  REQUETE MYSQL

$query = $bdd->prepare('
        SELECT r.*, u.firstname , u.lastname, u.username, u.avatar
        FROM recipe AS r
        LEFT JOIN users AS u
        ON r.id_autor = u.id '.$sql.'
        ORDER BY r.date_creation');

$query->bindValue(':debut',$debut,PDO::PARAM_INT);
$query->bindValue(':max',$max,PDO::PARAM_INT);

if(!empty($sql)){
	$query->bindValue(':search', '%'.$get['search'].'%');
    $count->bindValue(':search', '%'.$get['search'].'%');
}
    
if ($query->execute()) {
	$preparation = $query->fetchAll(PDO::FETCH_ASSOC);
}

if($count->execute()){
    $total = $count->fetch(PDO::FETCH_ASSOC);
    $nb = $total['total'];
}
    else {
        var_dump($query->errorInfo());
        die;
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
                Aucune recette trouvée, désolé !!
            <?php endif; ?>
        </div>
    </div>
    <?php $search = (isset($_GET['search']))? 'search='. $_GET['search'].'&' :'';  ?>
        <div>Page <?= $page; ?> / <?= ceil($nb/$max); ?><?= ($page!=1) ? '<a href="?'. $search .'page='. ($page - 1) .'">Page précédente</a>':''; ?>
        <?= $page!= ceil($nb/$max) ? '<a href="?'. $search .'page='. ($page + 1) .'">Page suivante</a>':''; ?>
</div>
<br>
<br>
<br>
<br>
<?php require_once 'footer.php' ; ?>
