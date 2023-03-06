<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row">
  <div class="col-12">
    <h1 class="h3"></h1>
    <div class="form-inline">
      <div class="btn-group btn-group-sm">
        <a href="<?=$url->generate('schedule')?>?tab=4" class="btn btn-fc-primary" title="Agendamiento por día">
          <i class="fa fa-user-plus"></i>
        </a>
        <a href="<?=$url->generate('scheduling')?>?tab=3" class="btn btn-fc-primary" title="Agendamiento programado">
          <i class="fa fa-calendar-check"></i>
        </a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" async>
  const [h1] = document.getElementsByTagName('h1');
  h1.textContent = ('secretaria' === role ? 'Bienvenida' : 'Bienvenido').concat(` ${role}: ${name}`);
</script>
<?php include_once 'footer.php';