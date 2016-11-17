<?php  

require_once '../inc/session.php';
require_once '../inc/connect.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}


$recipe = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	if (!empty($_POST)) {
		if (isset($_POST['delete'])) {
			
			$delete = $bdd->prepare('DELETE FROM message WHERE id = :idMessage');
			$delete->bindValue(':idMessage', $_GET['id'], PDO::PARAM_INT);

			if ($delete->execute()) {
				header('Location: view_message.php');
				die;
			}
		}
	}

	$select = $bdd->prepare('SELECT * FROM message WHERE id = :idUser');
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