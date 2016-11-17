<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';
require_once '../inc/functions.php';

if (!isset($is_logged) && $is_logged == 'editeur') {
    header('Location:login.php');
    die;
}


if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$query = $bdd->prepare('SELECT * FROM message WHERE id = :idUser');
	$query->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

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


        <a class="btn btn-info btn-lg"  href="listMessages.php">Liste des messages</a>
		<a class="btn btn-danger btn-lg" href="deleteMessage.php?id=<?=$message['id'];?>" title="Editer cet utilisateur">Supprimer</a>

	</body>
</html>
