<?php
$id_proyecto = $_POST['idProyecto'];
$id_inmobiliaria = $_POST['idInmobiliaria'];
$id_tipo_cuestionario = $_POST['var1'];
?>
<form id="formNuevaEvaluacion">
	<div class="form-group">
		<label class="control-label" for="evaluacion">Nombre :</label>
		<div>
			<input type="text" class="form-control" name="evaluacion" id="evaluacion" maxlength="150" />
		</div>
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
		<button type="button" class="btn btn-primary" onclick="agregarEvaluacion_enviar();">Agregar Evaluación</button>
		<input type="hidden" name="hf_idTipoCuestionario" id="hf_idTipoCuestionario" value="<?php echo $id_tipo_cuestionario;?>">
		<input type="hidden" name="hf_idInmobiliaria" id="hf_idInmobiliaria" value="<?php echo $id_inmobiliaria;?>">
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('#formNuevaEvaluacion').submit(function(){
		$(this).ajaxSubmit({
		    target : '',
	        url : 'Evaluaciones/agregar_evaluacion_guardar',
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
</script>
