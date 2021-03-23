<?php
	require_once"../autoload.php";
	$clpf = new ControllerPessoaFisica;
	
	extract($_POST);
	
	if($status=='SU'){
		print $clpf->exibirPessoaFisica($cpf);
	}
	elseif($status=='IN'){
		print $clpf->cadastrar($nome,$identidade,$orgao,$cpf,$profissao,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login);
	}
	elseif($status=='ED'){
		print $clpf->editar($nome,$identidade,$orgao,$cpf,$antigocpf,$profissao,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login);
	}
	elseif($status=='DE'){
		print $clpf->deletar($cpf);
	}
?>