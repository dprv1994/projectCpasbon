<?php
/**
 * Affiche Admin si la base de donnée retourne 1 pour le rôle et Editeur si la base de donéne retourne 2
 * @param int contenu dans la base de donnée
 * @return retourne la valeur contenu par $affichage
*/
function affichRole($param) {
	if($param == 1) {
		$affichage = 'Admin';
	}

	if($param == 2) {
		$affichage ='Editeur';
	}

	return $affichage;
}
