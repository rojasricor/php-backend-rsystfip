<?php

namespace App\Controllers;

use App\Models\ResourcesModel;

class ResourcesController
{
	public static function getResource()
	{
		if (!isset($_GET['resource'])) {
			http_response_code(400);
			exit('bad request');
		}
		
		$resource = $_GET['resource'];
		
		if ($resource === 'categories') {
			echo json_encode(ResourcesModel::getCategories());
		} elseif ($resource === 'documents') {
			echo json_encode(ResourcesModel::getDocuments());
		} elseif ($resource === 'faculties') {
			echo json_encode(ResourcesModel::getFaculties());
		}		
	}
}
