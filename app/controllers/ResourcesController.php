<?php

namespace App\Controllers;

use App\Models\ResourcesModel;

class ResourcesController
{
	private ResourcesModel $resourcesModel;

	public function __construct()
	{
		$this->resourcesModel = new ResourcesModel;
	}

	public function getResource(): void
	{
		if (!isset($_GET['resource'])) {
			http_response_code(400);
			exit('bad request');
		}
		
		$resource = $_GET['resource'];
		
		if ($resource === 'categories') {
			echo json_encode($this->resourcesModel->getCategories());
		} elseif ($resource === 'documents') {
			echo json_encode($this->resourcesModel->getDocuments());
		} elseif ($resource === 'faculties') {
			echo json_encode($this->resourcesModel->getFaculties());
		}		
	}
}
