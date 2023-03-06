<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
use RSystfip\ResourceController as rc;
?>
<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card card-body">
			<h1 class="h3 text-center">Agendamiento simple</h1>
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
				<div class="col-md-6">
					<div class="form-floating">
						<input class="form-control" type="text" id="doc" placeholder="Digíte el número sin puntos ni comas" title="El número de documento debe ser de 2 a 10 dígitos" maxlength="10" autocomplete="off" disabled>
						<label class="form-label" for="doc">Cédula:</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-floating">
						<select class="form-select" id="doctype" disabled>
							<option disabled value='unset' selected>No seleccionado</option>
							<?php foreach(rc::getAllDocuments() as $doctype) { ?>
							<option value="<?=$doctype->id?>"><?=$doctype->description?></option>
							<?php } ?>
						</select>
						<label class="form-label" for="doctype">Tipo de Documento:</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-floating">
						<input class="form-control" type="text" id="name" placeholder="Complete campo" maxlength="35" autocomplete="off" spellcheck="false" disabled>
						<label class="form-label" for="name">Nombres y Apellidos:</label>
					</div>
				</div>
				<div class="col-12">
					<div class="form-floating">
						<select class="form-select" id="facultie" disabled>
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
						<textarea class="form-control" type="text-area" id="asunt" placeholder="Por favor ingrese el asunto de la visita" minlength="5" maxlength="100" spellcheck="false" autocomplete="off" disabled></textarea>
						<label class="form-label" for="asunt">Asunto:</label>
					</div>
				</div>
				<div class="col-12">
					<div id="alert"></div>
					<button class="w-100 btn btn-warning mb-2" id="save">
						Guardar
					</button>
					<small class="text-secondary">Por favor verifique que los datos estan completos</small>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/people_add.js" type="module" async></script>
<?php include_once 'footer.php';