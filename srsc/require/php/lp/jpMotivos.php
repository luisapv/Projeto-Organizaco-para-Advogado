<?php
	require_once"../autoload.php";
	$clpf = new ControllerMotivos;
	
	extract($_POST);
	
	if($status=='SU'){
		print $clpf->exibirMotivos($cod);
	}
	elseif($status=='IN'){
		print $clpf->cadastrar($nome,$descricao,$login);
	}
	elseif($status=='ED'){
		print $clpf->editar($codoculto,$nome,$nomeAnterior,$descricao,$login);
	}
	elseif($status=='DE'){
		print $clpf->deletar($cod);
	}
?>