<?php  

require_once '../inc/session.php';
require_once '../inc/connect.php';


$recipe = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	if (!empty($_POST)) {
		if (isset($_POST['delete'])) {
			
			$delete = $bdd->prepare('DELETE FROM recipe WHERE id = :idRecipe');
			$delete->bindValue(':idRecipe', $_GET['id'], PDO::PARAM_INT);

			if ($delete->execute()) {
				header('Location: list_recipes.php');
				die;
			}
		}
	}

	$select = $bdd->prepare('SELECT * FROM recipe WHERE id = :idRecipe');
	$select->bindValue(':idRecipe', $_GET['id'], PDO::PARAM_INT);
	if ($select->execute()) {
		$recipe = $select->fetch(PDO::FETCH_ASSOC);
	}	
} //fin verif


?><!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>supprimer recette</title>
		</head>

		<body>

		<h1>Supprimer une recette</h1>

		<main class="container">

		<?php if(empty($recipe)): ?>
			<div class="alert alert-danger">
				Cette recette n'existe pas.
			</div>
		<?php else: ?>
			<p>Voulez-vous vraiment supprimer la recette : <?=$recipe['title'];?>?</p>
		<?php endif; ?>

			<form method="POST">
				
				 <input type="button" onclick="history.back();" value="Annuler" class="btn btn-default">

				 <input type="submit" name="delete" value="Oui, je veux supprimer cette recette." class="btn btn-success">
			</form>

		</main>

		</body>
	</html>