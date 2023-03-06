<?php include_once 'header.php'; ?>
<div class="row">
	<div class="col-md-4 mx-auto">
		<div class="card card-body rounded-4">
			<div class="container">
				<div class="text-center mt-2">
					<img src="img/favicon.svg" width="72" height="57" alt="RSystfip">
					<h1 class="h6 mt-3">RSYSTFIP</h1>
					<span>Software para agendamiento de visitas Rectoría - <strong>ITFIP</strong></span>
					<p class="text-muted">
						Instituto Tolimense de Formación Técnica Profesional ; NIT: 800.173.719.0. Calle 18 Carrera 1ª Barrio/Arkabal Espinal, Tolima - Colombia
					</p>
				</div>
				<div class="form-floating mb-2">
					<input class="form-control" type="text" placeholder="Usuario" autocomplete="off" autofocus>
					<label class="form-label fw-bold" for="username">Nombre de usuario</label>
				</div>
				<div class="form-floating mb-3">
					<input class="form-control" type="password" placeholder="Contraseña" autocomplete="off">
					<label class="form-label fw-bold" for="password">Contraseña</label>
				</div>
				<div class="alert alert-light">
					Bienvenido(a) de nuevo, inicia sesión
				</div>
				<button class="w-100 btn btn-lg btn-primary mb-2">
					Entrar <i class="fa fa-sign-in-alt"></i>
				</button>
			</div>
		</div>
	</div>
</div>
<script src="js/preloadStaticFiles.js" type="module" async></script>
<?php include_once 'footer.php';