<?php

if (!isset($_GET['resource'])) {
	http_response_code(400);
	exit('bad request');
}

$resource = $_GET['resource'];
include_once 'session_check.php';

if ($resource === 'categories') {
	echo json_encode(App\controllers\ResourceController::getAllTypePersons());
} elseif ($resource === 'documents') {
	echo json_encode(App\controllers\ResourceController::getAllDocuments());
} elseif ($resource === 'faculties') {
	echo json_encode(App\controllers\ResourceController::getAllFaculties());
}
