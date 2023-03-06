<?php
include_once 'header.php';
include_once 'nav.php';
?>
<div class="row">
  <div class="col-md-4 offset-md-4">
    <div class="card card-body">
      <h1 class="h3 text-center">Cambiar contraseña para <?=$user->email?></h1>
      <form action="<?=$url->generate('update password')?>" method="POST">
        <input type="hidden" name="id" value="<?=base64_encode($user->id)?>">
        <div class="form-floating mb-3 mt-3">
          <input class="form-control" name="current_password" type="password" placeholder="Current password" autocomplete="off" required>
          <label class="form-label" for="current_password">Contraseña anterior:</label>
        </div>
        <div class="form-floating mb-3">
          <input class="form-control" name="new_password" type="password" placeholder="New password" autocomplete="off" required>
          <label class="form-label" for="new_password">Contraseña nueva:</label>
        </div>
        <div class="form-floating mb-3">
          <input class="form-control" name="new_password_confirm" type="password" placeholder="Confirm new password" autocomplete="off" required>
          <label class="form-label" for="new_password_confirm">Confirmar contraseña nueva:</label>
        </div>
        <?php if (isset($_GET['nueva_password_no_coincide'])) { ?>
        <div class="alert alert-warning">
          La nueva contraseña no coincide con la confirmación
        </div>
        <?php } ?>
        <?php if (isset($_GET['antigua_password_incorrecta'])) { ?>
        <div class="alert alert-warning">
          La contraseña antigua es incorrecta
        </div>
        <?php } ?>
        <?php if (isset($_GET['password_cambiada'])) { ?>
        <div class="alert alert-success">
          Contraseña cambiada exitosamente
        </div>
        <?php } ?>
        <button class="w-100 btn btn-warning mb-3">Cambiar</button>
      </form>
    </div>
  </div>
</div>
<?php include_once 'footer.php';