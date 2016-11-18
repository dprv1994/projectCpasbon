<?php
require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}
else {
    $edit = $bdd->prepare('SELECT * FROM contact_information');
    if($edit->execute()) {
        $message = $edit->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        var_dump($edit->errorInfo());
        die;
    }
}

use Respect\Validation\Validator as verif;

$post=[];
$errors=[];
$formValid=false;
$haserror=false;
$dirUpload='../img/';

if(!empty($_POST)) {
    $post = array_map('trim', array_map('strip_tags', $_POST));

    if(!verif::length(3, null)->validate($post['name'])) {
        $errors[] = 'Veuillez entrer un nom valide.';
    }

    if(!verif::length(3, null)->validate($post['adress'])) {
        $errors[] = 'Veuillez entrer une adresse valide.';
    }

    if(!verif::intVal()->validate($post['zipcode']) && !verif::length(5, 5)->validate($post['zipcode'])) {
        $errors[] = 'Veuillez entrer un code postal valide.';
    }

    if(!verif::length(3, null)->validate($post['city'])) {
        $errors[] = 'Veuillez entrer une adresse valide.';
    }

    if(!verif::intVal()->validate($post['phone'])) {
        $errors[] = 'Veuillez entrer un numéro de téléphone valide.';
    }

    if(!is_uploaded_file($_FILES['picture']['tmp_name']) || !file_exists($_FILES['picture']['tmp_name'])){
        $errors[] = 'Il faut uploader une image';
    }
    else{
        $finfo = new finfo();
        $mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);
        $mimeTypeAllow = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'];

        if(in_array($mimeType, $mimeTypeAllow)){
            $photoName = uniqid('pic_');
            $photoName.= '.'.pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        }

        if(!is_dir($dirUpload)){
            mkdir($dirUpload, 0755);
        }

        if(!move_uploaded_file($_FILES['picture']['tmp_name'], $dirUpload.$photoName)){
                $errors[] = 'Erreur lors de l\'upload de la photo';
        }
    }

    if(count($errors) === 0) {
        $query = $bdd->prepare('UPDATE contact_information SET name = :name, adress = :adress, zipcode = :zipcode, city = :city, phone = :phone, picture = :picture');
        $query->bindValue(':name', $post['name']);
        $query->bindValue(':adress', $post['adress']);
        $query->bindValue(':zipcode', $post['zipcode']);
        $query->bindValue(':city', $post['city']);
        $query->bindValue(':phone', $post['phone']);
        $query->bindValue(':picture', $dirUpload.$photoName);

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


require_once 'header.php'; ?>


<h1>Modification des informations du  restaurant</h1>

<?php if ($formValid == true): ?>
    <p class="alert-success">Les informations du restaurant ont été mise à jour !</p>
<?php elseif ($haserror == true): ?>
    <p class="alert-danger"><?= implode('<br>', $errors);?></p>
<?php endif; ?>

<form class="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nom du restaurant : </label>
        <input class="form-control" type="text" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="adress">Adresse : </label>
        <input class="form-control" type="text" id="adress" name="adress">
    </div>
    <div class="form-group">
        <label for="zipcode">Code postal : </label>
        <input class="form-control" type="text" id="zipcode" name="zipcode">
    </div>
    <div class="form-group">
        <label for="city">Ville : </label>
        <input class="form-control" type="text" id="city" name="city">
    </div>
    <div class="form-group">
        <label for="phone">Téléphone : </label>
        <input class="form-control" type="num" id="phone" name="phone">
    </div>
    <div class="form-group">
        <label for="picture">Photo : </label>
        <input type="file" id="picture" name="picture">
    </div>

    <input class="btn btn-info btn-lg center-block" type="submit" value="Modifier">
</form>

<?php require_once 'footer.php'; ?>
