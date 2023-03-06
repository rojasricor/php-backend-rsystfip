<?php

if (!isset($_GET['id'])) {
	http_response_code(400);
	exit('bad request');
}

include_once 'session_check.php';
use RSystfip\{ResourceController as rc, PeopleController as pc};
$data = pc::getOneById(base64_decode($_GET['id']));

if (!$data) {
	http_response_code(404);
	exit('not found');
}

include_once 'header.php';
include_once 'nav.php';
?>
<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card card-body">
			<h1 class="h3 text-center">Actualizar Datos</h1>
			<div class="row g-2 mt-2">
				<div class="col-md-6">
					<div class="form-floating">
						<select class="form-select" id="person">
							<option disabled value='unset' selected>No seleccionado</option>
							<?php foreach(rc::getAllTypePersons() as $person) { ?>
							<option value="<?=$person->id?>"><?=$person->person?></option>
							<?php } ?>
						</select>
						<label class="form-label" for="person">Persona a registrar:</label>
					</div>
				</div>
				<input type="hidden" id="id" value="<?=base64_encode($data->id)?>">
				<div class="col-md-6">
					<div class="form-floating">
						<input class="form-control" type="text" id="name" placeholder="Complete campo" value="<?=$data->name?>" maxlength="35" autocomplete="off" spellcheck="false">
						<label class="form-label" for="name">Nombres y Apellidos:</label>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-floating">
						<select class="form-select" id="doctype">
							<option disabled value='unset' selected>No seleccionado</option>
							<?php foreach(rc::getAllDocuments() as $doctype) { ?>
							<option value="<?=$doctype->id?>"><?=$doctype->description?></option>
							<?php } ?>
						</select>
						<label class="form-label" for="doctype">Tipo de Documento:</label>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-floating">
						<input class="form-control" type="text" id="doc" placeholder="Digíte el número sin puntos ni comas" title="El número de documento debe ser de 2 a 10 dígitos" maxlength="10" value="<?=$data->num_doc?>" autocomplete="off">
						<label class="form-label" for="doc">Cédula:</label>
					</div>
				</div>
				<div class="col-12">
					<div class="form-floating">
						<select class="form-select" id="facultie">
							<option disabled value='unset' selected>No seleccionado</option>
							<?php foreach(rc::getAllFaculties() as $facultie) { ?>
							<option value="<?=$facultie->id?>"><?=$facultie->name?></option>
							<?php } ?>
						</select>
						<label class="form-label" for="facultie">Facultad:</label>
					</div>
				</div>
				<div class="col-12">
					<div class="form-floating mb-2">
						<textarea class="form-control" type="text-area" id="asunt" placeholder="Por favor ingrese el asunto de la visita" minlength="5" maxlength="100" spellcheck="false" autocomplete="off"><?=$data->text_asunt?></textarea>
						<label class="form-label" for="asunt">Asunto:</label>
					</div>
				</div>
				<div class="col-12">
					<div id="alert"></div>
					<button class="w-100 btn btn-warning mb-2" id="save" data-bs-toggle="modal" data-bs-target="#modal-confirm">
						Guardar Cambios
					</button>
					<small class="text-secondary">Por favor verifique que los datos estan completos</small>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="modal-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Guardar cambios</h1>
				<button class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				Confirmas que se guarden los datos actuales?
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				<button class="btn btn-primary" id="confirm" data-bs-dismiss="modal">Guardar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" async>
	document.getElementById('person').querySelector(`option[value="${<?=json_encode($data->person_type)?>}"]`).selected=true;
	document.getElementById('doctype').querySelector(`option[value="${<?=json_encode($data->id_doc)?>}"]`).selected=true;
	document.getElementById('facultie').querySelector(`option[value="${<?=json_encode($data->facultad)?>}"]`).selected=true;
</script>
<script src="js/people_edit.js" type="module" async></script>
<?php include_once 'footer.php';