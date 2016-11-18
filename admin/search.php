<?php
    if(strripos($_SERVER['REQUEST_URI'],'search.php') > 0){
        header('Location:index.php');
        die;
    }
$get = [];

$sql = '';

if(!empty($_GET)){
	foreach ($_GET as $key => $value) {
		$get[$key] = trim(strip_tags($value));
	}


	if(isset($get['search']) && !empty($get['search'])){
		$sql = 'WHERE r.title LIKE :search OR r.preparation LIKE :search OR r.date_creation LIKE :search';
	}
}
