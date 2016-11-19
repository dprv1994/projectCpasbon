<?php
require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (isset($is_logged)) {
    header('Location:index.php');
    die;
}
use Respect\Validation\Validator as verif;

$errors = [];


if (isset($_POST['emailPerdu']) && !empty($_POST['emailPerdu'])) {

    $email = trim(strip_tags($_POST['emailPerdu']));

    if(!verif::email()->validate($email)) {
		$errors[] = 'Veuillez entrer une adresse email valide';
	}

}else {
    $errors[] = 'vous n\'avez pas entré de mail';
}

if (empty($errors)) {

    $q = $bdd->prepare('SELECT * FROM users WHERE email = :email');
    $q->bindValue(':email',$email);

    if ($q->execute()) {
        $emailValid = ($q->fetch(PDO::FETCH_ASSOC))? true : false ;
        if($emailValid){
            $token = uniqid($email,true) . date('Y-m-d');
            // stockage en bdd
            $r = $bdd->prepare('UPDATE users SET token = :token WHERE email = :email');
            $r->bindValue(':token',$token);
            $r->bindValue(':email',$email);
            if ($r->execute()) {
                // envoi de l'email :
                $monMessage = 'pour créé un mot de passe click here -> <a href="admin/newPass.php?token='.$token.'&email='.$email.'">Clik click click</a>';


                $mail = new PHPMailer;

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'postmaster@dev.axw.ovh';                 // SMTP username
                $mail->Password = 'WF3Phil0#3';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                $mail->CharSet = 'UTF-8';

                $mail->setFrom('cpasbon@example.com', 'Mailer');
                $mail->addAddress($email);               // Name is optional

                $mail->Subject = 'Creation d\'un nouveau mot de passe';
                $mail->Body = $monMessage ;
                $mail->AltBody = $monMessage;

                if(!$mail->send()) {
                    $errors[] = 'Le message n\'a pas été evoyé.';
                    $errors[] = 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    $success = true;
                }
            }



        }
    }
}

require_once 'header.php';
?>
<form class="col-lg-6 col-lg-offset-3" method="post">
    <h1>Mot de passe oublié :</h1>
    <p>
        un lien va vous être envoyer par email afin de changer votre mot de passe.
    </p>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?= implode('<br>',$errors) ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success">
            Un mail vien de vous être envoyé !!
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="email">Votre Email :</label>
        <input id="email" type="text" name="emailPerdu" class="form-control">
    </div>
    <input class="btn btn-lg btn-info center-block" type="submit" value="Envoyer">
</form>














<?php
require_once 'footer.php';
?>
