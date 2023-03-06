<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card card-body">
      <h1 class="h3 text-center">Administrar usuarios</h1>
      <a href="<?=$url->generate('add user')?>?tab=2" class="btn btn-secondary btn-sm mb-2 mt-2">
        Agregar
      </a>
      <table class="table table-hover table-striped text-center">
        <caption>Usuarios con acceso.</caption>
        <thead>
          <tr>
            <th>Correo institucional</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach(RSystfip\UserController::getUsersDashboard() as $user) { ?>
          <tr>
            <td><?=$user->email?></td>
            <td>
              <a href="<?=$url->generate('change password')?>?role=<?=base64_encode($user->id)?>&tab=2" class="btn btn-warning">
                <i class="fa fa-key"></i>
              </a>
              <a href="<?=$url->generate('delete user')?>?role=<?=base64_encode($user->id)?>&tab=2" class="btn btn-danger confirm-action <?=$user->id===3?'disabled':''?>">
                <i class="fa fa-trash"></i>
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript" async>
  const confirmActionButtons = document.querySelectorAll('.confirm-action');
  confirmActionButtons.forEach(button=>button.addEventListener('click',e=>!confirm('Confirmas que deseas eliminar a este usuario?')&&e.preventDefault()));
</script>
<?php include_once 'footer.php';