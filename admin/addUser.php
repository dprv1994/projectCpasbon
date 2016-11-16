<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

use Respect\Validation\Validator as verif;

$post=[];
$errors=[];
$formValid=false;
$hasError=false;
$dirUpload='../img/';

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!verif::length(3, null)->validate($post['lastname'])) {
		$errors[] = 'Veuillez entrer un Nom valide';
	}

	if(!verif::length(3, null)->validate($post['firstname'])) {
		$errors[] = 'Veuillez entrer un Prénom valide';
	}

	if(!verif::email()->validate($post['email'])) {
		$errors[] = 'Veuillez entrer un Email valide';
	}

	if(!verif::length(3, 30)->validate($post['username'])) {
		$errors[] = 'Veuillez entrer Pseudo valide';
	}

	if(!verif::length(8, 30)->validate($post['password'])) {
		$errors[] = 'Veuillez taper un mot de passe valide compris entre 8 et 30 caractères';
	}

	if(!verif)

}

include_once 'header.php';
?>
		<form method="post">
		<label for="lastname">Nom :</label><br>
		<input type="text" id="lastname" name="lastname">

		<br><br>

		<label for="firstname">Prénom :</label><br>
		<input type="text" id="firstname" name="firstname">

		<br><br>

		<label for="email">Email :</label><br>
		<input type="email" id="email" name="email">

		<br><br>

		<label for="username">Pseudo :</label><br>
		<input type="text" id="username" name="username">

		<br><br>

		<label for="password">Mot de passe :</label><br>
		<input type="password" id="password" name="password">

		<br><br>

		<label for="role">Droit :</label>
		<select id="role" name="role">
			<option disabled selected>Définir un rôle</option>
			<option value="1">Admin</option>
			<option value="2">Editeur</option>
		</select>

		<br><br>

		<label for="avatar">Avatar :</label><br>
		<input type="file" id="avatar" name="avatar">

		<br><br>

		<input type="submit" name="Enregistrer cet utilisateur">
		</form>
	</body>
</html>