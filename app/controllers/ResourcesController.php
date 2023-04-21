<?php

namespace App\Controllers;

use App\Models\ResourcesModel;

class ResourcesController
{
	public function getResource()
	{
		if (!isset($_GET['resource'])) {
			http_response_code(400);
			exit('bad request');
		}
		
		$resource = $_GET['resource'];
		$resourcesModel = new ResourcesModel();
		
		if ($resource === 'categories') {
			echo json_encode($resourcesModel->getCategories());
		} elseif ($resource === 'documents') {
			echo json_encode($resourcesModel->getDocuments());
		} elseif ($resource === 'faculties') {
			echo json_encode($resourcesModel->getFaculties());
		}		
	}
}
