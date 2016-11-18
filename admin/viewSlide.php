<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';
require_once '../inc/functions.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$query = $bdd->prepare('SELECT * FROM slide WHERE id = :idSlide');
	$query->bindValue(':idSlide', $_GET['id'], PDO::PARAM_INT);

	if($query->execute()) {
		$slide = $query->fetch();
	}
	else {
		var_dump($query->errorInfo());
		die;
	}
}else {
    header('Location:listSlide.php');
    die;
}

require_once 'header.php';
?>

<h1><?= ucfirst($slide['title']); ?></h1>
    <div class="col-lg-6">
        <strong> Contenu : </strong><?= $slide['sub_title']; ?><br>
        <?php if ($is_logged == 'admin'): ?>
            <!-- <form method="post"> Nécessite AJAX
                <button class="btn btn-danger btn-lg center-block" id="delete" name="delete" onClick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?'))
                alert('Utilisateur supprimer !');
                else alert('Utilisateur sauvé !');">
                	Supprimer l'utilisateur
                </button>
            </form> -->

            <br><br>
            <a class="btn btn-danger btn-lg center-block" href="deleteSlide.php?id=<?= $slide['id']; ?>">Supprimer le Slide</a>
        <?php endif; ?>
    </div>
    <div class="col-lg-6">
        <strong> Image : </strong> <img class="img-responsive" src="<?= $slide['picture']; ?>">
    </div>
  <?php require_once 'footer.php'; ?>