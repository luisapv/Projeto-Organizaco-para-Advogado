<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
	unset($_COOKIE);
?>
<script type="text/javascript">
	$(document).ready(function(){
		var cookies = $.cookie();
		for(var cookie in cookies) {
		   $.removeCookie(cookie);
		}
	}
</script>
<?php
	$ar = '';
	$arq = explode('/',REDIRECT_URL);
	$arq = $arq[count($arq)-1];
	if(strripos($arq,'.')){
		$arq = explode('.',$arq);
		for($i=0;$i<count($arq);$i++){
			if($arq[$i]!='pdf')
				$ar .= $arq[$i].'.';
		}
		$arq=substr($ar,0,-1);
	}

	if(!empty($arq)){
		if($arq=='Destinatarios' || $arq=='Remetente'){
			$arquivo = 'require/arquivos/'.$arq.'.pdf';
		}
		else{
			$arquivo = 'require'.ARQ_PROCESSOS.$arq.'/1.pdf';
		}
		
		if(file_exists($arquivo)){
			echo '<object type="application/pdf"  data="/'.$arquivo.'"  width="100%" height="100%" ></object>';
		}
		else{
			echo utf8_encode("<h1>ARQUIVO NÃO EXISTE!</h1>");
		}
	}
	else{
		echo "<h1>PARAMETRO EM BRANCO!</h1>";
	}
?>