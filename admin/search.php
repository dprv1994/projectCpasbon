<?php



$get = [];

$sql = '';

if(!empty($_GET)){
	foreach ($_GET as $key => $value) {
		$get[$key] = trim(strip_tags($value));
	}


	if(isset($get['search']) && !empty($get['search'])){
		$sql = 'WHERE recipe.title LIKE :search OR recipe.preparation LIKE :search OR recipe.date_creation LIKE :search'; 

	}
}
