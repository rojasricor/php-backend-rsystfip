<?php

namespace App\controllers;

class RolesController
{
	static function get($id)
	{
		$rec = 1 === $id;
		$sec = 2 === $id;
		$adm = 3 === $id;
		return [
			'rec' => $rec || $adm,
			'sec' => $sec || $adm,
			'adm' => $adm
		];
	}
}
