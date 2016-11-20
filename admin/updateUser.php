<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}
// J'ai commenté car cette page permet d'acceder a son propre profil si ont a pas d'id a l'origine !!!
// elseif ($is_logged == 'editeur' && !isset($_GET['id'])) {
//  	header('Location:listUser.php');
//  	die;
//  }

if(isset($_GET['id']) && is_numeric($_GET['id']) && $is_logged == 'admin') {
    $query = $bdd->prepare('SELECT * FROM users WHERE id = :idUser');
	$query->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

	if($query->execute()) {
		$users = $query->fetch();
	}
}
elseif(isset($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])) {
	$query = $bdd->prepare('SELECT * FROM users WHERE id = :idUser');
	$query->bindValue(':idUser', $_SESSION['user']['id'], PDO::PARAM_INT);

	if($query->execute()) {
		$users = $query->fetch();
	}
}

use Respect\Validation\Validator as verif;

$post=[];
$errors=[];
$formValid=false;
$haserror=false;
$dirUpload='../img/';
$photoName = false;

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!preg_match('#[a-zA-Z0-9_\-\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{8,30}#', $post['password'])) {
		$errors[] = 'Veuillez taper un mot de passe valide compris entre 8 et 30 caractères';
	}

	if (strlen($_FILES['avatar']['name']) > 0) {
		if(!is_uploaded_file($_FILES['avatar']['tmp_name']) || !file_exists($_FILES['avatar']['tmp_name'])){
			$errors[] = 'Il faut uploader une image';
		}
		else{
			$finfo = new finfo();
			$mimeType = $finfo->file($_FILES['avatar']['tmp_name'], FILEINFO_MIME_TYPE);
			$mimeTypeAllow = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'];

			if(in_array($mimeType, $mimeTypeAllow)){
				$photoName = uniqid('pic_');
				$photoName.= '.'.pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

			if(!is_dir($dirUpload)){
				mkdir($dirUpload, 0755);
			}

			if(!move_uploaded_file($_FILES['avatar']['tmp_name'], $dirUpload.$photoName)){
					$errors[] = 'Erreur lors de l\'upload de la photo';
				}

			}else{
				$errors[] = 'Le fichier est invalide';
			}
		}
	}

	if(count($errors) === 0) {
		$columnSQL = 'password = :password';

		if ($photoName) {
			$columnSQL.=', avatar = :avatar';
		}
		$query = $bdd->prepare('UPDATE users SET '.$columnSQL.' WHERE id = :idUser');
		$user = $query->fetch(PDO::FETCH_ASSOC);
		$query->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
		$query->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

		if($photoName) {
			$query->bindValue(':avatar', $_FILES['avatar']);
		}
		if($query->execute()) {
			$formValid = true;
		}
		else {
			var_dump($query->errorInfo());
			die;
		}
	}
	else {
		$haserror = true;
	}

}

require_once 'header.php';
?>
<h1>Mon Profil</h1>
<div class="col-lg-6">
    <ul>
        <strong>Nom : </strong><?= $users['lastname'] ?><br>
        <strong>Prénom : </strong><?= $users['firstname'] ?><br>
        <strong>Email : </strong><?= $users['email'] ?><br>
        <strong>Pseudo : </strong><?= $users['username'] ?><br>
        <h4>Modifier votre mot de passe ou votre avatar :</h4>
        <form method="post" enctype="multipart/form-data">
            <div class="from-group">
                <label for="password">Nouveau mot de passe : </label><br>
                <input class="form-control" type="password" id="password" name="password">
            </div>
            <div class="from-group">
                <label for="avatar">Nouvel avatar :</label><br>
                <input class="" type="file" id="avatar" name="avatar">
            </div>
            <br><br>
            <input class="btn btn-info btn-lg center-block" type="submit" value="Mettre à jour votre profil">
        </form>

    </ul>
</div>
<div class="col-lg-6">
    <strong>Avatar : </strong><img class="img-responsive" src="<?= $users['avatar'] ?>">
</div>
<?php require_once 'footer.php'; ?>
