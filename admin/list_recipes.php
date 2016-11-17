<?php

require_once '../inc/session.php';
require_once '../inc/connect.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

require_once 'search.php';


	$query = $bdd->prepare('SELECT * FROM recipe '.$sql);

if(!empty($sql)){
	$query->bindValue(':search', '%'.$get['search'].'%');
}

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
        <a href="add_recipe.php" class='btn btn-xs btn-info'>Ajouter une recette</a>
        <br><br>

        <form method="get">

        <input type="text" name="search" placeholder="Rechercher">
        <button type="submit"><i class="glyphicon glyphicon-search"></i></button>
		</form>
		<table class="table-striped col-lg-12">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Préparation</th>
					<th>Date de création</th>
					<th>Auteur</th>
                    <th>Action</th>
				</tr>
			</thead>

			<tbody>

				<?php if (empty($recipes)) { ?>
						<tr>
						<td colspan="6">on a rien trouvé</td>
					</tr>
				<?php }
						else { ?>
				
					<?php foreach ($recipes as $recipe) { ?>

						<tr>

						<td>
							<?php  if(isset($get['search']) && !empty($get['search'])){
								echo preg_replace('/'.$get['search'].'/', '<mark>'.$get['search'].'</mark>', $recipe['title']);
							} 
							else { 
								echo $recipe['title'];
							} ?>
						</td>
						<td><?php  if(isset($get['search']) && !empty($get['search'])){
								echo preg_replace('/'.$get['search'].'/', '<mark>'.$get['search'].'</mark>', $recipe['preparation']);
							} 
							else { 
								echo $recipe['preparation'];
							} ?></td>
						<td><?php  if(isset($get['search']) && !empty($get['search'])){
								echo preg_replace('/'.$get['search'].'/', '<mark>'.$get['search'].'</mark>', date('d/m/Y H:i', strtotime($recipe['date_creation'])));
							} 
							else { 
								echo date('d/m/Y H:i', strtotime($recipe['date_creation']));
							}?></td>
						<td style="min-width:20px;"><?php echo $recipe['id_autor'];?></td>
	                    <td style="min-width:20px;"><a  href="update_recipe.php?id=<?php $recipe['id']?>" title="Modifier recette"><i class="glyphicon glyphicon-pencil"></i> </a>
	                    <a href="delete_recipe.php?id=<?php  $recipe['id']?>" title="Supprimer recette"><i class="glyphicon glyphicon-remove"></i></a></td>
	                    </tr>
					<?php } ?>
					
					<!-- pour afficher date modification fichier filemtime ( string $filename ) -->
			<?php  }?>
			</tbody>
		</table>

		<br><br>
	</body>
</html>
