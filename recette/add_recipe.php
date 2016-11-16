<?php  

require_once '../inc/session.php';
require_once '../inc/connect.php';
require_once '../inc/data.php';
require_once '../vendor/autoload.php';

use Respect\Validation\Validator as v;

$post = [];
$errors= [];
$dirUpload = 'img/';

if (!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));


	/*if (!v::alnum()->length(3, 30)->validate($post['title'])) {
		$errors[] = 'Vous devez entrer entre 3 et 30 caractères.';
	}

	if (!v::alnum()->length(15, 300)->validate($post['preparation'])) {
		$errors[] = 'Vous devez entrer entre 15 et 300 caractères.';	
	}*/

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


		if (count($errors) === 0) {

			$insert = $bdd->prepare('INSERT INTO recipe(title, preparation, url_img, date_creation, id_autor) VALUES (:title, :preparation, :url_img, NOW(), :id_autor)');

			$insert->bindValue(':title', $post['title']);
			$insert->bindValue(':preparation', $post['preparation']);
			$insert->bindValue(':url_img', $dirUpload.$url_imgName);
			$insert->bindValue(':id_autor', $_SESSION['user']['username']);

			if ($insert->execute()) {
				$formValid=true;
			}else {
			
			var_dump($insert->errorInfo());
			}
			
		} // fin count


} // fin verif










?><!DOCTYPE html>

	<html>

		<head>

			<meta charset="utf-8">
			<title>ajouter recette</title>

			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
			<link rel="stylesheet" type="text/css" href="">


		</head>

		<body>

			<main class="container">

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

				<form method="post" enctype="multipart/form-data">

					<div class="form-group">
						<label for="title">Titre : </label>
						<input type="text" id="title" name="title">
					</div>

					<div class="form-group">
						<label for="preparation">Contenu : </label>
						<textarea type="text" id="preparation" name="preparation"></textarea>
					</div>

					<div class="form-group">
						<label for="url_img">Photo : </label>
						<input type="file" id="url_img" name="url_img">
					</div>


					<div class="form-group">
						<input type="submit" name="submit" value="Envoyer" class="btn">
					</div>

				</form>

			</main>

		</body>

	</html>