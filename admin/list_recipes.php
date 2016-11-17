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
		<table class="table-striped col-lg-12">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Préparation</th>
					<th>Photo</th>
					<th>Date de création</th>
					<th>Nom de l'auteur</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($recipes as $recipe) {
					echo '<tr>
					<td>'.$recipe['title'].'</td>'.'
					<td>'.$recipe['preparation'].'</td>'.'
					<td>'.'<span id="img" class="imgClass">'.'<img src="'.$recipe['url_img'].'"'.'</span></td>'.'
					<td>'.date('d/m/Y H:i:s', strtotime($recipe['date_creation'])).'</td>'.'
					<td>'.'<td>'.$recipe['id_autor'].'</td>'.'
					<td><a href="update_recipe.php?id='.$recipe['id'].'">Modifier l\'utilisateur</a></td>'.'<td>
					<a href="_recipe.php?id='.$recipe['id'].'">Voir la recette</a></td>'.'
					</tr>'; 
					}
				?>
				<!-- pour afficher date modification fichier filemtime ( string $filename ) -->
			</tbody>
		</table>

		<br><br>

		<a href="add_recipe.php">Ajouter une recette</a>
	</body>
</html> 