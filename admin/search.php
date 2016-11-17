<?php

require_once 'inc/connect.php';
require_once 'inc/functions.php';

// On vérifie que notre formulaire est soumis
$get = []; // Il fait la même chose que $post.. il contient les données nettoyées

$sql = ''; // On l'utilise uniquement pour la recherche

if(!empty($_GET)){
	// On nettoie toujours les données reçues de l'utilisateur
	foreach ($_GET as $key => $value) {
		$get[$key] = trim(strip_tags($value));
	}

	// Ici on a une recherche
	if(isset($get['search']) && !empty($get['search'])){
		$sql = 'WHERE name LIKE :search'; // La suite de la requete SQL pour la recherche

		// Donnera ceci : SELECT * FROM articles WHERE name LIKE :search

	}
}

// On concatène la requête avec la variable $sql. Cette variable est soit une chaine vide (si l'utilisateur n'a pas effectué de recherche), soit la suite de la requete SQL.
$query = $bdd->prepare('SELECT * FROM articles '.$sql);

if(!empty($sql)){
	$query->bindValue(':search', '%'.$get['search'].'%');
}

if($query->execute()){
	$articles = $query->fetchAll(PDO::FETCH_ASSOC);
}
