<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

if(isset($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])) {
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

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!verif::length(8, 30)->validate($post['password'])) {
		$errors[] = 'Veuillez taper un mot de passe valide compris entre 8 et 30 caractères';
	}

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

	if(count($errors) === 0) {
		$query = $bdd->prepare('UPDATE users SET password = :password, avatar =:avatar WHERE id = :idUser');
		$user = $query->fetch(PDO::FETCH_ASSOC);
		$query->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
		$query->bindValue('avatar', $dirUpload.$photoName);

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
<div class="col-lg-6">
    <ul>
        <strong> Nom : </strong><?= $users['lastname'] ?><br>
        <strong> Prénom : </strong><?= $users['firstname'] ?><br>
        <strong> Email : </strong><?= $users['email'] ?><br>
        <strong> Pseudo : </strong><?= $users['username'] ?><br>
        <form method="post" enctype="multipart/form-data">
            <div class="from-group">
                <label for="password">Nouveau mot de passe : </label><br>
                <input class="form-control" type="password" id="password" name="password">
            </div>
            <div class="from-group">
                <label for="avatar">Nouveau avatar :</label><br>
                <input class="" type="file" id="avatar" name="avatar">
            </div>
            <br><br>
            <input class="btn btn-info btn-lg center-block" type="submit" value="Mettre à jour de votre profil">
        </form>

    </ul>
</div>
<div class="col-lg-6">
    <li> <strong> Avatar : </strong><img src="<?= $users['avatar'] ?>"> </li>
</div>
<?php require_once 'footer.php'; ?>
