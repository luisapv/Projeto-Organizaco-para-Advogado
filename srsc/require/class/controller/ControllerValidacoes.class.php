<?php
class ControllerValidacoes{
	public function setValidaEmail($email){
		$ext=array('.com','.br','.net','.gov','.org','.tv','.inf');
		
		if(strlen(trim($email))<1)
			return false;
		elseif(!preg_match('/^[0-9a-z\_\.\-]+\@[0-9a-z\_\.\-]*[0-9a-z\_\-]+\.[a-z]{2,3}$/i',$email))
			return false;
		elseif(!in_array(strrchr($email,'.'),$ext))
			return false;
		else
			return true;
	}
	
	public function setValidaCPF($cpf){
		// Verifica se um n�mero foi informado
    	if(empty($cpf)) {
        	return false;
    	}
 
    	// Elimina possivel mascara
    	$cpf = preg_replace("/[^0-9]/", "", $cpf);
    	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
     
	    // Verifica se o numero de digitos informados 頩gual a 11 
    	if (strlen($cpf) != 11) {
	        return false;
    	}
    	// Verifica se nenhuma das sequꮣias invalidas abaixo 
    	// foi digitada. Caso afirmativo, retorna falso
    	elseif ($cpf == '00000000000' || 
	       		$cpf == '11111111111' || 
       			$cpf == '22222222222' || 
       			$cpf == '33333333333' || 
       			$cpf == '44444444444' || 
       			$cpf == '55555555555' || 
       			$cpf == '66666666666' || 
       			$cpf == '77777777777' || 
       			$cpf == '88888888888' || 
      			$cpf == '99999999999') {
      		return false;
    		// Calcula os digitos verificadores para verificar se o
    		// CPF 頶ᬩdo
    	}
    	else {   
       		for ($t = 9; $t < 11; $t++) {
	            for ($d = 0, $c = 0; $c < $t; $c++) {
       		        $d += $cpf{$c} * (($t + 1) - $c);
           		}
           		$d = ((10 * $d) % 11) % 10;
       	   		if ($cpf{$c} != $d) {
               		return false;
	           	}
       		}
       		return true;
	   	}
	}
		
	public function setValidaCNPJ ( $cnpj ) {
		
		if(empty($cnpj)){
			return false;
		}
    	// Deixa o CNPJ com apenas n�meros
    	$cnpj = preg_replace( '/[^0-9]/', '', $cnpj );
    	$cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
    	
    	if (strlen($cnpj) != 14) {
	        return false;
    	}
    	// Verifica se nenhuma das sequꮣias invalidas abaixo 
    	// foi digitada. Caso afirmativo, retorna falso
    	elseif ($cnpj == '00000000000000' || 
	       		$cnpj == '11111111111111' || 
       			$cnpj == '22222222222222' || 
       			$cnpj == '33333333333333' || 
       			$cnpj == '44444444444444' || 
       			$cnpj == '55555555555555' || 
       			$cnpj == '66666666666666' || 
       			$cnpj == '77777777777777' || 
       			$cnpj == '88888888888888' || 
      			$cnpj == '99999999999999') {
      		return false;
    		// Calcula os digitos verificadores para verificar se o
    		// CPF 頶ᬩdo
    	}
    	else {
    	
	    	// Garante que o CNPJ 頵ma string
	    	$cnpj = (string)$cnpj;
		    
	    	// O valor original
	    	$cnpj_original = $cnpj;
		    
	    	// Captura os primeiros 12 n�meros do CNPJ
	    	$primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );
	    	
	    	/**
	     	* Multiplica磯 do CNPJ
	     	*
	     	* @param string $cnpj Os digitos do CNPJ
	     	* @param int $posicoes A posi磯 que vai iniciar a regress㯍
	     	* @return int O
	     	*
	     	*/
	    	if ( ! function_exists('multiplica_cnpj') ) {
	        	function multiplica_cnpj( $cnpj, $posicao = 5 ) {
	            	// Variᶥl para o cᬣulo
	            	$calculo = 0;
		            
	            	// La篠para percorrer os item do cnpj
	            	for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
	                	// Cᬣulo mais posi磯 do CNPJ * a posi磯
	                	$calculo = $calculo + ( $cnpj[$i] * $posicao );
	                	
	                	// Decrementa a posi磯 a cada volta do la篍
	                	$posicao--;
	    	            
		                // Se a posi磯 for menor que 2, ela se torna 9
	            	    if ( $posicao < 2 ) {
	    	                $posicao = 9;
	        	        }
	            	}
	        	    // Retorna o cᬣulo
	    	        return $calculo;
		        }
	    	}
		    
		    // Faz o primeiro cᬣulo
		    $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
		    
	    	// Se o resto da divis㯠entre o primeiro cᬣulo e 11 for menor que 2, o primeiro
	    	// D�to 頺ero (0), caso contrᲩo 頱1 - o resto da divis㯠entre o cᬣulo e 11
	    	$primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
		    
	    	// Concatena o primeiro d�to nos 12 primeiros n�meros do CNPJ
	    	// Agora temos 13 n�meros aqui
		    $primeiros_numeros_cnpj .= $primeiro_digito;
		 	
	    	// O segundo cᬣulo 頡 mesma coisa do primeiro, por魬 come硠na posi磯 6
	    	$segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
	    	$segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
	    	
	    	// Concatena o segundo d�to ao CNPJ
	    	$cnpj = $primeiros_numeros_cnpj . $segundo_digito;
	    	
	    	// Verifica se o CNPJ gerado 頩dꮴico ao enviado
	    	if ( $cnpj === $cnpj_original )
		        return true;
		    else
		    	return false;
		}
	}
	
	public function setValidaSenha($pass){
		if(strlen(trim($pass))<1)
			return false;
		elseif(!preg_match('/^[0-9a-z\_\-\.\#\$\%\&\*]{6,16}$/i',$pass))
			return false;
		else
			return true;
	}
	
	public function vEntradaUsuario($entrada){
		return htmlentities(strip_tags($entrada), ENT_QUOTES);
	}
	
	
}
?>