<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}



$query = $bdd->prepare('SELECT * FROM message WHERE read_msg = 0');
if ($query->execute()) {
	$users = $query->fetchAll(PDO::FETCH_ASSOC);

}

$query = $bdd->prepare('SELECT * FROM contact_information');
if ($query->execute()) {
	$info = $query->fetch(PDO::FETCH_ASSOC);

}

$query = $bdd->prepare('SELECT * FROM recipe ORDER BY date_creation LIMIT 5');
if ($query->execute()) {
	$preparation = $query->fetchAll(PDO::FETCH_ASSOC);


}



require_once 'header.php';
 ?>
<code>

    a faire :<br>
    id auteur : rechercher si c l'id ou le nom que l'on doit rentrer et sinon si c l'id faire une jointure.<br>
    Penser a mettre Unique au champ email dans la table <br>
    Uniformiser le nom des fichier ?????????? <br>
    page 404 a faire

</code>
<br><br>
 		<div>
            <h1><?= $info['name']; ?></h1>
                <?= (isset($is_logged) && $is_logged == 'admin') ? '<a class="btn btn-info btn-xs" href="editInfoResto.php">Modifier les infos du restaurant</a><br><br>' : '' ; ?>
            <span><?= $info['adress'] . ' - ' . $info['zipcode'] . ' - ' .$info['city'] . ' - ' .$info['phone']; ?></span>

		</div>

		<hr>

<?php if ($is_logged == 'admin'): ?>
    <div>
        <h2>Vos Messages:</h2>
        <a class="btn btn-info btn-xs" href="listMessages.php">afficher tous les messages</a>
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
                            <td><?= ($user['read_msg'] == 0)? 'non lu': 'lu' ; ?></td>
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
<?php endif; ?>

		<div>
			<h2>Liste de recette:</h2>
            <a class="btn btn-xs btn-info" href="list_recipes.php">afficher toute les recettes</a><br><br>
				<table class="table">
					<thead>
						<tr>
							<th>titre</th>
							<th>recette</th>
							<th>date/heure</th>
							<th>Auteur</th>

						</tr>
					</thead>

					<tbody>
						<?php foreach ($preparation as $prep): ?>
							<tr>
								<td><?=$prep['title']?></td>
								<td><?=$prep['preparation']?></td>
								<td><?=$prep['date_creation']?></td>
								<td><?=$prep['id_autor']?></td>

								<td>
									<a  href="update_recipe.php?id=<?=$prep['id'];?>" title="Modifier recette"><i class='glyphicon glyphicon-pencil'></i></a>
								</td>
                                <td>
                                    <a href="delete_recipe.php?id=<?=$prep['id'];?>" title="Supprimer recette"> <i class="glyphicon glyphicon-remove"></i></a>

                                </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>



 </body>
 </html>
