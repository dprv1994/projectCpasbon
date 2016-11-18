<?php

require_once '../inc/session.php';
require_once '../inc/connect.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}


$slide = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	if (!empty($_POST)) {
		if (isset($_POST['delete'])) {

			$delete = $bdd->prepare('DELETE FROM contact_information WHERE id = :idSlide');
			$delete->bindValue(':idSlide', $_GET['id'], PDO::PARAM_INT);

			if ($delete->execute()) {
				header('Location: editInfoResto.php');
				die;
			}
		}
	}


	$select = $bdd->prepare('SELECT value FROM contact_information WHERE id = :idSlide');
	$select->bindValue(':idSlide', $_GET['id'], PDO::PARAM_INT);
	if ($select->execute()) {
		$slide = $select->fetch(PDO::FETCH_ASSOC);
        $slide = explode(',',$slide['value']);
        $slideTitle = $slide[0];
        $slideContent = $slide[1];
        $slideUrl = $slide[2];
	}
} //fin verif

require_once 'header.php';

?>

<h1>Supprimer le profil</h1>

		<main class="container">

		<?php if(empty($slide)): ?>
			<div class="alert alert-danger">
				Ce Slide n'existe pas.
			</div>
		<?php else: ?>
			<p>Voulez-vous vraiment supprimer le Slide : <?=$slideTitle;?>?</p>
            <img src="<?=$slideUrl;?>" alt="" />
            <p><?=$slideContent;?></p>
		<?php endif; ?>

			<form method="POST">

				 <input type="button" onclick="history.back();" value="Annuler" class="btn btn-default">

				 <input type="submit" name="delete" value="Oui, je veux supprimer ce Slide." class="btn btn-success">
			</form>

		</main>
<?php require_once 'footer.php'; ?>
