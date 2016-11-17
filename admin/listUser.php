<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}



$query = $bdd->prepare('SELECT * FROM users');

if($query->execute()) {
	$users = $query->fetchAll(PDO::FETCH_ASSOC);
}

require_once 'header.php';
?>
        <h1>Liste des utilisateurs :</h1>
		<table class="table-striped col-lg-12">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Email</th>
					<th>Pseudo</th>
					<th>Modifier</th>
					<th>Information</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($users as $user) {
					echo '<tr><td>'.$user['lastname'].'</td>'.'<td>'.$user['firstname'].'</td>'.'<td>'.$user['email'].'</td>'.'<td>'.$user['username'].'</td>'.'<td><a href="updateUser.php?id='.$user['id'].'">Modifier l\'utilisateur</a></td>'.'<td><a href="viewUser.php?id='.$user['id'].'">Voir l\'utilisateur</a></td>'.'</tr>';
					}
				?>
			</tbody>
		</table>

		<br><br>

		<a href="addUser.php">Ajout d'utilisateur</a>
	</body>
</html>
