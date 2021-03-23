<?php
	require_once"../autoload.php";
	$clpf = new ControllerAdvogado;
	
	extract($_POST);
	
	if($status=='SU'){
		print $clpf->exibirAdvogado($oab);
	}
	elseif($status=='IN'){
		print $clpf->cadastrar($nome,$oab,$estado,$dataExpedicao,$login);
	}
	elseif($status=='ED'){
		print $clpf->editar($nome,$oab,$antigooab,$estado,$antigoestado,$dataExpedicao,$login);
	}
	elseif($status=='DE'){
		print $clpf->deletar($oab, $estado);
	}
?>