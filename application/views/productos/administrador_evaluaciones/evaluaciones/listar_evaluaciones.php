<?php
if(count($result) > 0){
?>
<p class="p_encontrados">* Se han encontrado <?php echo count($result);?> evaluaciones en el sistema.</p>
<table class="tablaResumen" width="1000" cellspacing="0" cellpadding="0" border="0">
	<thead>
		<tr>
			<th class="a1" nowrap="nowrap">Nombre evaluación</th>
			<th class="a2" nowrap="nowrap">Fecha inicio campo</th>
			<th class="a3" nowrap="nowrap">Fecha fin campo</th>
			<th class="a4" nowrap="nowrap">Fecha evaluación</th>
		</tr>
	</thead>
	<tbody>
	<?php
	for($i = 0; $i < count($result); $i++){
	?>
		<tr onclick="editarEvaluacion(<?php echo $result[$i]['idEvaluacion'];?>);">
			<td class="a1"><?php echo $result[$i]['evaluacion'];?></td>
			<td class="a2"><?php echo $result[$i]['fechaInicioCampo'];?></td>
			<td class="a3"><?php echo $result[$i]['fechaFinCampo'];?></td>
			<td class="a4"><?php echo $result[$i]['fechaEvaluacion'];?></td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
<?php
}
else{
	echo '<p class="p_encontrados">* No se han encontrado evaluaciones en el sistema.</p>';
}
?>