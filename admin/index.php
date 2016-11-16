<?php 

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';






 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>Back</title>
 </head>
 <body>

 	<h1>Modification site du restaurant</h1>
 		
 		<div>
	 		<label for="name">Nom Restaurant:</label>
	 		<input type="text" id="name" name="name">
	 		<br><br>

	 		<label for="adress">Adresse:</label>
	 		<input type="text" id="adress" name="adress">
	 		<br><br>

	 		<label for="zipcode">Code Postal:</label>
	 		<input type="text" id="zipcode" name="zipcode">
	 		<br><br>

	 		<label for="city">Ville:</label>
	 		<input type="text" id="city" name="city">
	 		<br><br>

	 		<label for="phone">Téléphone:</label>
	 		<input type="num" id="phone" name="phone">
	 		<br><br>

	 		<label for="picture">Photo:</label>
	 		<input type="file" id="picture" name="picture">
	 		<br><br>
	 		
	 		<input type="submit" value="Modifier">
		</div>	

		<div>
			
			<h2>Vos Messages:</h2>

			<hr>
				<table class="table">
					<thead>
						<tr>
							<th>icone</th>
							<th>email</th>
							<th>Sujet</th>
						</tr>	
					</thead>

					<tbody>
						<?php foreach ($users as $user): ?>
							<tr>
								<td><?=$user['']?></td>
								<td><?=$user['email']?></td>
								<td><?=$user['subject']?></td>
								<td>
									<a  href="view_user.php?id=<?=$user['id'];?>" title="Voir le message">Editer</a>
									&nbsp; - &nbsp;
									<a href="delete_user.php?id=<?=$user['id'];?>" title="Editer cet utilisateur">Supprimer</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>



 
 </body>
 </html>