<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

$query = $bdd->prepare('SELECT * FROM message');
if ($query->execute()) {
	$users = $query->fetchAll(PDO::FETCH_ASSOC);

}

$query = $bdd->prepare('SELECT * FROM contact_information');
if ($query->execute()) {
	$info = $query->fetch(PDO::FETCH_ASSOC);

}

$query = $bdd->prepare('SELECT * FROM recipe');
if ($query->execute()) {
	$preparation = $query->fetchAll(PDO::FETCH_ASSOC);


}



require_once 'header.php';
 ?>


 		<div>
            <h1>
                <?= $info['name']; ?>
            </h1>
            <span><?= $info['adress'] . ' - ' . $info['zipcode'] . ' - ' .$info['city'] . ' - ' .$info['phone']; ?>
                <?= (isset($is_logged) && $is_logged == 'admin') ? '<a href="editInfoResto.php">Modifier les infos du restaurant</a>' : '' ; ?>
            </span>

		</div>

		<hr>

		<div>
			<h2>Vos Messages:</h2>

							<table class="table">
					<thead>
						<tr>
							<th>Lu/Pas lu</th>
							<th>Sujet</th>
							<th>email</th>

						</tr>
					</thead>

					<tbody>
						<?php foreach ($users as $user): ?>
							<tr>
								<td><?=$user['see']?></td>
								<td><?=$user['subject']?></td>
								<td><?=$user['email']?></td>

								<td>
									<a  href="view_message.php?id=<?=$user['id'];?>" title="Voir le message">Voir message</a>
									&nbsp; - &nbsp;
									<a href="delete_message.php?id=<?=$user['id'];?>" title="Editer cet utilisateur">Supprimer</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>

		<hr>

		<div>
			<h2>Liste de recette:</h2>

				<table class="table">
					<thead>
						<tr>
							<th>titre</th>
							<th>recette</th>
							<th>photo</th>
							<th>date/heure</th>
							<th>#</th>

						</tr>
					</thead>

					<tbody>
						<?php foreach ($preparation as $prep): ?>
							<tr>
								<td><?=$prep['title']?></td>
								<td><?=$prep['preparation']?></td>
								<td><?=$prep['url_img']?></td>
								<td><?=$prep['date_creation']?></td>
								<td><?=$prep['id_autor']?></td>

								<td>
									<a  href="update_recipe.php?id=<?=$prep['id'];?>" title="Actualiser recette">Actualiser recette</a>
									&nbsp; - &nbsp;
									<a href="delte_recette.php?id=<?=$prep['id'];?>" title="Supprimer recette">Supprimer recette</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>



 </body>
 </html>
