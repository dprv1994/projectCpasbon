<?php
require_once '../inc/connect.php';

$passOK = false ;// passe a true si controle ok
var_dump($_GET);
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $q = $bdd->prepare('SELECT * FROM users WHERE email = :email AND token = :token');
    $q->bindValue(':email' , $_GET['email']);
    $q->bindValue(':token' , $_GET['token']);
    if ($q->execute()) {
        if ($q->fetch(PDO::FETCH_ASSOC)) {
            var_dump('ici');
            $passOK = true ;
        }
    }
}

die;
if(!$passOK){
    header('Location:index.php');
    die;
}
require_once 'header.php';
 ?>

faire le formulaire et le traitement pour permettre d'enregistrer un nouveau mot de pass !!!






<?php
require_once 'header.php';
 ?>
