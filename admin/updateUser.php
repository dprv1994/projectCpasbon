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


use Respect\Validation\Validator as verif;

$post=[];
$errors=[];
$formValid=false;
$haserror=false;
$dirUpload='../img/avatar/';
$changePass = false;
$changePict = false;

if(isset($_GET['id']) && is_numeric($_GET['id']) && $is_logged == 'admin') {
    $id = $_GET['id'];
}
elseif(isset($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])) {
    $id = $_SESSION['user']['id'];
}

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

    if (isset($post['password']) && !empty($post['password'])) {

        $changePass = true ;

        if(!preg_match('#[a-zA-Z0-9_\-\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{8,30}#', $post['password'])) {
            $errors[] = 'Veuillez entrer un mot de passe compris entre 8 et 30 caractères';
        }
    }

	if (strlen($_FILES['avatar']['name']) > 0) {

        $changePict = true ;

		if(!is_uploaded_file($_FILES['avatar']['tmp_name']) || !file_exists($_FILES['avatar']['tmp_name'])){
			$errors[] = 'Vous devez ajouter une image';
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

	if(count($errors) === 0 && ($changePict || $changePass)) {

        $changePass = ($changePass)? 'password = :password' : '';
        $changePict = ($changePict)? 'avatar = :avatar' : '';
		$columnSQL = (!empty($changePict) && !empty($changePass))? $changePass .', '. $changePict : $changePass . $changePict;

		$query = $bdd->prepare('UPDATE users SET '.$columnSQL.' WHERE id = :idUser');
		$user = $query->fetch(PDO::FETCH_ASSOC);
        if (!empty($changePass)) {
            $query->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
        }
        if (!empty($changePict)) {
            $query->bindValue(':avatar', 'img/avatar/'.$photoName);
        }
		$query->bindValue(':idUser', $id, PDO::PARAM_INT);
		if($query->execute()) {
			$formValid = true;
		}
		else {
			var_dump($query->errorInfo());
            header('Location:updateUser.php');
			die;
		}
	}
	else {
		$haserror = true;
	}

}

// requete pour récupérer les infos :
$query = $bdd->prepare('SELECT * FROM users WHERE id = :idUser');
$query->bindValue(':idUser', $id, PDO::PARAM_INT);
if($query->execute()) {
    $users = $query->fetch(PDO::FETCH_ASSOC);
}


require_once 'header.php';
?>
<h1>Mon Profil</h1>

 <?php if ($formValid == true): ?>
    <p class="alert-success">Le profil a été modifié.</p>
<?php elseif ($haserror == true): ?>
    <p class="alert-danger"><?= implode('<br>', $errors);?></p>
<?php endif; ?>

<div class="col-lg-6">
    <ul>
        <strong>Nom : </strong><?= $users['lastname'] ?><br>
        <strong>Prénom : </strong><?= $users['firstname'] ?><br>
        <strong>Email : </strong><?= $users['email'] ?><br>
        <strong>Pseudo : </strong><?= $users['username'] ?><br>
        <h4>Modifier votre mot de passe ou votre avatar : </h4>
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
            <input class="btn btn-info btn-lg center-block" type="submit" value="Mettre à jour le profil">
        </form>

    </ul>
</div>
<div class="col-lg-6">
    <strong>Avatar : </strong><img class="img-responsive" src="../<?= $users['avatar'] ?>">
</div>
<?php require_once 'footer.php'; ?>
