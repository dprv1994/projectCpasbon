<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';


if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}



use Respect\Validation\Validator as verif;

$post=[];
$errors=[];
$formValid=false;
$haserror=false;
$dirUpload='../img/';

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!verif::length(3, null)->validate($post['lastname'])) {
		$errors[] = 'Veuillez entrer un Nom valide';
	}

	if(!verif::length(3, null)->validate($post['firstname'])) {
		$errors[] = 'Veuillez entrer un Prénom valide';
	}

	if(!verif::email()->validate($post['email'])) {
		$errors[] = 'Veuillez entrer un Email valide';
	}

	if(!verif::length(3, 30)->validate($post['username'])) {
		$errors[] = 'Veuillez entrer Pseudo valide';
	}

	if(!verif::length(8, 30)->validate($post['password'])) {
		$errors[] = 'Veuillez taper un mot de passe valide compris entre 8 et 30 caractères';
	}

	if(!isset($post['role'])) {
		$errors[] = 'Veuillez sélectionner un rôle à cet utilisateur';
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
		$query = $bdd->prepare('INSERT INTO users(lastname, firstname, email, username, password, role, avatar) VALUES(:lastname, :firstname, :email, :username, :password, :role, :avatar)');
		$query->bindValue(':lastname', $post['lastname']);
		$query->bindValue(':firstname', $post['firstname']);
		$query->bindValue(':email', $post['email']);
		$query->bindValue(':username', $post['username']);
		$query->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
		$query->bindValue(':role', $post['role']);
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
        <div class="col-lg-8 col-lg-offset-2">
            <h1>Ajout D'utilisateurs</h1>

            <?php if ($formValid == true): ?>
                <p class="alert-success">Vous avez réussi !</p>
            <?php elseif ($haserror == true): ?>
                <p class="alert-danger"><?= implode('<br>', $errors);?></p>
            <?php endif; ?>

    		<form method="post" enctype="multipart/form-data">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="lastname">Nom :</label>
                        <input class="form-control" type="text" id="lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom :</label>
                        <input class="form-control" type="text" id="firstname" name="firstname">
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input class="form-control" type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="username">Pseudo :</label>
                        <input class="form-control" type="text" id="username" name="username">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input class="form-control" type="password" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="role">Droit :</label>
                        <select class="form-control" id="role" name="role">
                            <option disabled selected>Définir un rôle</option>
                            <option value="1">Admin</option>
                            <option value="2">Editeur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar :</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                    </div>
                </div>
                <div class="col-lg-12">
                    <input class="btn btn-info btn-lg center-block" type="submit" name="Enregistrer cet utilisateur">
                </div>

    		</form>
        </div>
        <?php require_once 'footer.php'; ?>
