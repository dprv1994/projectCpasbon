<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Admin Cpasbon</title>

        <!-- import bootstrap Local si bug box-->
        <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->

        <!-- import bootstrap cdn-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    </head>
    <body>

        <nav class="navbar navbar-light bg-faded col-lg-8 col-lg-offset-2">
          <ul class="nav navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
            </li>
            <li class="navitem">
                <?= (isset($is_logged))? '<a class="nav-link" href="add_recipe.php">Ajout Recette</a>' : ''; ?>
            </li>
            <li class="navitem">
                <?= (isset($is_logged))? '<a class="nav-link" href="listUser.php">Liste des Users</a>' : ''; ?>
            </li>
            <li class="navitem">
                <?= (isset($is_logged))? '<a class="nav-link" href="updateUser.php">Mon Profil</a>' : ''; ?>
            </li>
            <li class="navitem">
                <?=(isset($is_logged))? '<a class="nav-link" href="logout.php">Deconnexion</a>' : ''; ?>
            </li>
          </ul>
        </nav>

        <div class="col-lg-8 col-lg-offset-2">
