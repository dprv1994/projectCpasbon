<?php

require_once '../inc/session.php';
require_once '../inc/connect.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}


$query = $bdd->prepare('SELECT * FROM recipe');
	if($query->execute()){
		$recipes = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	else {
		var_dump($query->errorInfo());
		die;
	}


require_once 'header.php';
?>
        <h1>Liste des recettes :</h1>
        <a href="add_recipe.php" class='btn btn-xs btn-info'>Ajout d'un recette</a>
        <br><br>
		<table class="table-striped col-lg-12">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Préparation</th>
					<th>Date de création</th>
					<th>Auteur</th>
                    <th></th>
                    <th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($recipes as $recipe) {
					echo '<tr>
					<td>'.$recipe['title'].'</td>
					<td>'.$recipe['preparation'].'</td>
					<td>'.date('d/m/Y H:i:s', strtotime($recipe['date_creation'])).'</td>
					<td>'.$recipe['id_autor'].'</td>
                    <td style="min-width:20px;"><a  href="update_recipe.php?id='.$recipe['id'].'" title="Modifier recette"><i class="glyphicon glyphicon-pencil"></i> </a></td>
                    <td style="min-width:20px;"><a href="delete_recipe.php?id='.$recipe['id'].'" title="Supprimer recette"><i class="glyphicon glyphicon-remove"></i></a></td></tr>';
					}
				?>
				<!-- pour afficher date modification fichier filemtime ( string $filename ) -->
			</tbody>
		</table>

		<br><br>
	</body>
</html>
