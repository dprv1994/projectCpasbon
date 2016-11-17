<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';
require_once '../inc/functions.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}



if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$query = $bdd->prepare('SELECT * FROM users WHERE id = :idUser');
	$query->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

	if($query->execute()) {
		$user = $query->fetch();
	}
	else {
		var_dump($query->errorInfo());
		die;
	}
}else {
    header('Location:listUser.php');
    die;
}


require_once 'header.php';
?>

        <ul>
			<?php
				echo '<li> <strong> Nom : </strong> '.$user['lastname'].'</li> <li> <strong> Prénom : </strong> '.$user['firstname'].'</li> <li> <strong> Email : </strong>'.$user['email'].'</li> <li> <strong> Pseudo : </strong>'.$user['username'].'</li> <li> <strong> Rôle : </strong>'.affichRole($user['role']).'</li> <li> <strong> Avatar : </strong> <img src="'.$user['avatar'].'"> </li> <li> <a href="deleteUser.php?id='.$user['id'].'">Suppression</a> </li>';
			?>
		</ul>

		<br><br>

		<a href="addUser.php">Ajout d'utilisateur</a>
		<a href="listUser.php">Liste des utilisateurs</a>
	</body>
</html>
