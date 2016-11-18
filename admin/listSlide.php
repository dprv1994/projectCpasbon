<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../inc/functions.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}



$query = $bdd->prepare('SELECT * FROM slide');

if($query->execute()) {
	$slides = $query->fetchAll(PDO::FETCH_ASSOC);
}

require_once 'header.php';
?>

<h1>Liste des utilisateurs</h1>
        <?php if ($is_logged == 'admin') {
            echo '<a href="addslide.php"><button class="btn btn-xs btn-info" type="button">Ajouter un Slide</button></a><br><br>';
        }
        ?>

		<table class="table-striped col-lg-12">
			<thead>
				<tr>
					<th>Titre</th>
                    <th>Contenu</th>
					<th>Image</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($slides as $slide) {
					echo '<tr><td>'.$slide['title'].'</td><td>'.$slide['sub_title'].'</td><td>'.$slide['picture'].'</td><td>';
                    echo '<a href="viewSlide.php?id='.$slide['id'].'">Voir le slide</a>';
                    echo '</td><td>';
                    echo ($is_logged == 'admin') ? '<a href="updateSlide.php?id='.$slide['id'].'">Modifier le Slide</a>' : 'Vous n\'êtes pas autorisé à voir cette page.';
                    echo '</td></tr>';
				}
				?>
			</tbody>
		</table>

		<br><br><br>
<?php
require_once 'footer.php';
?>