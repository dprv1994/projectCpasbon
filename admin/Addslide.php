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
// cherche le dernier slide ajouter garde son id et l'incremente pour renommer le nouveau
$slides = $bdd->prepare('SELECT * FROM contact_information WHERE data LIKE "slide_%" ORDER BY id DESC');
if ($slides->execute()) {
    $Slide = $slides->fetch(PDO::FETCH_ASSOC);
    $nbSlide = ((int) $Slide['id']) + 1;
}



if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!preg_match('#[a-zA-Z0-9_\-\,\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{3,20}#', $post['title'])) {
		$errors[] = 'Veuillez entrer un titre valide.';
	}

	if(!preg_match('#[a-zA-Z0-9_\-\,\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{5,30}#', $post['subTitle'])) {
		$errors[] = 'Veuillez entrer un descriptif valide.';
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
        $group = [$post['title'],$post['subTitle'],'img/'.$photoName];
        $value = implode(',',$group);


		$query = $bdd->prepare('INSERT INTO contact_information (data , value) VALUES (:data , :value)');
		$query->bindValue(':data', 'slide_' . $nbSlide);
		$query->bindValue(':value', $value);

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
    <div class="form-group">
        <label for="title">Titre du Slider :</label>
        <input class="form-control" type="text" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="subTitle">Contenu du Slider :</label><br>
        <input class="form-control" type="text" id="subTitle" name="subTitle">
    </div>
    <div class="form-group">
        <label for="picture">Image du Slide :</label><br>
        <input type="file" id="picture" name="picture">
    </div>

	<input class="btn btn-info btn-lg center-block" type="submit" value="Valider le Slider">
</form>

<?php require_once 'footer.php'; ?>
