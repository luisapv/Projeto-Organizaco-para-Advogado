$(document).ready(function() {
	DateTables();
    $('#formPessaJuridica').DataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bPaginate": false,
		"sDom": '<"H"Tlfr>t<"F"ip>',
		"order":[[0,"asc"]],
		"oTableTools": {
			"SwfPath": "/require/plugins/dataTables/swf/copy_csv_xls_pdf.swf",
			"buttons":
			[
				{
					"sExtends": "xls",
					"sButtonText": "Exportar para Excel",
					"sTitle": "Fases",
					"mColumns": [0, 1, 2, 3, 4]
				},
				{
					"sExtends": "pdf",
					"sButtonText": "Exportar para PDF",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3, 4]
				},
				{
					"sExtends": "print",
					"sButtonText": "Imprimir",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3, 4]
				},
				{
					"sExtends": "copy",
					"sButtonText": "Copiar",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3, 4]
				}
			]
		},
		columnDefs: [
			{ type: 'date-br', targets: 4 }
        ],
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sZeroRecords": "Nenhum registro encontrado",
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros)",
			"sSearch": "Pesquisar: ",
			"oPaginate": {
				"sFirst": "Início",
				"sPrevious": "Anterior",
				"sNext": "Próximo",
				"sLast": "Último"
			}
		},
		"aaSorting": [[0, 'desc']]
	});
	
    addLi('header > nav > ul','<li><a href="javascript:novo();">NOVO</a></li>');
    
    $('.autocomplet').hide();
    
    $('head > title').text('SRSC - PESSOAS JURIDICA');
});

function exibir(n){
	$.post('/require/php/lp/jpPessoaJuridica.php',
		{
			status:'SU',
			cnpj:n
		},
		function(res)
		{
			if(res){
				limpar();
				var valores = res.split(";");
				$('#cod').val(valores[1]);
				$('#razaoSocial').val(valores[2]);
				$('#nomeFantasia').val(valores[3]);
				$('#cnpj').val(valores[4]);
				$('#antigocnpj').val(valores[4]);
				$('#observacao').val(valores[5]);
				$('#pessoaResponsavel').val(valores[8]);
				$('#email').val(valores[9]);
				$('#logradouro').val(valores[10]);
				$('#numero').val(valores[11]);
				$('#complemento').val(valores[12]);
				$('#bairro').val(valores[13]);
				$('#municipio').val(valores[14]);
				$('#estado').val(valores[15]);
				$('#cep').val(valores[16]);
				
				r	= campoEndereco($('#logradouro').val(),$('#numero').val(),$('#complemento').val(),$('#bairro').val(),$('#municipio').val(),$('#estado :selected').text(),$('#cep').val());
				val	= r.split('#');
				if(val[0]=='R'){
					$("#endereco").val(val[1]);
				}
				
				$('main form *').attr('Disabled', 'True');
				$('main form button').hide();
				$('#linkEditar').show();
				$('#linkApagar').show();
				abrirDivForm();
			}
			else
				alert('Pessoa Juridica não encontrado!');
		}
	);
}

function campoEndereco(logradouro,numero,complemento,bairro,municipio,estado,cep){
	var msg = '';
	var end = '';

	if(logradouro!=''){
		end = logradouro;
	}
	else{
		if(msg!='')
			msg = msg + ', ';
		msg = msg + 'Logradouro';
	}

	if(numero!=''){
		end = end + ', ' + numero;
	}

	if(complemento!=''){
		if(numero!=''){
			end = end + ' ' + complemento;
		}
		else{
			end = end + ', ' + complemento;
		}
	}

	if(bairro!=''){
		end = end + ', ' + bairro;
	}
	else{
		if(msg!='')
			msg = msg + ', ';
		msg = msg + 'Bairro';
	}

	if(municipio!=''){
		end = end + ', ' + municipio;
	}
	else{
		if(msg!='')
			msg = msg + ', ';
		msg = msg + 'Municipio';
	}
	
	if(estado!='SELECIONE'){
		end = end + '//' + estado;
	}
	else{
		if(msg!='')
			msg = msg + ', ';
		msg = msg + 'Estado';
	}

	if(cep!=''){
		end = end + ' - ' + cep;
	}
	else{
		if(msg!='')
			msg = msg + ', ';
		msg = msg + 'Cep';
	}

	if (msg==''){
		return 'R#'+end;
	}
	else{
		return 'M#'+msg;
	}
}

function exibirEndereco(){
	$("#dvCadastro").hide(2000);
	$("#dvEndereco").show(2000);
	$('#linkFechar').show();
	$("#linkFechar").attr('href','javascript:fecharDivEnd()');
	$("#cep").focus();
}

function fecharDivEnd(){
	r	= campoEndereco($('#logradouro').val(),$('#numero').val(),$('#complemento').val(),$('#bairro').val(),$('#municipio').val(),$('#estado :selected').text(),$('#cep').val());
	val	= r.split('#');
	
	if (val[0]=='M'){
		if(val[1]!='Logradouro, Bairro, Municipio, Estado, Cep'){
			var conf = confirm('Existe campos obrigatorios em branco!\n'+val[1]+'\nDeseja realmente fechar?');
			if (conf){
				$("#dvCadastro").show(2000);
				$("#linkFechar").attr('href','javascript:fecharDivForm()');
				$("#dvEndereco").hide(2000);
				$('#endereco').val('');
			}
		}
		else{
			$("#dvCadastro").show(2000);
			$("#linkFechar").attr('href','javascript:fecharDivForm()');
			$("#dvEndereco").hide(2000);
			$('#endereco').val('');
		}
	}
	else{
		$("#endereco").val(val[1]);
		$("#dvCadastro").show(2000);
		$("#linkFechar").attr('href','javascript:fecharDivForm()');
		$("#dvEndereco").hide(2000);
	}
	
	if($('button#btEnviar').text()=='Editar'){
		$("#linkFechar").hide();
	}
	else if($('button#btEnviar').text()=='Cadastrar'){
		$("#linkFechar").show();
	}
	$("#razaoSocial").focus();
}

function novo(){
	limpar();
	$('main form *').removeAttr('Disabled');
	$('#cod').attr('Disabled', 'true');
	$('#linkEditar').hide();
	$('#linkApagar').hide();
	$('#spanPDF').hide();
	$('main form button').show();
	$('button#btEnviar').text('Cadastrar').attr({title:"Cadastrar",onclick:"cadastrar()"});
	$('button#btLimpar').text('Limpar').attr({title:"Limpar",onclick:"limpar()"});
	abrirDivForm();
	$('#razaoSocial').focus();
}

function editar(){
	$('main form *').removeAttr('Disabled');
	$('#cod').attr('Disabled', 'true');
	$('main form button').show();
	$('#linkEditar').hide();
	$('#linkApagar').hide();
	$('#linkFechar').hide();
	$('button#btEnviar').text('Salvar').attr({title:"Salvar",onclick:"editando()"});
	$('button#btLimpar').text('Cancelar').attr({title:"Cancelar",onclick:"cancelar('"+$('#antigocnpj').val()+"')"});
}

function cadastrar(){
	var fd = new FormData(document.getElementById("formPessoaJuridica"));
	fd.append("status", "IN");
	fd.append("login", $("#logadoId").text());
	$.ajax({
      	url: "/require/php/lp/jpPessoaJuridica.php",
      	type: "POST",
      	data: fd,
      	processData: false,  // Diga ao jQuery para não processar os dados
      	contentType: false,   // Diga jQuery para não definir contentType
	    beforeSend: function () {
	        //Aqui adicionas o loader
	        $(".msg-form").slideDown().html("<center><img src='require/img/projeto/LoaderIcon.gif' /><BR /><h2>CARREGANDO<marquee direction='right'>...</marquee</h2></center>").css({background:'#ECE660'});
	    },
	    success:function(data){
	    	if (data){
	    		$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
	    	}
	    	else{
	    		$('.msg-form').slideDown(500).html('Cadastro realizado com sucesso.').css({background:'#069'});
	    		window.setTimeout(function(){
	    			$('.msg-form').slideUp(500);
	    			limpar();
				},4000);
	    	}
	    },
	    error: function(data){
			$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
		}
    });
}

function editando(){
	var fd = new FormData(document.getElementById("formPessoaJuridica"));
	fd.append("status", "ED");
	fd.append("login", $("#logadoId").text());
	$.ajax({
      	url: "/require/php/lp/jpPessoaJuridica.php",
      	type: "POST",
      	data: fd,
      	processData: false,  // Diga ao jQuery para não processar os dados
      	contentType: false,   // Diga jQuery para não definir contentType
		beforeSend: function () {
	        //Aqui adicionas o loader
	        $(".msg-form").slideDown().html("<center><img src='require/img/projeto/LoaderIcon.gif' /><BR /><h2>CARREGANDO<marquee direction='right'>...</marquee</h2></center>").css({background:'#ECE660'});
	    },
	    success:function(data){
	    	if (data){
	    		$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
	    	}
	    	else{
	    		$('.msg-form').slideDown(500).html('Edição realizada com sucesso.').css({background:'#069'});
	    		window.setTimeout(function(){
	    			$('.msg-form').slideUp(500);
	    			cancelar($("#cnpj").val());
				},4000);
	    	}
	    },
	    error: function(data){
			$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
		}
    });
}

function apagar(){
	if(confirm('Tem certeza que deseja deletar?')){
		$.post('/require/php/lp/jpPessoaJuridica.php',
			{
				status:'DE',
				cnpj:$('#cnpj').val()
			},
			function(data){
				if (data){
					$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
				}
				else{
					$('.msg-form').slideDown(500).html('Deletado com sucesso.').css({background:'#069'});
					window.setTimeout(function(){
						$('.msg-form').slideUp(500);
						fecharDivForm();
					},4000);
				}
			}
		);
	}
}

function limpar(){
	$('main form input').val('');
	$('main form textarea').val('');
	$('main form select').val('');
	$(".msg-form").html('');
	$(".msg-form").hide();
	$("#autor-list").html('');
	$("#autor-list").hide();
	$("#advogado-list").html('');
	$("#advogado-list").hide();
	$("#reu-list").html('');
	$("#reu-list").hide();
	$("#fase-list").html('');
	$("#fase-list").hide();
	$("#motivo-list").html('');
	$("#motivo-list").hide();
}

function cancelar(e){
	exibir(e);
	$('main form button').hide();
	$('#linkEditar').show();
	$('#linkApagar').show();
	$('#linkFechar').show();
}

function abrirDivForm(){
	$("#divform").show(2000);		
}

function fecharDivForm(){
	limpar();
	$("#divform").hide(2000);
}

function carregarGrid(){
//	$('#grid').refresh();
}

function addLinhaDataTables(e){
//	$("#formPessaJuridica").DataTable().row.add(e).draw( false );
}

function atualizarLinhaDataTables(){
//	$("#formPessaJuridica").DataTable().clear().rows.add(refreshedDataFromTheServer).draw();
}

function autoCompleteEndereco(){
// Fazer
}

function fecharAutocomplete(){
	$('.autocomplet').hide();
	$('.autocomplet').html('');
}

function cepKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#cep').val();
	
	if (keyword.length >= min_length && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACCEP',val:keyword},
			success:function(data){
				$('#cep-list').show();
				$('#cep-list').html(data);
			}
		});
	} else {
		$('#cep-list').hide();
		$('#cep-list').html();
	}
}

function setCepAC(nome){
	// change input value
	$('#cep').val(nome);
	// hide proposition list
	$('#cep-list').hide();
}

function logradouroKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#logradouro').val();
	
	if (keyword.length >= min_length && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACLograouro',val:keyword},
			success:function(data){
				$('#logradouro-list').show();
				$('#logradouro-list').html(data);
			}
		});
	} else {
		$('#logradouro-list').hide();
		$('#logradouro-list').html();
	}
}

function setLogradouroAC(nome){
	// change input value
	$('#logradouro').val(nome);
	// hide proposition list
	$('#logradouro-list').hide();
}

function bairroKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#bairro').val();
	
	if (keyword.length >= min_length && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACBairro',val:keyword},
			success:function(data){
				$('#bairro-list').show();
				$('#bairro-list').html(data);
			}
		});
	} else {
		$('#bairro-list').hide();
		$('#bairro-list').html();
	}
}

function setBairroAC(nome){
	// change input value
	$('#bairro').val(nome);
	// hide proposition list
	$('#bairro-list').hide();
}

function municipioKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#municipio').val();
	if (keyword.length >= min_length && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACMunicipio',val:keyword},
			success:function(data){
				$('#municipio-list').show();
				$('#municipio-list').html(data);
			}
		});
	} else {
		$('#municipio-list').hide();
		$('#municipio-list').html();
	}
}

function setMunicipioAC(nome){
	// change input value
	$('#municipio').val(nome);
	// hide proposition list
	$('#municipio-list').hide();
}