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

if(isset($_POST['delete'])){
	if(isset($_POST['delete'])){ 
		$delete = $bdd->prepare('DELETE FROM users WHERE id = :idUser');
		$delete->bindValue(':idUser', $_GET['id'], PDO::PARAM_INT);

		if($delete->execute()){
			header('Location: listUser.php'); 
			die;
		}
	}
}

require_once 'header.php';
?>
		<ul>
			<?php
				echo '<li> <strong> Nom : </strong> '.$user['lastname'].'</li> <li> <strong> Prénom : </strong> '.$user['firstname'].'</li> <li> <strong> Email : </strong>'.$user['email'].'</li> <li> <strong> Pseudo : </strong>'.$user['username'].'</li> <li> <strong> Rôle : </strong>'.affichRole($user['role']).'</li> <li> <strong> Avatar : </strong> <img src="'.$user['avatar'].'"> </li>';
			?>
		</ul>
		<br>
		<form method="post">
			<button class="deleteB" id="delete" name="delete" onClick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?'))
			alert('Utilisateur supprimer !');">
				Supprimer l'utilisateur
			</button>
		</form>
		<br><br>

		<a href="addUser.php">Ajout d'utilisateur</a>
		<a href="listUser.php">Liste des utilisateurs</a>

		<script type="text/javascript" src="../js/script.js"></script>
	</body>
</html>
