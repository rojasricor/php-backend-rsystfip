<?php

if (!isset($_GET['id'])) {
	http_response_code(400);
	exit('bad request');
}

include_once 'session_check.php';
$person = App\controllers\PeopleController::getOneById($_GET['id']);

if (!$person) {
	http_response_code(404);
	exit('not found');
}

echo json_encode($person);
