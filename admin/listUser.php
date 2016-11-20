<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../inc/functions.php';
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
        <h1>Liste des utilisateurs</h1>
        <?php if ($is_logged == 'admin') {
            echo '<a href="addUser.php"><button class="btn btn-xs btn-info" type="button">Ajouter un profil</button></a><br><br>';
        }
        ?>

		<table class="table-striped col-lg-12 col-sm-12">
			<thead>
				<tr>
					<th>Statut</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Adresse email</th>
					<th>Pseudo</th>
                    <th>Information</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($users as $user) {
					echo '<tr><td>'. affichRole($user['role']).'</td><td>'.$user['lastname'].'</td><td>'.$user['firstname'].'</td><td>'.$user['email'].'</td><td>'.$user['username'].'</td><td>';
                    echo '<a href="viewUser.php?id='.$user['id'].'">Voir le profil</a>';
                    echo '</td>';
                    echo '</tr>';
				}
				?>
			</tbody>
		</table>

		<br><br><br>
<?php
require_once 'footer.php';
?>
