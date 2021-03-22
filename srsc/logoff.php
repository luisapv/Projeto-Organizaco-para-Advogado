<?php
	if(isset($_SESSION['logado'])){
		unset($_SESSION['logado']);
	}
	header('location:login');
?>