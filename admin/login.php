<?php

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if ($is_logged) {
    header('Location:index.php');
    die;
}

$post = [];
$error = [];
$success = false;
$hasError = false;

use Respect\Validation\Validator as verif;

if (empty($_SESSION) && !empty($_POST)) {

	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!verif::length(3,null)->validate($post['username'])){
			$error[] = 'L\'username doit faire au moins 3 caractères';
		}

	if (!verif::length(3, null)->validate($post['password'])) {
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
					echo "OK";
					header('Location: index.php');
				}
				else{
					echo "KO";
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
<!-- Debut HTML -->
<?php require_once 'header.php'; ?>

	<?php
		if ($hasError){
		 		echo '<p style="color:red;">'.implode('<br>', $error).'</p>';
			}

		if($success){
			echo '<p style="color:green;">LOGIN OK !</p>';
		}
	?>
<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
 	<h1>Connexion</h1>
    <div class="card">
    	<form method="post">
    		<label for="username">Nom de l'utlisateur:</label>
    		<input type="text" class='form-control' id="username" name="username">
    		<br><br>

    		<label for="password">Mot de passe:</label>
    		<input type="password" class='form-control' id="password" name="password">
    		<br><br>

    	    <button id="" name="" class="btn btn-info btn-block ">Connexion</button>
        </form>
    </div>
</div>


<?php require_once 'footer.php'; ?>
