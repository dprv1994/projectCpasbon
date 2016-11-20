<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

//   requete pour affichage des messages non lus
$query = $bdd->prepare('SELECT * FROM message WHERE read_msg = 0');
if ($query->execute()) {
	$users = $query->fetchAll(PDO::FETCH_ASSOC);

}
//   requete pour affichage des infos
$query = $bdd->query('SELECT * FROM contact_information ');
if ($query->execute()) {
	$info = $query->fetchAll(PDO::FETCH_ASSOC);
}

//   requete pour affichage des recettes
$query = $bdd->query('SELECT recipe.* , users.username FROM recipe LEFT JOIN users ON recipe.id_autor = users.id ORDER BY recipe.date_creation LIMIT 10');
if ($query->execute()) {
	$preparation = $query->fetchAll(PDO::FETCH_ASSOC);
}

require_once 'header.php';
 ?>
<code>

    a faire :<br>
    mettre input à la place textarea en dernière solution
    Penser a mettre Unique au champ email dans la table <br>
    Uniformiser le nom des fichier ?????????? <br>
    commenter notre code <br>


</code>
<br><br>
 		<div>
            <h1><?= $info[0]['value']; ?></h1>
                <?= (isset($is_logged) && $is_logged == 'admin') ? '<a class="btn btn-info btn-xs" href="editInfoResto.php">Modifier les informations du restaurant</a><br><br>' : '' ; ?>
            <span><b>Adresse :</b> <?= $info[1]['value'] . ' , ' . $info[2]['value'] . ' , ' .$info[3]['value'] . ' - <b>Téléphone : </b>' .$info[4]['value']; ?></span>

		</div>

		<hr>

<?php if ($is_logged == 'admin'): ?>
    <div>
        <h2>Vos Messages</h2>
        <a class="btn btn-info btn-xs" href="listMessages.php">Afficher tous les messages</a>
                        <table class="table">
                <thead>
                    <tr>
                        <th>Lu/Non lu</th>
                        <th>Objet</th>
                        <th>Expéditeur</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= ($user['read_msg'] == 0)? 'non lu': 'lu' ; ?></td>
                            <td><?=$user['subject']?></td>
                            <td><?=$user['email']?></td>

                            <td>
                                <a  href="view_message.php?id=<?=$user['id'];?>" title="Voir le message"><i class='glyphicon glyphicon-pencil'></i> Voir le message</a>
                                &nbsp; - &nbsp;
                                <a href="deleteMessage.php?id=<?=$user['id'];?>" title="Supprimer le message"><i class="glyphicon glyphicon-remove"></i> Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>

    <hr>
<?php endif; ?>

		<div>
			<h2>Liste des recettes</h2>
            <a class="btn btn-xs btn-info" href="list_recipes.php">Afficher toutes les recettes</a><br><br>
				<table class="table">
					<thead>
						<tr>
							<th>Titre</th>
							<th>Recette</th>
							<th>Date de création</th>
							<th>Auteur</th>
                            <th>Action</th>

						</tr>
					</thead>

					<tbody>
						<?php foreach ($preparation as $prep): ?>
							<tr>
								<td><?=$prep['title']?></td>
								<td><?=$prep['preparation']?></td>
								<td><?=date('d/m/Y H:i', strtotime($prep['date_creation']))?></td>
								<td><?=$prep['username']?></td>

								<td>
									<a  href="update_recipe.php?id=<?=$prep['id'];?>" title="Modifier la recette"><i class='glyphicon glyphicon-pencil'></i></a>
								</td>
                                <td>
                                    <a href="delete_recipe.php?id=<?=$prep['id'];?>" title="Supprimer la recette"><i class="glyphicon glyphicon-remove"></i></a>

                                </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>



 </body>
 </html>
