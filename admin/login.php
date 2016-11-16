<?php 

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once 'vendor/autoload.php';



$post = [];
$error = [];
$success = false;
$hasError = false;

use Respect\Validation\Validator as verif;

if (!empty($_SESSION)) {
	header('Location:../index.php');

	if(!$verif::length(3,null)->validate($post['username'])){
			$error[] = 'L\'username doit faire au moins 3 caractères';
		}

	if (!$verif::length(3, null)->validate($post['password'])) {
			$error[] = 'le mot de passe doit faire au moin 3 caractères';
		}

	if (count($error)===0) {
		$select = $bdd-> prepare('SELECT * FROM users WHERE username = :username');
		$select->bindValue(':username', $post['username']);

		if ($select->execute()) {
			$user = $select->fetch(PDO::FETCH_ASSOC);

			if (password_verify($post['password'], $user['password'])) {
				
				$success = true;

				if ($success) {
					$_SESSION['user'] = $user;
					header('Location: index.php');
				}
				else{
					header('Location: login.php');
				}
			}
			else{
				$error[] = 'Le couple identifiant/mot de passe est incorrect';
				$hasError = true;
			}
		}
	}
	else{
		$hasError = true;
	}


}
 ?>

 <!DOCTYPE html>
 <html lang="fr">
 <head>
 <meta charset="utf-8">
 	<title>Login</title>
 </head>
 <body>

	<?php
		if ($hasError){
		 		echo '<p style="color:red;">'.implode('<br>', $error).'</p>';
			}

		if($success){
			echo '<p style="color:green;">LOGIN OK !</p>';
		}
	  ?>

 	<h1>Connexion</h1>	

	 <form method="post">
		 <label for="username">Nom de l'utlisateur:</label>
		 <input type="text" id="username" name="username">
		 <br><br>

		 <label for="password">Mot de passe:</label>
		 <input type="password" id="password" name="password">
		 <br><br>

		 <button id="" name="" class="btn btn-info ">Connexion</button>

		 </form>
 
 </body>
 </html>