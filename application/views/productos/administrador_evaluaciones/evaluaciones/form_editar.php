<?php
$id_proyecto = $_POST['idProyecto'];
$id_inmobiliaria = $_POST['idInmobiliaria'];
$id_tipo_cuestionario = $idTipoC;
$id_evaluacion = intVal($idEvaluacion);
$evaluacion = $evaluacion;
$fecha_inicio = $fechaInicioCampo;
$fecha_fin = $fechaFinCampo;
$fecha_evaluacion = $fechaEvaluacion;

$dtp_replaces = array('[LBL]', '[INPUT]', '[VAL]');
$dtp_datepicker = '<label class="control-label">[LBL] :</label>
		<div class="input-group mb-3" id="dtp_[INPUT]">
			<input type="text" class="form-control" name="[INPUT]" id="[INPUT]" value="[VAL]" aria-describedby="a-ico-[INPUT]" maxlength="10" />
			<div class="input-group-append">
				<span class="input-group-text" id="a-ico-[INPUT]">
					<svg xmlns="https://www.w3.org/2000/svg" width="12" height="13">&ensp;&ensp;<image x="0" y="0" width="12" height="13" xmlns:xlink="https://www.w3.org/1999/xlink" xlink:href="/images/calendario.svg"></image></svg>
				</span>
			</div>
		</div>';
?>
<form id="formEditarEvaluacion">
	<div class="form-group">
		<label class="control-label" for="evaluacion">Nombre :</label>
		<div>
			<input type="text" class="form-control" name="evaluacion" id="evaluacion" maxlength="150" value="<?php echo $evaluacion;?>" />
		</div>
	</div>
	<div class="form-group">
		<?php echo str_replace($dtp_replaces, array('Fecha inicio', 'fecha_inicio', $fecha_inicio), $dtp_datepicker);?>
	</div>
	<div class="form-group">
		<?php echo str_replace($dtp_replaces, array('Fecha fin', 'fecha_fin', $fecha_fin), $dtp_datepicker);?>
	</div>
	<div class="form-group">
		<?php echo str_replace($dtp_replaces, array('Fecha evaluación', 'fecha_evaluacion', $fecha_evaluacion), $dtp_datepicker);?>
	</div>
	<div class="form-group">
		<label class="control-label" for="evaluacion">Proyecto :</label>
		<div>
			<select class="custom-select custom-select-sm mb-3 form-control" name="id_proyecto" id="id_proyecto">
				<option value="0">-Seleccionar-</option>
				<option value="<?php echo $id_proyecto;?>">Proyecto <?php echo $id_proyecto;?></option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary" onclick="editarEvaluacion_enviar();">Editar Evaluación</button>
		<input type="hidden" name="hf_idEvaluacion" id="hf_idEvaluacion" value="<?php echo $id_evaluacion;?>">
		<input type="hidden" name="hf_idTipoCuestionario" id="hf_idTipoCuestionario" value="<?php echo $id_tipo_cuestionario;?>">
		<input type="hidden" name="hf_idInmobiliaria" id="hf_idInmobiliaria" value="<?php echo $id_inmobiliaria;?>">
	</div>
</form>


<style type="text/css">
	.datepicker-dropdown {
		box-shadow: 0 6px 12px rgba(0, 0, 0, 0.250);
		background-color: #f0f5ff;
		padding: 12px;
	}
	.datepicker-dropdown:after {
	    border-bottom-color: #f0f5ff;
	}
</style>


<script type="text/javascript">
$(document).ready(function(){
	
	// Inicializar datepickers...
	/* (https://github.com/uxsolutions/bootstrap-datepicker) */
	var dtp_options = {
	    format : 'dd-mm-yyyy',
	    weekStart : 1,
	    language : 'es',
	    autoclose : true,
	    showOnFocus : false,
	    todayHighlight : true,
	    container : '#tgaSleModal2'
	}
	$('#fecha_inicio').datepicker(dtp_options);
	$('#fecha_fin').datepicker(dtp_options);
	$('#fecha_evaluacion').datepicker(dtp_options);
	
	// Enviar formulario editar...
	$('#formEditarEvaluacion').submit(function(){
		$(this).ajaxSubmit({
	        target : '',
	        url : 'Evaluaciones/editar_evaluacion_guardar',
	        type : 'post',
	        dataType : 'json',
	        beforeSubmit : function(){},
	        success : function(data){
	        	var json = JSON.stringify(data);
				json = eval('(' + json + ')');
				$('#tgaSleModal2').modal('hide');
	        	loaderTgaSolutions(0);
	        	listarEvaluaciones();
	        	if(json.status == 'SUCCESS'){
	        		mensajesTgaSolutions(0, json.titulo, json.mensaje);
	        	}
	        	if(json.status == 'ERROR'){
	        		mensajesTgaSolutions(3, json.titulo, json.mensaje);
	        	}
	    	}
	    });
		return false;
	});
});

// Datepickers...
$('#dtp_fecha_inicio').click(function(){
	$('#fecha_inicio').datepicker('show');
});

$('#dtp_fecha_fin').click(function(){
	$('#fecha_fin').datepicker('show');
});

$('#dtp_fecha_evaluacion').click(function(){
	$('#fecha_evaluacion').datepicker('show');
});

</script>