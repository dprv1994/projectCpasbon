<?php
require_once '../inc/session.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

if (isset($_GET['logout']) && $_GET['logout'] == 'yes') {
	// Détruit les entrées de username et password de $_SESSION
	unset($_SESSION['user']);
    session_destroy();
	// Redirige vers la page voulu
	header('Location:login.php');
	die();
}


require_once 'header.php';

 if (isset($_SESSION['user'])){

     echo $_SESSION['user']['username'] . ', veux-tu te déconnecter ? Vraiment';
     echo '<br><br><a href="logout.php?logout=yes">Oui, je veux me déconnecter</a>' ;

 }else {
    echo "Tu es déjà déconnecté, tu n'existes pas !!";
    echo '<br><br>' ;
 }

require_once 'footer.php';
