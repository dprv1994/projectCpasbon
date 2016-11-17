<?php
require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}


require_once 'header.php'; ?>


<h1>Modification site du restaurant</h1>

<form class="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nom Restaurant:</label>
        <input class="form-control" type="text" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="adress">Adresse:</label>
        <input class="form-control" type="text" id="adress" name="adress">
    </div>
    <div class="form-group">
        <label for="zipcode">Code Postal:</label>
        <input class="form-control" type="text" id="zipcode" name="zipcode">
    </div>
    <div class="form-group">
        <label for="city">Ville:</label>
        <input class="form-control" type="text" id="city" name="city">
    </div>
    <div class="form-group">
        <label for="phone">Téléphone:</label>
        <input class="form-control" type="num" id="phone" name="phone">
    </div>
    <div class="form-group">
        <label for="picture">Photo:</label>
        <input type="file" id="picture" name="picture">
    </div>

    <input class="btn btn-info btn-lg center-block" type="submit" value="Modifier">
</form>

<?php require_once 'footer.php'; ?>
