<?php  

require_once '../inc/session.php';
require_once '../inc/connect.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}


$user = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	if (!empty($_POST)) {
		if (isset($_POST['delete'])) {
			
			$delete = $bdd->prepare('DELETE FROM users WHERE id = :idUser');
			$delete->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

			if ($delete->execute()) {
				header('Location: listUser.php');
				die;
			}
		}
	}

	$select = $bdd->prepare('SELECT * FROM users WHERE id = :idUser');
	$select->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);
	if ($select->execute()) {
		$user = $select->fetch(PDO::FETCH_ASSOC);
	}	
} //fin verif

require_once 'header.php';
?>

		<h1>Supprimer un Utilisateur</h1>

		<main class="container">

		<?php if(empty($user)): ?>
			<div class="alert alert-danger">
				Cet utilisateur n'existe pas.
			</div>
		<?php else: ?>
			<p>Voulez-vous vraiment supprimer la recette : <?=$user['username'];?>?</p>
		<?php endif; ?>

			<form method="POST">
				
				 <input type="button" onclick="history.back();" value="Annuler" class="btn btn-default">

				 <input type="submit" name="delete" value="Oui, je veux supprimer cette recette." class="btn btn-success">
			</form>

		</main>

		</body>
	</html>