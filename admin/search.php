<?php



$get = [];

$sql = ''; 

if(!empty($_GET)){
	foreach ($_GET as $key => $value) {
		$get[$key] = trim(strip_tags($value));
	}

	
	if(isset($get['search']) && !empty($get['search'])){
		$sql = 'WHERE title LIKE :search OR preparation LIKE :search OR date_creation LIKE :search'; 

	}
}



