$(document).ready(function(){
	$('#eLogin').focus();	
});


function fctLogin(){
	$('#msgLogin').html(null);
	$('#msgELogin').html(null);
	$('#msgSLogin').html(null);
	$('#eLogin').css('borderColor','#BDC7D8');
	$('#sLogin').css('borderColor','#BDC7D8');
	login = trim($('#eLogin').val());
	senha = ltrim($('#sLogin').val());
	
	if(login.length<1){
		$('#msgELogin').html('Informe seu Login');
		$('#eLogin').css('borderColor','#F00F00');
	}
	if(senha.length<1 || senha==null){
		$('#msgSLogin').html('Informe sua Senha.');
		$('#sLogin').css('borderColor','#F00F00');
		
	}
	if((login.length<1) ||	(senha.length<1)){
		exit;
	}
	
	$.post('/require/php/lp/jpLogin.php',
		{
			login:login,
			senha:senha
		},
		function(res){
			if(res)
				$('#msgLogin').html(res);
			else
				location.href='/';
		}	
	);
}

function num(el){
	return vCampos(el,"^[0-9]$");
}