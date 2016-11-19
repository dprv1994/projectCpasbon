<?php
require_once '../inc/connect.php';
require_once '../vendor/autoload.php';

use Respect\Validation\Validator as verif;

if (isset($_POST['check']) && is_numeric($_POST['check']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $password = trim(strip_tags($_POST['password']));
    $email = trim(strip_tags($_POST['email']));

    // controle du mot de passe
    if(!verif::length(8, 30)->validate($password)) {
		$errors[] = 'Veuillez entrer un mot de passe compris entre 8 et 30 caractères';
	}
    var_dump($_POST);
    if (empty($errors)) {
        // enregistrement du nouveau mdp et vidage du token au cas ou,
        // la vérif est fait sur 2 points pour etre sur que si l'id est modifié
        // elle doit etre en accord avec le mail et c'est vraiment de la chance que d'avoir les 2 en accord
        $u = $bdd->prepare('UPDATE users SET password = :password , token = "" WHERE id = :id AND email = :email');
        $u->bindValue(':password' , password_hash($password,PASSWORD_DEFAULT)) ;
        $u->bindValue(':email' , $email) ;
        $u->bindValue(':id' , $_POST['check']) ;

        if ($u->execute()) {
            $u->closeCursor();
            header('Location:login.php?m=ok');
            die;
        }else{
            $errors[] = 'Veuillez reesayer plus tard'
        }
    }
}


$passOK = false ;// passe a true si controle ok
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $q = $bdd->prepare('SELECT * FROM users WHERE email = :email AND token = :token');
    $q->bindValue(':email' , $_GET['email']);
    $q->bindValue(':token' , $_GET['token']);
    if ($q->execute()) {
        $user = $q->fetch(PDO::FETCH_ASSOC) ;
        if (!empty($user)) {
            $passOK = true ;
        }
    }
}
if(!$passOK){
    header('Location:index.php');
    die;
}
require_once 'header.php';
 ?>

<?php if ($passOK): ?>
    <form class="col-lg-6 col-lg-offset-3" method="post">
        <h1>Generation d'un nouveau mot de passe :</h1>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?= implode('<br>',$errors) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                Votre Mot de Passe est enregistré !!
            </div>
        <?php endif; ?>
        <div class="form-group">
            <input type="hidden" name="check" value="<?= $user['id']; ?>">
            <input type="hidden" name="email" value="<?= $user['email']; ?>">
            <label for="password">Nouveau Mot de passe :</label>
            <input id="password" type="text" name="password" class="form-control">
        </div>
        <input class="btn btn-lg btn-info center-block" type="submit" value="Enregistrer">
    </form>
<?php endif; ?>


<?php
require_once 'header.php';
 ?>
