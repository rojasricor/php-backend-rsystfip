<?php
include_once 'header.php';
include_once 'session_check.php';
include_once 'nav.php';
?>
<div class="row">
	<div class="col-12 mb-2">
		<h1 class="h3">Preguntas más frecuentes</h1>
	</div>
	<div class="col-6">
		<div class="accordion accordion-flush" id="col-1">
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-1">
						#1 Cómo puedo ver una lista de todas las personas que han visitado la rectoría hasta el día de hoy?
					</button>
				</h2>
				<div id="collapse-1" class="accordion-collapse collapse" data-bs-parent="#col-1">
					<div class="accordion-body">Para ver todas las personas que se encuentran agendadas y registradas en el aplicativo por una visita a la rectoría, debes ir a la seccion de <i class="fa fa-users"></i> <code>Personas</code> que se encuentra en la barra superior de todas las secciones del aplicativo y acceder a esa opción, para ver toda la información pertinente de cada persona.</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingTwo">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-2">
						#2 Cómo hacer un agendamiento programado para una fecha o día y hora en específico?
					</button>
				</h2>
				<div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#col-1">
					<div class="accordion-body">
						<p>Para reservar una cita con la rectoría del itfip (Agendar una persona) debe dirigirse a la seccion de <i class="fa fa-calendar-check"></i> <code>Agendar</code>, arriba en la barra superior de opciones del aplicativo. Una vez estando en la vista de calendario, seleccionar el dia dando click en el recuadro y dentro en el número del día ó en la barra lateral del calendario de agendamientos da click en semana (week) o día (day) para agendar en el dia que hayas seleccionado y por último arrastrar y soltar hasta la hora que requiera el agendamiento.</p>
						<p>Completar el formulario de agendamiento con todos los datos que pida, por último enviar el formulario para completar el proceso.</p>
						<p><strong>Nota:</strong> El día o semana seleccionada en el calendario de agendamientos se puede cambiar fácil y sencillamente usando las flechas que aparecen la parte superior izquierda del calendario.</p>
						<p>El boton hoy (today) sirve para posicionarse fácilmente en el dia actual y/o fecha actual del calendario de agendamientos.</p>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingThree">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-3">
						#3 Cómo hacer un agendamiento rápido del día a día en el aplicativo web RSystfip?
					</button>
				</h2>
				<div id="collapse-3" class="accordion-collapse collapse" data-bs-parent="#col-1">
					<div class="accordion-body">Hacer un agendamiento del día a día, significa agendar a la persona en el mismo instante que ha llegado a la Rectoría y el Rector tiene la disponibilidad de atenderlo en ese instante, entonces en este instante se hace dicho agendamiento, para eso se dirige a la opción de <code>Agendar</code> <i class="fa fa-plus"></i>, y luego completar el formulario de agendamiento, el cual es el mismo excluyendo la diferencia de seleccionar la fecha y hora, ya que es en el mismo instante y ésta es guardada automáticamente al enviar el formulario.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6">
		<div class="accordion accordion-flush" id="col-2">
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-4">
						#4 Cómo ver estadísticas e informes gráficos de las personas que visitaron la rectoría en determinada fecha ó mes a mes?
					</button>
				</h2>
				<div id="collapse-4" class="accordion-collapse collapse" data-bs-parent="#col-2">
					<div class="accordion-body">
						<p>Para ver un reporte gráfico e información visualmente mejor y más interactiva, se debe dirigir a la sección de <i class="fa fa-chart-line"></i> <code>Reportes</code>, y dar click en el menu desplegable, luego seleccionar la opcion <i class="fa fa-chart-pie"></i> <code>Gráficas reporte agendamientos</code> y tan sólo debe seleccionar el rango de fecha entre cual desea ver la información.</p>
						<p>Puede escoger libremente e interactivamente el tipo de gráfico para leer y/o consumir la información</p>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingTwo">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-5">
						#5 Cómo generar reportes y ver un listado detallado con la información de fecha y hora de agendamiento?
					</button>
				</h2>
				<div id="collapse-5" class="accordion-collapse collapse" data-bs-parent="#col-2">
					<div class="accordion-body">Para generar reportes y poderlos visualizar facilmente, se debe dirigir a la sección de <i class="fa fa-chart-line"></i> <code>Reportes</code>, y dar click en el menu desplegable, luego seleccionar la opción <i class="fa fa-chart-bar"></i> <code>Generar reporte de agendamientos</code> y luego seleccionar la fecha entre la cual desea el reporte, tambien puede especificar el tipo de persona que visitaron la rectoría y darle click en <i class="fa fa-filter"></i> <code>Filtrar</code>, para obtener el reporte.</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingThree">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-6">
						#6 Cómo generar un reporte PDF con la información de las personas que visitaron la rectoría en determinado lapso de tiempo o hasta el día de hoy?
					</button>
				</h2>
				<div id="collapse-6" class="accordion-collapse collapse" data-bs-parent="#col-2">
					<div class="accordion-body">
						<p>Para generar un reporte PDF y guardarlo localmente en el dispositivo, se debe dirigir a la sección de <i class="fa fa-chart-line"></i> <code>Reportes</code>, y dar click en el menu desplegable, luego seleccionar la opcion <i class="fa fa-chart-bar"></i> <code>Generar reporte de agendamientos</code>, y luego completar las opciones que requiera para filtrar la información, despues se debe dar click en <i class="fa fa-download"></i> <code>Descargar</code> ó en <i class="fa fa-file-pdf"></i> <code>Visualizar</code> para ver el reporte antes de descargarlo.</p>
						<p><strong>Nota: </strong>La opción <i class="fa fa-file-pdf"></i> <code>Visualizar</code> sólo funciona en computadores o portátiles de escritorio, en teléfonos móviles que ejecuten un navegador diferente al de una versión de escritorio, no se puede.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'footer.php';