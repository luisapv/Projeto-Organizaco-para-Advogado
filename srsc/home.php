<?php
	if(!isset($_SESSION['logado'])==true){
		header('location:login');
	}
?>