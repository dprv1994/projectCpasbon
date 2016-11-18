<?php

require_once 'inc/connect.php';
require_once 'inc/session.php';
require_once 'vendor/autoload.php';
require_once 'inc/functions.php';

use Respect\Validation\Validator as verif;

$post=[];
$errors=[];
$formValid=false;
$haserror=false;

if(!empty($_POST)) {
	$post = array_map('trim', array_map('strip_tags', $_POST));

	if(!verif::length(3, null)->validate($post['username'])) {
		$errors[] = 'Veuillez entrer un Username valide';
	}

	if(!verif::email()->validate($post['email'])) {
		$errors[] = 'Veuillez entrer un Email valide';
	}

	if(!verif::length(3, null)->validate($post['subject'])) {
		$errors[] = 'Veuillez entrer un Objet valide';
	}

	if(!verif::length(10, null)->validate($post['content'])) {
		$errors[] = 'Veuillez entrer un Objet valide';
	}

	if(count($errors) === 0){
		$query = $bdd->prepare('INSERT INTO message(subject, content, email, username) VALUES (:subject, :content, :email, :username)');
		$query->bindValue(':subject', $post['subject']);
		$query->bindValue(':content', $post['content']);
		$query->bindValue(':email', $post['email']);
		$query->bindValue(':username', $post['username']);

		if($query->execute()) {
			$formValid = true;
		}
		else {
			var_dump($query->errorInfo());
			die;
		}
	}
	else {
		$haserror = true;
	}
}

require_once 'header.php';
?>
<div class="wrapper">

        <div class="contact">
            <h1>Contact</h1>
            <?php if ($formValid == true): ?>
                <p class="success">Votre message a été envoyé !</p>
            <?php elseif ($haserror == true): ?>
                <p class="noSuccess"><?= implode('<br>', $errors);?></p>
            <?php endif; ?>

            <form class="contactForm" method="post">
                            <label for="username">Votre nom</label>
                            <input type="text" id="username" name="username" placeholder="ex : Pierre Marechal">
                            <label for="email">Votre email</label>
                            <input type="email" id="email" name="email" placeholder="ex : votreemail@fai.fr">
                            <label for="subject">Objet du message</label>
                            <input type="text" id="subject" name="subject" placeholder="ex : Surprise lors de notre dernière venue">
                            <label for="content">Contenu de votre message</label>
                            <textarea id="content" name="content" placeholder="Bonjour , ......"></textarea>
                <button type="submit" name="button">Envoyer le message</button>
            </form>
        </div> <!-- contact END! -->
</div>
<?php
require_once 'footer.php';
?>