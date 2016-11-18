<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged) || $is_logged == 'editeur') {
    header('Location:login.php');
    die;
}

$post=[];
$errors=[];
$formValid=false;
$haserror=false;
$dirUpload='../img/';

use Respect\Validation\Validator as verif;

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!verif::length(3, null)->validate($post['title'])) {
		$errors[] = 'Veuillez entrer un nom valide.';
	}

	if(!verif::length(8, null)->validate($post['subTitle'])) {
		$errors[] = 'Veuillez entrer un prénom valide.';
	}

	if(!is_uploaded_file($_FILES['picture']['tmp_name']) || !file_exists($_FILES['picture']['tmp_name'])){
		$errors[] = 'Il faut uploader une image';
	}
	else{
		$finfo = new finfo();
		$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);
		$mimeTypeAllow = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'];

		if(in_array($mimeType, $mimeTypeAllow)){
			$photoName = uniqid('pic_');
			$photoName.= '.'.pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
		}

		if(!is_dir($dirUpload)){
			mkdir($dirUpload, 0755);
		}

		if(!move_uploaded_file($_FILES['picture']['tmp_name'], $dirUpload.$photoName)){
				$errors[] = 'Erreur lors de l\'upload de la photo';
		
		}
	}

	if(count($errors) === 0){
		$query = $bdd->prepare('INSERT INTO slide(title, sub_title, picture) VALUES (:title, :sub_title, :picture)');
		$query->bindValue(':title', $post['title']);
		$query->bindValue(':sub_title', $post['subTitle']);
		$query->bindValue(':picture', $dirUpload.$photoName);

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

 <h1>Ajouter un Slide</h1>

 <?php if ($formValid == true): ?>
    <p class="alert-success">Un nouveau slide a été crée !</p>
<?php elseif ($haserror == true): ?>
    <p class="alert-danger"><?= implode('<br>', $errors);?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
	<label for="title">Titre du Slider :</label><br>
	<input type="text" id="title" name="title">

	<br><br>

	<label for="subTitle">Contenu du Slider :</label><br>
	<input type="text" id="subTitle" name="subTitle">

	<br><br>

	<label for="picture">Image du Slide :</label><br>
	<input type="file" id="picture" name="picture">

	<br><br>

	<input type="submit" value="Valider le Slider">
</form>

<?php require_once 'footer.php'; ?>