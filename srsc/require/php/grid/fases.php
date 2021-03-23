<?php
	require_once '../../class/modelo/persistencia/DataBase.class.php';
	$bd = new DataBase;
	if($queryFases = $bd->selectDB('SELECT * FROM fases')){
		$msg = '';
		foreach($queryFases as $Fases){
			$msg .=
			'
				<tr onclick="exibir(\''.$Fases->idFases.'\')">
					<td>'.$Fases->nome.'</td>
					<td>'.$Fases->descricao.'</td>
				</tr>
			';
		}
		print $msg;
	}
	else{
?>
	<span class="ndEncontrado">Nenhuma Fase Cadastrada</span>
<?php
	}
?>