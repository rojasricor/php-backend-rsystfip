<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row" id="app">
  <div class="col-12">
    <h1 class="h3">Estadísticas</h1>
    <div class="row g-3">
      <div class="col-md-2">
       <label class="form-label" for="start">Desde:</label>
        <input @change="onRangeChange" v-model="start" type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label" for="end">Hasta:</label>
        <input @change="onRangeChange" v-model="end" type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label" for="type_chart">Gráfica:</label>
        <select @change="onRangeChange" v-model="type_chart" id="type_chart" class="form-select">
          <option value='line'>Línea</option>
          <option value='bar'>Barra Vertical</option>
          <option value='horizontalBar'>Barra Horizontal</option>
          <option value='radar'>Radar</option>
          <option value='polarArea'>Polar Area</option>
          <option value='pie'>Pie</option>
          <option value='doughnut'>Doughnut</option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-12 mt-3 mb-5">
    <canvas id="chart" width="500" height="200"></canvas>
  </div>
  <div class="col-12 mb-5 mt-5">
    <h5 class="text-center">Personas agendadas en el rango de fecha</h5>
    <div class="list-group w-auto mb-5">
      <li v-for="type_person in mostAgendatedByDate" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
        <img class="flex-shrink-0" src="img/favicon.svg" alt="twbs" width="32" height="27">
        <div class="d-flex gap-2 w-100 justify-content-between">
          <div>
            <h6 class="mb-0">{{type_person.person}}</h6>
            <p class="mb-0 opacity-75">{{type_person.counts}}</p>
          </div>
          <small class="opacity-50 text-nowrap">{{start}} - {{end}}</small>
        </div>
      </li>
    </div>
    <h5 class="text-center">Personas agendadas en todas las fechas</h5>
    <div class="list-group w-auto">
      <li v-for="type_person in mostAgendatedOfAllTime" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
        <img class="flex-shrink-0" src="img/favicon.svg" alt="twbs" width="32" height="27">
        <div class="d-flex gap-2 w-100 justify-content-between">
          <div>
            <h6 class="mb-0">{{type_person.person}}</h6>
            <p class="mb-0 opacity-75">{{type_person.counts}}</p>
          </div>
          <small class="opacity-50 text-nowrap">{{init}} - {{end}}</small>
        </div>
      </li>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" type="text/javascript"></script>
<script src="js/people_statistics.js" type="module" async></script>
<?php include_once 'footer.php';