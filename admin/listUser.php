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
        <h1>Liste des utilisateurs :
        <?php if ($is_logged == 'admin') {
            echo '<a href="addUser.php"><button class="btn btn-xs btn-info" type="button">Ajout d\'utilisateur</button></a>';
        }
        ?>
        </h1>
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
					echo '<tr><td>'.$user['lastname'].'</td><td>'.$user['firstname'].'</td><td>'.$user['email'].'</td><td>'.$user['username'].'</td><td>';
                    echo ($is_logged == 'admin') ? '<a href="updateUser.php?id='.$user['id'].'">Modifier l\'utilisateur</a>' : 'Non autorisé';
                    echo '</td><td>';
                    echo '<a href="viewUser.php?id='.$user['id'].'">Voir l\'utilisateur</a>';
                    echo '</td></tr>';
				}
				?>
			</tbody>
		</table>

		<br><br><br>
<?php 
require_once 'footer.php';
?>
