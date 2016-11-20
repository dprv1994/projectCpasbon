<?php

require_once '../inc/session.php';
require_once '../inc/connect.php';
require_once '../inc/data.php';
require_once '../vendor/autoload.php';

use Respect\Validation\Validator as v;

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

$post = [];
$errors= [];
$dirUpload = '../img/recette/';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

if (!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!preg_match('#[a-zA-Z0-9_\-\,\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{5,140}#', $post['title'])){
		$errors[] = 'Vous devez entrer un titre de 5 à 140 caractères.';
	}
	if (!preg_match('#[a-zA-Z0-9_\-\,\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{5,500}#', $post['ingredient'])) {
			$errors[] = 'Vous devez entrer un titre compris entre 5 et 500 caractères.';
	}else {
        $searchRepl = [' ,',', ',' , '];
	    $ingredient = str_ireplace($searchRepl,',',$post['ingredient']);
	}
	if (!preg_match('#[a-zA-Z0-9_\-\,\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{20,3000}#', $post['preparation'])) {
			$errors[] = 'Vous devez entrer au minimum 20 caractères.';
	}

	if(!is_uploaded_file($_FILES['url_img']['tmp_name']) || !file_exists($_FILES['url_img']['tmp_name'])){
		$errors[] = 'Vous devez ajouter une photo.';
	}
	else{
		$finfo = new finfo();
		$mimeType = $finfo->file($_FILES['url_img']['tmp_name'], FILEINFO_MIME_TYPE);

		if(in_array($mimeType, $mimeTypeAllow)){
			$url_imgName = uniqid('url_img_');
			$url_imgName.= '.'.pathinfo($_FILES['url_img']['name'], PATHINFO_EXTENSION);


			if(!is_dir($dirUpload)){
				mkdir($dirUpload, 0755);
			}

			if(!move_uploaded_file($_FILES['url_img']['tmp_name'], $dirUpload.$url_imgName)){
				$errors[] = 'Erreur lors de l\'envoi de votre photo.';
			}
		}
		else{
			$errors[] = 'Le type de fichier est invalide. Seules les extensions jpg/jpeg/gif/png sont autorisées.';
		}

	}
// var_dump('merde');

		if (count($errors) === 0) {

			$insert = $bdd->prepare('INSERT INTO recipe(title, ingredient, preparation, url_img, date_creation, id_autor) VALUES (:title, :ingr, :preparation, :url_img, NOW(), :id_autor)');

			$insert->bindValue(':title', $post['title']);
			$insert->bindValue(':ingr', $post['ingredient']);
			$insert->bindValue(':preparation', $post['preparation']);
			$insert->bindValue(':url_img', 'img/recette/'.$url_imgName);
			$insert->bindValue(':id_autor', $_SESSION['user']['id']);

			if ($insert->execute()) {
				$formValid=true;
			}else {

			var_dump($insert->errorInfo());
			}

		} // fin count


} // fin verif


require_once 'header.php';

?>


			<main>

				<h1 class="text-center">Ajouter une recette</h1>

				<?php if(count($errors) > 0): ?>
					<div class="alert alert-danger">
						<?=implode('<br>', $errors);?>
					</div>

				<?php elseif(isset($formValid) && $formValid == true): ?>

					<div class="alert alert-success">
						La recette a été ajoutée.
					</div>
				<?php endif; ?>
                <div class="col-lg-8 col-lg-offset-2">
    				<form method="post" enctype="multipart/form-data">

    					<div class="form-group">
    						<label for="title">Titre : </label>
    						<input class='form-control' type="text" id="title" name="title" placeholder="ex : Poireaux aux ...">
    					</div>

                        <div class="form-group">
    						<label for="ingredient">Ingrédients : </label>
    						<input class='form-control' type="text" id="ingredient" name="ingredient" placeholder="ex : poireaux, courgettes, (séparer les ingrédients par une virgule)">
    					</div>

    					<div class="form-group">
    						<label for="preparation">Contenu : </label>
    						<textarea class='form-control' type="text" id="preparation" name="preparation" placeholder="Préparation, temps de cuisson, ...."></textarea>
    					</div>

    					<div class="form-group">
    						<label for="url_img">Photo : </label>
    						<input type="file" id="url_img" name="url_img">
    					</div>


    					<div class="form-group">
    						<input type="submit" name="submit" value="Envoyer" class="btn btn-info btn-lg center-block">
    					</div>
    				</form>
                </div>

			</main>
<?php
require_once '../admin/footer.php';
