<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row" id="app">
	<div class="row">
		<h1 class="h3">Control de asistencia citas</h1>
		<label class="form-label" for="date">Fecha:</label>
		<div class="col-sm-2">
			<input @change="refreshPeopleList" v-model="date" type="date" class="form-control mb-2">
		</div>
		<div class="col-sm-2">
			<input @change="refreshPeopleList" type="time" class="form-control mb-2">
		</div>
		<div class="col-sm-2">
			<button @click="save" class="btn btn-primary ml-2 mb-2">
				Guardar <i class="fa fa-check"></i>
			</button>
		</div>
	</div>
	<div class="col-12 mb-5">
		<div class="table-responsive{-sm|-md|-lg|-xl}">
			<div class="form-control bg-light mb-5">
				<table class="table table-hover table-striped table-light table-sm">
					<caption>Agendamiento de horario</caption>
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Agendamiento </th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="person in people">
							<td>{{person.name}}</td>
							<td>
								<select v-model="person.status" class="form-select mr-sm-2">
									<option disabled value="unset">No seleccionado</option>
									<option value="presence">En progreso</option>
									<option value="absence">Cancelado</option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-toasted/1.1.28/vue-toasted.min.js" type="text/javascript"></script>
<script src="js/people_register.js" type="module" async></script>
<?php include_once 'footer.php';