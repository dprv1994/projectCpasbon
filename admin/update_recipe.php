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
$updatephoto = false ;


if(isset($is_logged)) {


	if (!empty($_POST)) {
		$post = array_map('trim', array_map('strip_tags', $_POST));


		if (!v::length(3, 30)->validate($post['title'])) {
			$errors[] = 'Vous devez entrer entre 3 et 30 caractères.';
		}

		if (!v::length(15, 300)->validate($post['preparation'])) {
			$errors[] = 'Vous devez entrer entre 15 et 300 caractères.';
		}

		if (strlen($_FILES['url_img']['name']) > 0) {
			$updatephoto = true;
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
		}


			if (count($errors) === 0) {

				$columnSQL = 'title = :title, preparation = :preparation, id_autor = :id_autor, date_creation = NOW()';

				if ($updatephoto) {
					$columnSQL.=', url_img = :url_img';
				}

				$update = $bdd->prepare('UPDATE recipe SET '.$columnSQL.' WHERE id = :idRecipe'); /* /!\ajouter date*/

				$update->bindValue(':title', $post['title']);
				$update->bindValue(':preparation', $post['preparation']);
				$update->bindValue(':id_autor', $_SESSION['user']['id']);

				$update->bindValue(':idRecipe', $_GET['id'], PDO::PARAM_INT);

				if ($updatephoto) {
					$update->bindValue(':url_img', $_FILES['url_img']);
				}

				if ($update->execute()) {
					$formValid=true;
				}else {

				var_dump($update->errorInfo());
				}

			} // fin count


	} // fin verif


if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$select = $bdd->prepare('SELECT * FROM recipe WHERE id = :idRecipe');
	$select->bindValue(':idRecipe', $_GET['id'], PDO::PARAM_INT);

	if($select->execute()){
		$recipe = $select->fetch(PDO::FETCH_ASSOC);
	}
}
} //fin islogged


require_once 'header.php';

?>

				<h1 class="text-center">Mettre à jour la recette</h1>

				<?php if(count($errors) > 0): ?>
					<div class="alert alert-danger">
						<?=implode('<br>', $errors);?>
					</div>

				<?php elseif(isset($formValid) && $formValid == true): ?>

					<div class="alert alert-success">
						La recette a été mise à jour.
					</div>
				<?php endif; ?>

				<?php if(!empty($recipe)): ?>

					<form method="post" enctype="multipart/form-data">

                        <img class="img-responsive" src="<?=$recipe['url_img'];?>" alt="" />

						<div class="form-group">
							<label for="title">Titre : </label>
							<input class="form-control" type="text" id="title" name="title" value="<?=$recipe['title'];?>">
						</div>

						<div class="form-group">
							<label for="preparation">Contenu : </label>
							<textarea class="form-control" type="text" id="preparation" name="preparation"><?=$recipe['preparation'];?></textarea>
						</div>

						<div class="form-group">
							<label for="url_img">Photo : </label>
							<input type="file" id="url_img" name="url_img">
						</div>


						<div class="form-group">
							<input class="btn btn-info btn-lg center-block" type="submit" name="submit" value="Mettre à jour" class="btn">
						</div>

					</form>

				<?php endif; ?>

			</main>
<?php require_once  'footer.php'; ?>
