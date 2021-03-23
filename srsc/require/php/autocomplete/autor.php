<?php
	require_once"../autoload.php";
	$bd = new DataBase;
	if($query = $bd->selectDB("SELECT p.cod_pessoa, p.nome FROM pessoa AS p  ORDER BY nome")){
		$json='[';
		foreach($query as $value){
			 $json .= '{id:'.$value->cod_pessoa.', nome: "'.$value->nome.'"},';
		}
		$json=substr($json,0,-1);
		$json .= ']';
	}
	else{
		$json = '';
	}
	print $json;
?>