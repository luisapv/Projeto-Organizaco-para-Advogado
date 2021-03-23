<?php
	require_once"../autoload.php";
	
	extract($_POST);
	
	$lgn = new ControllerLogin;
	print $lgn->setLogin($login,$senha);
?>