<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';
require_once '../inc/functions.php';

$lu = false;

if (!isset($is_logged) && $is_logged == 'editeur') {
    header('Location:login.php');
    die;
}

if(isset($_POST['msgLu'])) {

	$_POST['msgLu'] = 1;

	if($_POST['msgLu'] === 1){
		$read = $bdd->prepare('UPDATE message SET read_msg = :read WHERE id = :idMessage');
		$read->bindValue(':idMessage', $_GET['id']);
		$read->bindValue(':read', $_POST['msgLu']);

		if($read->execute()) {
			$lu = true;
		}
	}
}
elseif(isset($_POST['msgNonLu'])) {
	$_POST['msgNonLu'] = 0;

	if($_POST['msgNonLu'] === 0){
		$read = $bdd->prepare('UPDATE message SET read_msg = :read WHERE id = :idMessage');
		$read->bindValue(':idMessage', $_GET['id']);
		$read->bindValue(':read', $_POST['msgNonLu']);

		if($read->execute()) {
			$lu = true;
		}
	}
}

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$query = $bdd->prepare('SELECT * FROM message WHERE id = :idMessage');
	$query->bindValue(':idMessage', $_GET['id'], PDO::PARAM_INT);

	if($query->execute()) {
		$message = $query->fetch();
	}
	else {
		var_dump($query->errorInfo());
		die;
	}
}

require_once 'header.php';

?>

        <h1>Message de <?=$message['username'];?></h1>

        <strong> Pseudo : </strong><?=$message['username'];?><br>
        <strong> Email : </strong><?=$message['email'];?><br>
        <strong> Subject: </strong><?=$message['subject'];?><br>
        <strong>Message : </strong>
        <br><?=$message['content'];?><br>
        <br><br>

        <form method="post">
      		<?php if($message['read_msg'] == 0) : ?>
        		<input type="submit" name="msgLu" id="msgLu" class="btn btn-success btn-lg" value="icone qui va bien Lus">
        	<?php elseif($message['read_msg'] == 1) : ?>
        		<input type="submit" name="msgNonLu" id="msgNonLu" class="btn btn-warning btn-lg" value="icone qui va bien Non Lus">
        	<?php endif; ?>
        </form>

        <a class="btn btn-info btn-lg"  href="listMessages.php">Liste des messages</a>
		<a class="btn btn-danger btn-lg" href="deleteMessage.php?id=<?=$message['id'];?>" title="Editer cet utilisateur">Supprimer</a>

	</body>
</html>