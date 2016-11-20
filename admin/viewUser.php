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
	$query = $bdd->prepare('SELECT * FROM users WHERE id = :idUser');
	$query->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

	if($query->execute()) {
		$user = $query->fetch();
	}
	else {
		var_dump($query->errorInfo());
		die;
	}
}else {
    header('Location:listUser.php');
    die;
}

require_once 'header.php';
?>
<h1><?= ucfirst($user['username']); ?></h1>
    <div class="col-lg-6">
        <strong> Nom : </strong><?= $user['lastname']; ?><br>
        <strong> Prénom : </strong><?= $user['firstname']; ?><br>
        <strong> Email : </strong><?= $user['email']; ?><br>
        <strong> Pseudo : </strong><?= $user['username']; ?><br>
        <strong> Statut : </strong><?= affichRole($user['role'])?><br>
        <?php if ($is_logged == 'admin'): ?>
            <!-- <form method="post"> Nécessite AJAX
                <button class="btn btn-danger btn-lg center-block" id="delete" name="delete" onClick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?'))
                alert('Utilisateur supprimer !');
                else alert('Utilisateur sauvé !');">
                	Supprimer l'utilisateur
                </button>
            </form> -->

            <br><br>
            <a class="btn btn-info btn-lg center-block" href="updateUser.php?id=<?= $user['id']; ?>">Modifier le profil</a>
            <br><br>
            <a class="btn btn-danger btn-lg center-block" href="deleteUser.php?id=<?= $user['id']; ?>">Supprimer le profil</a>
        <?php endif; ?>
    </div>
    <div class="col-lg-6">
        <strong> Avatar : </strong> <img class="img-responsive" src="<?= $user['avatar']; ?>">
    </div>
<?php require_once 'footer.php'; ?>
