<?php

require_once '../inc/session.php';
require_once '../inc/connect.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

require_once 'search.php';

$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$max = 5;

$debut = ($page - 1) * $max; 

	$query = $bdd->prepare('SELECT r.*, u.firstname , u.lastname, u.username, u.avatar
            FROM recipe AS r
            LEFT JOIN users AS u
            ON r.id_autor = u.id
            '.$sql .'
            ORDER BY r.date_creation DESC LIMIT  :max OFFSET :debut');
	/*$query->bindValue(':start',$start,PDO::PARAM_INT):start,;*/
	$query->bindValue(':debut',$debut,PDO::PARAM_INT);
	$query->bindValue(':max',$max,PDO::PARAM_INT);

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
        <div class="row">
            <form method="get" class="col-lg-6">
                <div class="input-group">
                   <input type="search" name="search" class="form-control" placeholder="Pâtes aux .....">
                   <span class="input-group-btn">
                     <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                   </span>
                 </div><!-- /input-group -->
                 <br>

    		</form>
        </div>
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
						<td colspan="6">Nous n'avons rien trouvé, retentez votre chance !</td>
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
						<td style="min-width:20px;"><?php echo $recipe['username'];?></td>
	                    <td style="min-width:20px;"><a  href="update_recipe.php?id=<?= $recipe['id']?>" title="Modifier recette"><i class="glyphicon glyphicon-pencil"></i> </a>
	                    <a href="delete_recipe.php?id=<?= $recipe['id']?>" title="Supprimer recette"><i class="glyphicon glyphicon-remove"></i></a></td>
	                    </tr>
					<?php } ?>
					
			<?php  }?>
			</tbody>
		</table>

		<div><a href="?page=<?php echo $page - 1; ?>">Page précédente</a>
		<a href="?page=<?php echo $page + 1; ?>">Page suivante</a></div>

		<br><br>
	</body>
</html>
