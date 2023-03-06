<nav class="navbar navbar-expand-xl bg-light fixed-top">
  <div class="container-fluid">
    <span class="navbar-brand px-lg-3">
      <img src="img/favicon.svg" alt="RSystfip" width="40" height="32">
    </span>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#rs-nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="rs-nav">
      <nav class="pt-4 pt-lg-0">
        <div class="nav nav-fill nav-pills flex-column flex-sm-row ml-2">
          <a class="nav-item nav-link <?=$_GET['tab']==1?'active':''?>" href="<?=$url->generate('home')?>?tab=1">
            Inicio <i class="fa fa-home"></i>
          </a>
          <a class="nav-item nav-link <?=$_GET['tab']==2?'active':''?>" href="<?=$url->generate('admin')?>?tab=2" id="admin" title="Pánel de administración de usuarios">
            Usuarios <i class="fa fa-users-cog"></i>
          </a>
          <a class="nav-item nav-link <?=$_GET['tab']==3?'active':''?>" href="<?=$url->generate('scheduling')?>?tab=3" title="Agendar una persona en el calendario">
            Agendar <i class="fa fa-calendar-check"></i>
          </a>
          <a class="nav-item nav-link <?=$_GET['tab']==4?'active':''?>" href="<?=$url->generate('schedule')?>?tab=4" id="schedule" title="Agendar una persona inmediatamente">
            Agendar <i class="fa fa-plus"></i>
          </a>
          <a class="nav-item nav-link <?=$_GET['tab']==5?'active':''?>" href="<?=$url->generate('people')?>?tab=5" title="Listado de todas las personas agendadas">
            Personas <i class="fa fa-users"></i>
          </a>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?=$_GET['tab']==7||$_GET['tab']==8||$_GET['tab']==9?'active':''?>" data-bs-toggle="dropdown" id="reports" title="Menú de estadísticas y asistencias">
              Reportes <i class="fa fa-chart-line"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start dropdown-menu-end p-2 border rounded-3 mx-5 shadow w-220px">
              <!--<a class="dropdown-item rounded-2 mb-1 <?=$_GET['tab']==7?'active':''?>" href="<?=$url->generate('register')?>?tab=7">
                <i class="fa fa-check-double"></i> Registros
              </a>-->
              <a class="dropdown-item rounded-2 mb-1 <?=$_GET['tab']==8?'active':''?>" href="<?=$url->generate('reports')?>?tab=8">
                <i class="fa fa-chart-bar"></i> Reportes
              </a>
              <a class="dropdown-item rounded-2 mb-1 <?=$_GET['tab']==9?'active':''?>" href="<?=$url->generate('statistics')?>?tab=9">
                <i class="fa fa-chart-pie"></i> Estadísticas
              </a>
            </div>
          </li>
          <a class="nav-item nav-link <?=$_GET['tab']==10?'active':''?>" href="<?=$url->generate('help')?>?tab=10" title="Preguntas y respuestas más frecuentes">
            FAQs <i class="fa fa-info-circle"></i>
          </a>
        </div>
      </nav>
    </div>
    <div class="collapse navbar-collapse justify-content-lg-end" id="rs-nav">
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center mt-3 mt-lg-0 mb-2 mb-lg-0 link-dark text-decoration-none dropdown-toggle me-3" data-bs-toggle="dropdown">
          <img class="rounded-circle" id="avatar" width="40" alt="Account">
        </a>
        <ul class="dropdown-menu dropdown-menu-lg-end text-small">
          <li><a class="dropdown-item" href="<?=$url->generate('help')?>?tab=10">Ayuda...</a></li>
          <li><a class="dropdown-item" href="<?=$url->generate('change password')?>" id="chg_psw">Cambiar mi contraseña</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#" id="logout">Cerrar sesión</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<script src="js/nav.js" type="text/javascript"></script>