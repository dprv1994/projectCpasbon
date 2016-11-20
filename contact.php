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

	if(!preg_match('#[a-zA-Z0-9_\.\-\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{3,30}#', $post['username'])) {
		$errors[] = 'Veuillez entrer un pseudo valide';
	}

	if(!preg_match('#([a-zA-Z0-9_\.\-\%\+])+\@(([a-zA-Z0-9_\.\-])+\.([a-zA-Z0-9]{2,15}))#', $post['email'])) {
		$errors[] = 'Veuillez entrer un Email valide';
	}

	if(!preg_match('#[a-zA-Z0-9_\,\-\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{3,30}#', $post['subject'])) {
		$errors[] = 'Veuillez entrer un Objet valide';
	}

	if(!preg_match('#[a-zA-Z0-9_\,\-\é\à\è\ê\ë\î\ï\û\ü\â\ä\ô\ö]{10,3000}#', $post['content'])) {
		$errors[] = 'Votre message n\'est pas valide';
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
// ajout du titre dans le header
$headerAdd = [
    'title'  => 'Contact'
];
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
                            <label for="username">Votre nom : </label>
                            <input type="text" id="username" name="username" placeholder="ex : Pierre Marechal">
                            <label for="email">Votre email : </label>
                            <input type="email" id="email" name="email" placeholder="ex : votreemail@fai.fr">
                            <label for="subject">Objet du message : </label>
                            <input type="text" id="subject" name="subject" placeholder="ex : Surprise lors de notre dernière venue">
                            <label for="content">Votre message : </label>
                            <textarea id="content" name="content" placeholder="Bonjour , ......"></textarea>
                <button type="submit" name="button">Envoyer le message</button>
            </form>
        </div> <!-- contact END! -->
</div>
<?php
require_once 'footer.php';
?>
