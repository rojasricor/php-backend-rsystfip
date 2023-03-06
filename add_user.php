<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
use RSystfip\ResourceController as rc;
?>
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card card-body">
      <h1 class="h3 text-center">Nuevo usuario</h1>
      <form class="row g-3 mt-2" action="<?=$url->generate('save user')?>" method="POST">
        <div class="col-md-4">
          <div class="form-floating">
            <select class="form-select" name="cargo" required>
              <option disabled value='unset' selected>No seleccionado</option>
              <option value="2">Rector</option>
              <option value="3">Secretaria</option>
            </select>
            <label class="form-label" for="cargo">Rol:</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input class="form-control" type="text" name="name" placeholder="Name" required>
            <label class="form-label" for="name">Nombres:</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input class="form-control" type="text" name="lastname" placeholder="Lastname" required>
            <label class="form-label" for="lastname">Apellidos:</label>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-floating">
            <select class="form-select mr-sm-2" name="doctype" required>
              <option disabled value='unset' selected>No seleccionado</option>
              <?php foreach(rc::getAllDocuments() as $document) { ?>
              <option value="<?=$document->id?>"><?=$document->description?></option>
              <?php } ?>
            </select>
            <label class="form-label" for="doctype">Tipo de Documento:</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input class="form-control" type="number" name="document" placeholder="Document" required>
            <label class="form-label" for="document">Documento:</label>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-floating">
            <input class="form-control" type="email" name="email" placeholder="Email" required>
            <label class="form-label" for="email">Correo institucional:</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input class="form-control" type="number" name="tel" placeholder="Phone" required>
            <label class="form-label" for="tel">Teléfono:</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off" required>
            <label class="form-label" for="password">Contraseña:</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm password" autocomplete="off" required>
            <label class="form-label" for="confirm_password">Confirmar contraseña:</label>
          </div>
        </div>
        <div class="col-12">
          <?php if (isset($_GET['cargo_no_seleccionado'])) { ?>
          <div class="alert alert-warning">
            Selecciona el cargo del nuevo usuario
          </div>
          <?php } ?>
          <?php if (isset($_GET['tipo_documento_no_seleccionado'])) { ?>
          <div class="alert alert-warning">
            Selecciona el tipo de documento
          </div>
          <?php } ?>
          <?php if (isset($_GET['cargo_existente'])) { ?>
          <div class="alert alert-warning">
            El cargo ya seleccionado ha sido asignado a otro usuario
          </div>
          <?php } ?>
          <?php if (isset($_GET['nueva_password_no_coincide'])) { ?>
          <div class="alert alert-warning">
            La nueva contraseña no coincide con la antigua contraseña
          </div>
          <?php } ?>
          <?php if (isset($_GET['correo_existente'])) { ?>
          <div class="alert alert-warning">
            El correo ya está en uso
          </div>
          <?php } ?>
          <button class="w-100 btn btn-warning mb-3">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  const numberInputs = document.querySelectorAll('[type="number"]')
  numberInputs.forEach(input=>input.addEventListener('keypress',e=>input.value.length>=10&&e.preventDefault()))
</script>
<?php include_once "footer.php";