<?php
require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged) && $is_logged == 'editeur') {
    header('Location:login.php');
    die;
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

    if(count($errors) === 0) {
        $query = $bdd->prepare('UPDATE contact_information SET value = :name WHERE contact_information.data = "resto_name";
            UPDATE contact_information SET value = :adress WHERE contact_information.data = "adress";
            UPDATE contact_information SET value = :zipcode WHERE contact_information.data = "zipcode";
            UPDATE contact_information SET value = :city WHERE contact_information.data = "city";
            UPDATE contact_information SET value = :phone WHERE contact_information.data = "phone";');
        $query->bindValue(':name', $post['name']);
        $query->bindValue(':adress', $post['adress']);
        $query->bindValue(':zipcode', $post['zipcode']);
        $query->bindValue(':city', $post['city']);
        $query->bindValue(':phone', $post['phone']);
        if($query->execute()) {
            $formValid = true;
        }
        else {
            var_dump($query->errorInfo());
            die;
        }
        $query->closeCursor();
    }
    else {
        $haserror = true;
    }

}// if !empty post

$edit = $bdd->prepare('SELECT * FROM contact_information');
if($edit->execute()) {
    $infos = $edit->fetchAll(PDO::FETCH_ASSOC);
    $edit->closeCursor();
}
else {
    var_dump($edit->errorInfo());
    die;
}

require_once 'header.php'; ?>


<h1>Modification des informations du restaurant</h1>
<h2>infos du restaurant :</h2>
<?php if ($formValid == true): ?>
    <p class="alert-success">Les informations du restaurant ont été mise à jour !</p>
<?php elseif ($haserror == true): ?>
    <p class="alert-danger"><?= implode('<br>', $errors);?></p>
<?php endif; ?>

<form class="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nom du restaurant : </label>
        <input class="form-control" type="text" id="name" name="name" value="<?= $infos[0]['value'] ; ?>">
    </div>
    <div class="form-group">
        <label for="adress">Adresse : </label>
        <input class="form-control" type="text" id="adress" name="adress" value="<?= $infos[1]['value'] ; ?>">
    </div>
    <div class="form-group">
        <label for="zipcode">Code postal : </label>
        <input class="form-control" type="text" id="zipcode" name="zipcode" value="<?= $infos[2]['value'] ; ?>">
    </div>
    <div class="form-group">
        <label for="city">Ville : </label>
        <input class="form-control" type="text" id="city" name="city" value="<?= $infos[3]['value'] ; ?>">
    </div>
    <div class="form-group">
        <label for="phone">Téléphone : </label>
        <input class="form-control" type="num" id="phone" name="phone" value="<?= $infos[4]['value'] ; ?>">
    </div>

    <input class="btn btn-info btn-lg center-block" type="submit" value="Mettre a jour">
</form>

<!-- SLIDER -->
<h2>affichage des slider :</h2>
<a href="addSlide.php">
    <button type="button" class="btn btn-info btn-xs">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter un Slider
    </button>
</a>
<br><br>
<!-- boucle pour vider les donné récupéré avec un if pour récupérer uniquement les slides -->
<?php $brCount = 1 ?>
<div class="row">
    <?php foreach ($infos as $value):
        if (strpos($value['data'],'slide_') === 0 ) :
            $slide = explode(',',$value['value']);
            ?>

            <div class="col-lg-4">
                <div class="media">
                  <div class="col-lg-5">
                      <img class="img-responsive" src="../<?= $slide[2] ?>" alt="">
                  </div>
                  <div class="col-lg-5">
                    <h4 class="media-heading"><?= $slide[0] ?></h4>
                    <?= $slide[1] ?>
                  </div>
                  <a class="" href="deleteSlide.php?id=<?= $value['id'] ?>"<?= $slide[0] ?>><button class="col-lg-2 btn btn-danger" type="button"><i class="glyphicon glyphicon-minus"></i></button></a>
                </div>
            </div>
            <?php echo ($brCount == 3)? '<hr class="col-lg-12">' : '';
                $brCount++;
                $brCount = ($brCount > 3)? 1 : $brCount;
            ?>

        <?php endif ; ?>
    <?php endforeach; ?>
</div>
<!-- Fin affichage des slider -->
<?php require_once 'footer.php'; ?>
