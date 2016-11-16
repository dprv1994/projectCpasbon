<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';
require_once '../inc/functions.php';

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
		<ul>
			<?php
				echo '<li> <strong> Subject: </strong> '.$message['subject'].'</li> <li> <strong> Preparation : </strong> '.$message['content'].'</li> <li> <strong> Email : </strong>'.$message['email'].'</li> <li> <strong> Pseudo : </strong>'.$message['username'].'</li>'
			?>
		</ul>

		<br><br>
		
		<a href="delete_message.php?id=<?=$user['id'];?>" title="Editer cet utilisateur">Supprimer
		</a>
		
		<a href="index.php">Liste des messages</a>
	</body>
</html>
