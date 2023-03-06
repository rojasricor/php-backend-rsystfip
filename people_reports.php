<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row" id="app">
  <div class="col-12">
    <h1 class="h3">Reportes por mes</h1>
    <div class="row g-3">
      <div class="col-md-2">
        <label class="form-label" for="start">Desde:</label>
        <input @change="getReports" v-model="start" type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label" for="end">Hasta:</label>
        <input @change="getReports" v-model="end" type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label" for="type_chart">Persona:</label>
        <select @change="filterPerson" v-model="category" class="form-select">
          <option value="unset">No seleccionado</option>
          <option v-for="resource in resources" :value="resource.id">{{resource.person}}</option>
        </select>
      </div>
      <div class="col-12">
        <div class="btn-group btn-group-sm">
          <a href="<?=$url->generate('statistics')?>?tab=9" class="btn btn-warning text-light" title="Generar estadísticas">
            Estadísticas <i class="fa fa-chart-area"></i>
          </a>
          <button @click="pdf" class="btn btn-dark" title="Reporte PDF">
            Descargar <i class="fa fa-download"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="table-responsive mt-5">
      <table class="table table-hover table-borderless table-sm text-center">
        <caption>Datos sobre las personas agendadas este mes.</caption>
        <thead>
          <tr>
            <th>Nombres</th>
            <th>Fecha</th>
            <th>Últ. Modificación</th>
            <th>Agendamiento programado</th>
            <th>Agendamiento de una sóla vez</th>
            <th>Tipo Persona</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="person in reports">
            <td>{{person.name}}</td>
            <td>{{person.date}}</td>
            <td>{{person.time}}</td>
            <td>{{person.presence_count}}</td>
            <td>{{person.absence_count}}</td>
            <td>{{person.person}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js" type="text/javascript"></script>
<script src="js/people_reports.js" type="module" async></script>
<?php include_once 'footer.php';