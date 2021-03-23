<?php
	require_once"../autoload.php";
	$cFuncoes = new ControllerFuncoes;
	
	extract($_POST);
	
	if($status=='UF'){
		print utf8_encode($cFuncoes->getSiglaUF($cod));
	}
?>