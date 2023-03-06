<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row" id="app">
  <div class="col-12">
    <h1 class="h3">Personas Agendadas</h1>
    <div class="form-inline">
      <div class="btn-group btn-group-sm position-fixed bottom-px mb-2 mt-2">
        <input @input="getpeople" type="search" id="search" placeholder="Buscar" class="form-control form-control-sm">
        <button @click="people=peoplefilter" class="btn btn-fc-primary" title="Refrescar datos">
          <i :class="loading"></i>
        </button>
        <a href="<?=$url->generate('schedule')?>?tab=4" class="btn btn-fc-primary" title="Agendamiento por día">
          <i class="fa fa-user-plus"></i>
        </a>
        <a href="<?=$url->generate('scheduling')?>?tab=3" class="btn btn-fc-primary" title="Agendamiento programado">
          <i class="fa fa-calendar-check"></i>
        </a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-sm text-center">
        <caption>Lista de personas agendadas</caption>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nombres</th>
            <th>Identifación</th>
            <th>Categoría</th>
            <th>Facultad</th>
            <th>Asunto</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="person in people">
            <td>{{person.id}}</td>
            <td>{{person.name}}</td>
            <td :title="person.description">{{person.ty_doc}} {{person.num_doc}}</td>
            <td>{{person.person}}</td>
            <td>{{person.fac}}</td>
            <td>{{person.text_asunt}}</td>
            <td>
              <button @click="link(person)" class="btn btn-link link-fc">
                <i class="fa fa-edit"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js" type="text/javascript"></script>
<script src="js/people.js" type="text/javascript" async></script>
<?php include_once 'footer.php';