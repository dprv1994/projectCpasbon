<?php 

require_once '../inc/connect.php';
require_once '../header.php';




$post = [];
$error = [];
$success = false;
$hasError = false;
$verif = new Respect\Validation\Validator;

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
					];
					header('Location: index.php')

				}
			}
		}
	}


}
 ?>

 <!DOCTYPE html>
 <html lang="fr">
 <head>
 <meta charset="utf-8">
 	<title>Back</title>

		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

 </head>
 <body>

 	<h1 class="text-center text-info">
		<i class="fa fa-user-circle" aria-hidden="true"> Connexion</i>
	</h1>	

	<main class="container text-center">

		 <form method="post">
		 	<label for="username">Nom de l'utlisateur:</label>
		 	<input type="text" id="username" name="username">
		 	<br><br>

		 	<label for="password">Mot de passe:</label>
		 	<input type="password" id="password" name="password">
		 	<br><br>

		 	<button id="" name="" class="btn btn-info ">Connexion</button>

		 </form>
	</main>
 
 </body>
 </html>