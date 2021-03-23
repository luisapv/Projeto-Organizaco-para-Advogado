<?php
	require_once"../autoload.php";
	$cpj = new ControllerPessoaJuridica;
	
	extract($_POST);
	
	if($status=='SU'){
		print $cpj->exibirPessoaJuridica($cnpj);
	}
	elseif($status=='IN'){
		print $cpj->cadastrar($razaoSocial,$nomeFantasia,$cnpj,$pessoaResponsavel,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login);
	}
	elseif($status=='ED'){
		print $cpj->editar($razaoSocial,$nomeFantasia,$cnpj,$antigocnpj,$pessoaResponsavel,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login);
	}
	elseif($status=='DE'){
		print $cpj->deletar($cnpj);
	}
?>