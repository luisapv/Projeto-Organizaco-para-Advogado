<?php
function __autoload($class){
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/require/class/controller/'.$class.'.class.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/require/class/controller/'.$class.'.class.php');
	elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/require/class/modelo/'.$class.'.class.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/require/class/modelo/'.$class.'.class.php');
	elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/require/class/modelo/persistencia/'.$class.'.class.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/require/class/modelo/persistencia/'.$class.'.class.php');
	elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/require/plugins/fpdf181/'.$class.'.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/require/plugins/fpdf181/'.$class.'.php');
	elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/require/plugins/TCPDF/TCPDF-master/'.$class.'.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/require/plugins/TCPDF/TCPDF-master/'.$class.'.php');
}
?>