<?php
	require_once"../autoload.php";
	$autoComplete = new ControllerAutoComplete;
	
	extract($_POST);
	
	if($status=='ACAutor'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteAutor($valor);
		}
		else{
			print '';
		}
	}
	
	if($status=='ACReu'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteReu($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACAAutor'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteAdvogadoAutor($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACAReu'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteAdvogadoReu($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACF'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteFases($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACM'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteMotivos($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACCEP'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteCep($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACLograouro'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteLogradouro($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACBairro'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteBairro($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACMunicipio'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoCompleteMunicipio($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACTRTR'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoTrtRelator($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACTSTR'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoTstRelator($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACProfissao'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoProfissao($valor);
		}
		else{
			print '';
		}
	}
	
	elseif($status=='ACJuiz'){
		$valores = explode(";",$val);
		$valor = trim($valores[count($valores)-1]);
		if(!empty($valor)){
			print $autoComplete->autoJuiz($valor);
		}
		else{
			print '';
		}
	}
?>