<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
use RSystfip\{ResourceController as rc};
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.css" type="text/css">
<div class="d-none alert alert-light border-0 border-bottom fw-bold text-small text-danger text-center" id="alert">No se pudo obtener el agendamiento.</div>
<div class="load-events">
  Cargando <div class="spinner-border spinner-border-sm"></div>
</div>
<div class="table-responsive">
  <div class="container-fluid schg-sm lh-1" id="calendar"></div>
</div>
<p class="text-center mt-2">Agendamiento programado mes a mes.</p>
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="modal-confirm-cancell">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Cancelar cita</h1>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Estás seguro que deseas cancelar ésta cita?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button class="btn btn-danger" id="btn-confirm-modal-cancell" data-bs-dismiss="modal">Sí, cancelar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="modal-scheduling">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Agendamiento Programado</h1>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2 mt-2 p-2">
          <div class="col-md-6">
            <div class="form-floating">
              <select class="form-select" id="person">
                <option disabled value='unset' selected>No seleccionado</option>
                <?php foreach(rc::getAllTypePersons() as $person) { ?>
                <option value="<?=$person->id?>"><?=$person->person?></option>
                <?php } ?>
              </select>
              <label class="form-label" for="person">Tipo de persona</label>
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
              <label class="form-label" for="doctype">Tipo de documento</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input class="form-control" type="text" id="name" placeholder="Nombre completo" maxlength="35" autocomplete="off" spellcheck="false" disabled>
              <label class="form-label" for="name">Nombres y apellidos</label>
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
              <label class="form-label" for="facultie">Si pertenece a facultad</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating">
              <textarea class="form-control" type="text-area" id="asunt" placeholder="Por favor ingrese el asunto de la visita" minlength="5" maxlength="100" spellcheck="false" autocomplete="off" disabled></textarea>
              <label class="form-label" for="asunt">Asunto</label>
            </div>
          </div>
          <div class="col-12">
            <input class="form-control form-control-color mb-3" type="color" id="schedule-color" title="Choose your color" value="#388cdc">
            <div id="alert"></div>
            <small class="text-secondary">Por favor verifique que los datos estan completos</small>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-warning" id="save">Agendar</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.0.3/locales/es-us.global.min.js" type="text/javascript"></script>
<script src="js/calendar.js" type="module" async></script>
<script src="js/people_scheduling.js" type="module" async></script>
<?php include_once 'footer.php';