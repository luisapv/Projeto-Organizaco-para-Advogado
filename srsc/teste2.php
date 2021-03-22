<?php
	require_once('require/class/controller/ControllerFuncoes.class.php');
	$cf = new ControllerFuncoes;
	
	print $cf->setCripto('123456');
?>