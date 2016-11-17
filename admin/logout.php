<?php 
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'yes') {
	// Détruit les entrées de username et password de $_SESSION
	unset($_SESSION['username'], $_SESSION['password']);
	// Redirige vers la page voulu
	header('Location: login.php');
	die();
}

 ?>

 <!DOCTYPE html>
 <html lang="fr">
 <head>
 <meta charset="utf-8">
 	<title>Deconnexion</title>
 </head>
 <body>

	<?php if (isset($_SESSION['username']) && isset($_SESSION['password'])) : ?>

	<?php echo $_SESSION['username']; ?>, veux-tu te déconnecter ? Vraiment

	<br><br>

	<a href="deconnexion.php?logout=yes">Oui, je veux me déconnecter</a>

	<?php else: ?>
		Tu es déjà déconnecté, tu n'existes pas !!
	<br><br>
 	<?php endif; ?>
 	
 </body>
 </html>