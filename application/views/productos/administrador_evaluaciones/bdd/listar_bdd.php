<?php
if(count($result) > 0){
?>
<p class="p_encontrados">* Se han encontrado <?php echo count($result);?> elementos en la BDD seleccionada.</p>
<table class="tablaResumen" width="1100" cellspacing="0" cellpadding="0" border="0">
	<thead>
		<tr>
			<th class="a1">Código</th>
			<th class="a2">Nombre persona</th>
			<th class="a3">Email</th>
			<th class="a4">Fecha entrega</th>
			<th class="a5">Fono</th>
			<th class="a6">Celular</th>
		</tr>
	</thead>
	<tbody>
	<?php
	for($i = 0; $i < count($result); $i++){
		$result[$i]['fonoCasa'] = ($result[$i]['fonoCasa'] != '') ? $result[$i]['fonoCasa'] : '-';
		$result[$i]['celular'] = ($result[$i]['celular'] != '') ? $result[$i]['celular'] : '-';
		$result[$i]['fecha'] = substr($result[$i]['fecha'], 8, 2) . '-' . substr($result[$i]['fecha'], 5, 2) . '-' . substr($result[$i]['fecha'], 0, 4);
	?>
		<tr id="tr_<?php echo $result[$i]['idBDD'];?>">
			<td class="a1"><?php echo $result[$i]['codigo'];?></td>
			<td class="a2" nowrap="nowrap"><?php echo strtoupper($result[$i]['propietario']);?></td>
			<td class="a3"><?php echo strtolower($result[$i]['email']);?></td>
			<td class="a4"><?php echo $result[$i]['fecha'];?></td>
			<td class="a5"><?php echo $result[$i]['fonoCasa'];?></td>
			<td class="a6"><?php echo $result[$i]['celular'];?></td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
<?php
}
else{
	echo '<p class="p_encontrados">* No se han encontrado elementos en la BDD seleccionada.</p>';
}
?>