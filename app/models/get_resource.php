<?php

if (!isset($_GET['resource'])) {
	http_response_code(400);
	exit('bad request');
}

$resource = $_GET['resource'];
include_once 'session_check.php';

if ($resource === 'categories') {
	echo json_encode(App\Controllers\ResourceController::getCategories());
} elseif ($resource === 'documents') {
	echo json_encode(App\Controllers\ResourceController::getDocuments());
} elseif ($resource === 'faculties') {
	echo json_encode(App\Controllers\ResourceController::getFaculties());
}
