<h2>Evaluaciones</h2>

<article class="tga-section-filter">
	<ul>
		<li>
			<div class="tga-cuadro tga-w150 tga-noclear tga-left tga-mR20 tga-mB10">
				<p class="tga-pp">Tipo de custionario</p>
				<select class="custom-select custom-select-sm mb-3">
					<option value="0">Seleccione</option>
					<?php
					$query = $dbData->query("SELECT idTipoC, tipo
												 FROM data_tipo_cuestionario
												WHERE estado     = 1
											 ORDER BY tipo ASC;");
					if ($query->num_rows() > 0){
					    $row = $query->row();
					    for ($i=1;$i<=$query->num_rows();$i++) {
					    	?>
					    	<option value="<?php print($row->idTipoC.'-'.md5($row->idTipoC.'alfonsito'));?>"><?php print($row->tipo);?></option>
					    	<?php
					    	$row = $query->next_row();
					    }
					}else{
					    exit;
					}
					?>
				</select>
			</div>
			<div class="tga-cuadro tga-w150 tga-noclear tga-left tga-mR20 tga-mB10">
				<p class="tga-pp">País</p>
				<select class="custom-select custom-select-sm mb-3">
					<option value="0">Seleccione</option>
					<?php
					$query = $this->db->query("SELECT idPais, pais
											   FROM tga_pais
											  WHERE estado = 1
										   ORDER BY pais ASC;");
					if ($query->num_rows() > 0){
					    $row = $query->row();
					    for ($i=1;$i<=$query->num_rows();$i++) {
					    	?>
					    	<option value="<?php print($row->idPais.'-'.md5($row->idPais.'alfonsito'));?>"><?php print($row->pais);?></option>
					    	<?php
					    	$row = $query->next_row();
					    }
					}else{
					    exit;
					}
					?>
				</select>
			</div>
			<div class="tga-cuadro tga-w250 tga-noclear tga-left tga-mR20 tga-mB10">
				<p class="tga-pp">Inmobiliaria</p>
				<select class="custom-select custom-select-sm mb-3">
					<option value="0">Seleccione</option>
				</select>
			</div>
			<div class="tga-cuadro tga-w250 tga-noclear tga-left tga-mR20 tga-mB10">
				<p class="tga-pp">Proyecto</p>
				<select class="custom-select custom-select-sm mb-3">
					<option value="0">Seleccione</option>
				</select>
			</div>
		</li>
		<li class="btn-finale">
			<button type="button" class="btn btn-dark btn-sm" onclick="agregarEvaluacion();">Nueva evaluación</button>
		</li>
	</ul>
</article>


<article id="contenidoSubIn" class="tga-contenido-In evaluacionesTabla">
</article>


<style type="text/css">
	.p_encontrados { margin-bottom: 15px !important;}
	.evaluacionesTabla .tablaResumen th.a2, 
	.evaluacionesTabla .tablaResumen th.a3, 
	.evaluacionesTabla .tablaResumen th.a4 { width: 150px !important;}
</style>



<script type="text/javascript">
	
	/* Variables uso temporal desarrollo... */
	var id_user = 2;
	var id_inmobiliaria = 1;
	var id_proyecto = 25;
	var id_tipo_cuestionario = 3;

	
	$(document).ready(function(){
		listarEvaluaciones();
	});

	
	function agregarEvaluacion_enviar(){
		var evaluacion = $('#evaluacion').val();
		var proyecto = $('#id_proyecto').val();
		var titulo_msg = 'Nueva evaluación';
		if($.trim(evaluacion) == ''){
			mensajesTgaSolutions(3, titulo_msg, 'Por favor ingrese el nombre de la evaluación.');
			return false;
		}
		if(proyecto == 0){
			mensajesTgaSolutions(3, titulo_msg, 'Por favor seleccione el nombre del proyecto.');
			return false;
		}
		loaderTgaSolutions(1);
	    $('#formNuevaEvaluacion').submit();
	}


	function editarEvaluacion_enviar(){
		var evaluacion = $('#evaluacion').val();
		var fecha_inicio = $('#fecha_inicio').val();
		var fecha_fin = $('#fecha_fin').val();
		var fecha_evaluacion = $('#fecha_evaluacion').val();
		var proyecto = $('#id_proyecto').val();
		var titulo_msg = 'Editar evaluación';
		if($.trim(evaluacion) == ''){
			mensajesTgaSolutions(3, titulo_msg, 'Por favor ingrese el nombre de la evaluación.');
			return false;
		}
		if($.trim(fecha_inicio) == '' && $.trim(fecha_fin) != ''){
			mensajesTgaSolutions(3, titulo_msg, 'Por favor seleccione la fecha de inicio.');
			return false;
		}
		if($.trim(fecha_inicio) != '' && $.trim(fecha_fin) != ''){
			var validar_rf = validarRangoFechas(fecha_inicio, fecha_fin);
			if(validar_rf == false){
				mensajesTgaSolutions(3, titulo_msg, 'La fecha de inicio no debe ser mayor o igual a la fecha de finalización.');
				return false;
			}
		}
		if(proyecto == 0){
			mensajesTgaSolutions(3, titulo_msg, 'Por favor seleccione el nombre del proyecto.');
			return false;
		}
		loaderTgaSolutions(1);
	    $('#formEditarEvaluacion').submit();
	}

	
	function listarEvaluaciones(){
		loaderTgaSolutions(1);
		$.ajax({
			url: 'Evaluaciones/listar_evaluaciones',
			type: 'GET',
			data: {},
			success: function(data){
		    	$('#contenidoSubIn').html(data);
		    	loaderTgaSolutions(0);
			}
		}); 
	}

	
	function agregarEvaluacion(){
		$('body').loadTgaSol({
			modal : 1,
			modalTitulo : 'Nueva evaluación',
			url: 'productos/evaluaciones/agregar_evaluacion',
			idInmobiliaria : id_inmobiliaria,
			idProyecto : id_proyecto, 
			valor1 : id_tipo_cuestionario
		});
	}

	
	function editarEvaluacion(id_evaluacion){
		$('body').loadTgaSol({
			modal : 1,
			modalTitulo : 'Nueva evaluación',
			url: 'productos/evaluaciones/editar_evaluacion/' + id_evaluacion,
			idInmobiliaria : id_inmobiliaria,
			idProyecto : id_proyecto
		});
	}


	function validarRangoFechas(fecha_inicial, fecha_final){
		var values_start = fecha_inicial.split('-');
		var values_end = fecha_final.split('-');
		var date_start = new Date(values_start[2], (values_start[1] - 1), values_start[0]);
		var date_end = new Date(values_end[2], (values_end[1] - 1), values_end[0]);
		if(date_start >= date_end){
			return false;
		}
		else{
			return true;
		}
	}

</script>