$(document).ready(function(){
	DateTables();
	carregarGrid();
	
	$('#selecionaCamposVisiveis').multipleSelect({
    	multiple: true,
	    columns: 2,
		multipleWidth: 150,
	    placeholder: 'Colunas para exibir!',
	    onClose: function(){
			xmlColunasGrid('Salvar');
		}
	});
	
	xmlColunasGrid('RelatarConfiguracaoDoCampo');
    
    addLi('header > nav > ul','<li><a href="javascript:novo();">NOVO</a></li>');
    
    $('head > title').text('SRSC - PROCESSO');
    
    fecharAutocomplete();
});

function ocultarCampo(){
	data = $("#selecionaCamposVisiveis").multipleSelect("getSelects");
	for(i=0;i<=16;i++){
	    if(data.indexOf(i.toString()) != -1){
			$('#tbProcessoGrid').DataTable().column(i).visible(true);
		}
		else{
			$('#tbProcessoGrid').DataTable().column(i).visible(false);
		}
	}
}

function xmlColunasGrid(funcao){
	var fd = new FormData();
	fd.append("status", "carregarColunasGrid");
	fd.append("status2", funcao);
	fd.append("colunas", $("#selecionaCamposVisiveis").multipleSelect("getSelects"));
	fd.append("login", $("#logadoNome").text());
	$.ajax({
		url: "/require/php/lp/jpProcesso.php",
		type: "POST",
		data: fd,
		processData: false,  // Diga ao jQuery para não processar os dados
		contentType: false,   // Diga jQuery para não definir contentType
		beforeSend: function () {
	        //Aqui adicionas o loader
	    },
	    success:function(data){
	    	if (data){
	    		if(funcao=='RelatarConfiguracaoDoCampo'){
	    			contem = "";
	    			data = data.split(',');
	    			for(i = 0;i<data.length;i++){
					    if(data[i]==1){
							contem += i+',';
							$('#tbProcessoGrid').DataTable().column(i).visible(true);
						}
						else{
							$('#tbProcessoGrid').DataTable().column(i).visible(false);
						}
					}
					if(contem!=""){
						contem = contem.substr(0,(contem.length - 1));
						$("#selecionaCamposVisiveis").multipleSelect("setSelects",contem.split(','));
					}
				}
	    	}
	    	else{
	    		if(funcao=='Salvar'){
					data = $("#selecionaCamposVisiveis").multipleSelect("getSelects");
					for(i=0;i<=16;i++){
					    if(data.indexOf(i.toString()) != -1){
							$('#tbProcessoGrid').DataTable().column(i).visible(true);
						}
						else{
							$('#tbProcessoGrid').DataTable().column(i).visible(false);
						}
					}
				}
	    	}
	    },
	    error: function(data){
//			$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
		}
    });
}

function carregarGrid(){
	$('#tbProcessoGrid').DataTable({
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
					"mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
				},
				{
					"sExtends": "pdf",
					"sButtonText": "Exportar para PDF",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
				},
				{
					"sExtends": "print",
					"sButtonText": "Imprimir",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
				},
				{
					"sExtends": "copy",
					"sButtonText": "Copiar",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
				}
			]
		},
		columnDefs: [
			{ type: 'date-br', targets: 16 }
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
}

function exibir(n){
	$.post('/require/php/lp/jpProcesso.php',
		{
			status:'SU',
			processo:n
		},
		function(res)
		{
			if(res){
				limpar();
				var valores = res.split(";");
				$('#processo').val(valores[1]);
				$('#antigoProcesso').val(valores[1]);
				$('#juiz').val(valores[4]);
				$('#trtTurma').val(valores[5]);
				$('#trtRelator').val(valores[6]);
				$('#tstTurma').val(valores[7]);
				$('#tstRelator').val(valores[8]);
				$('#statu').val(valores[9].toString());
				$('#autor').val(valores[10].toString().replaceAll(",",";"));
				$('#advogadoA').val(valores[11].toString().replaceAll(",",";"));
				$('#reu').val(valores[12].toString().replaceAll(",",";"));
				$('#advogadoR').val(valores[13].toString().replaceAll(",",";"));
				$('#fase').val(valores[14].toString().replaceAll(",",";"));
				$('#motivo').val(valores[15].toString().replaceAll(",",";"));
				$('main form *').attr('Disabled', 'true');
				$('token-input-delete-token').css('Disabled', 'disabled');
				$('main form button').hide();
				$('#linkEditar').show();
				$('#linkApagar').show();
				if(valores[2]==1){
					$('#spanPDF').show();
					$('#editarArquivo').attr('href','javascript:void(0)');
					$('#editarArquivo').attr('onclick','abrirPDF(\''+$('#processo').val()+'\')');
					if(valores[3]!='')
						$('#editarLabelArquivo').text(valores[3]);
					else
						$('#editarLabelArquivo').text('');
				}
				else{
					$('#spanPDF').hide();
				}
				abrirDivForm();
			}
			else
				alert('Processo não encontrado!');
		}
	);
}

function novo(){
	limpar();
	$('main form *').removeAttr('disabled');
	$('#linkEditar').hide();
	$('#linkApagar').hide();
	$('#spanPDF').hide();
	$('main form button').show();
	$('button#btEnviar').text('Cadastrar').attr({title:"Cadastrar",onclick:"cadastrar()"});
	$('button#btLimpar').text('Limpar').attr({title:"Limpar",onclick:"limpar()"});
	abrirDivForm();
}

function editar(){
	$('main form *').removeAttr('disabled');
	$('main form button').show();
	$('#linkEditar').hide();
	$('#linkApagar').hide();
	$('#linkFechar').hide();
	$('button#btEnviar').text('Salvar').attr({title:"Salvar",onclick:"editando()"});
	$('button#btLimpar').text('Cancelar').attr({title:"Cancelar",onclick:"cancelar('"+$('#antigoProcesso').val()+"')"});
}

function cadastrar(){
	var fd = new FormData(document.getElementById("formProcesso"));
	fd.append("status", "IN");
	fd.append("login", $("#logadoId").text());
	$.ajax({
		url: "/require/php/lp/jpProcesso.php",
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
	var fd = new FormData(document.getElementById("formProcesso"));
	fd.append("status", "ED");
	fd.append("login", $("#logadoId").text());
	$.ajax({
		url: "/require/php/lp/jpProcesso.php",
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
	    			cancelar($('#processo').val())
				},4000);
	    	}
	    },
	    error: function(data){
			$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
		}
    });
}

function apagar(){
	var fd = new FormData();
	fd.append("status", "DE");
	fd.append("processo", $('#processo').val());
	if(confirm('Tem certeza que deseja deletar?')){
		$.ajax({
			url: "/require/php/lp/jpProcesso.php",
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
		    			limpar();
					},4000);
		    	}
		    },
		    error: function(data){
				$('.msg-form').slideDown(500).html(data).css({background:'#FF3131'});
			}
	    });
/*
		$.post('/require/php/lp/jpProcesso.php',
			{
				status:'DE',
				processo:$('#processo').val()
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
*/
	}
}

function limpar(){
	$('main form input').val('');
	$('main form select').val('');
	$(".msg-form").html('');
	$(".msg-form").hide();
	$("#autor-list").html('');
	$("#autor-list").hide();
	$("#advogadoA-list").html('');
	$("#advogadoA-list").hide();
	$("#advogadoR-list").html('');
	$("#advogadoR-list").hide();
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

function atualizarDataTables(){
	document.getElementById('grid').innerHTML = location.reload();
}

function abrirPDF(n){
	window.open('http://srsc-advogado.com.br/arquivos/'+n, '_blank');
	window.setTimeout(function(){
		$('#divform').hide();
	},600);
}

function fecharAutocomplete(){
	$('.autocomplet').hide();
	$('.autocomplet').html('');
}

function autorKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#autor').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACAutor',val:keyword},
			success:function(data){
				if(data!=''){
					$('#autor-list').show();
					$('#autor-list').html(data);
				}
				else{
					$('#autor-list').hide();
					$('#autor-list').html('');
				}
			}
		});
	}
	else{
		$('#autor-list').hide();
		$('#autor-list').html('');
	}
}

function setAutorAC(nome){
	valor = $('#autor').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#autor').val(valor+nome+';').focus();
	// hide proposition list
	$('#autor-list').hide();
}

function reuKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#reu').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACReu',val:keyword},
			success:function(data){
				if(data!=''){
					$('#reu-list').show();
					$('#reu-list').html(data);
				}
				else{
					$('#reu-list').hide();
					$('#reu-list').html('');
				}
			}
		});
	}
	else{
		$('#reu-list').hide();
		$('#reu-list').html('');
	}
}

function setReuAC(nome){
	valor = $('#reu').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#reu').val(valor+nome+';').focus();
	// hide proposition list
	$('#reu-list').hide();
}

function advogadoAKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#advogadoA').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACAAutor',val:keyword},
			success:function(data){
				if(data!=''){
					$('#advogadoA-list').show();
					$('#advogadoA-list').html(data);
				}
				else{
					$('#advogadoA-list').hide();
					$('#advogadoA-list').html('');
				}
			}
		});
	}
	else{
		$('#advogadoA-list').hide();
		$('#advogadoA-list').html('');
	}
}

function setAdvogadoAAC(nome){
	valor = $('#advogadoA').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#advogadoA').val(valor+nome+';').focus();
	// hide proposition list
	$('#advogadoA-list').hide();
}

function advogadoRKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#advogadoR').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACAReu',val:keyword},
			success:function(data){
				if(data!=''){
					$('#advogadoR-list').show();
					$('#advogadoR-list').html(data);
				}
				else{
					$('#advogadoR-list').hide();
					$('#advogadoR-list').html('');
				}
			}
		});
	}
	else{
		$('#advogadoR-list').hide();
		$('#advogadoR-list').html('');
	}
}

function setAdvogadoRAC(nome){
	valor = $('#advogadoR').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#advogadoR').val(valor+nome+';').focus();
	// hide proposition list
	$('#advogadoR-list').hide();
}

function fasesKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#fase').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACF',val:keyword},
			success:function(data){
				if(data!=''){
					$('#fase-list').show();
					$('#fase-list').html(data);
				}
				else{
					$('#fase-list').hide();
					$('#fase-list').html('');
				}
			}
		});
	}
	else{
		$('#fase-list').hide();
		$('#fase-list').html('');
	}
}

function setFasesAC(nome){
	valor = $('#fase').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#fase').val(valor+nome+';').focus();
	// hide proposition list
	$('#fase-list').hide();
}

function motivosKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#motivo').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACM',val:keyword},
			success:function(data){
				if(data!=''){
					$('#motivo-list').show();
					$('#motivo-list').html(data);
				}
				else{
					$('#motivo-list').hide();
					$('#motivo-list').html('');
				}
			}
		});
	}
	else{
		$('#motivo-list').hide();
		$('#motivo-list').html('');
	}
}

function setMotivosAC(nome){
	valor = $('#motivo').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#motivo').val(valor+nome+';').focus();
	// hide proposition list
	$('#motivo-list').hide();
}

function setFasesAC(nome){
	valor = $('#fase').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#fase').val(valor+nome+';').focus();
	// hide proposition list
	$('#fase-list').hide();
}

function motivosKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#motivo').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACM',val:keyword},
			success:function(data){
				if(data!=''){
					$('#motivo-list').show();
					$('#motivo-list').html(data);
				}
				else{
					$('#motivo-list').hide();
					$('#motivo-list').html('');
				}
			}
		});
	}
	else{
		$('#motivo-list').hide();
		$('#motivo-list').html('');
	}
}

function setMotivosAC(nome){
	valor = $('#motivo').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#motivo').val(valor+nome+';').focus();
	// hide proposition list
	$('#motivo-list').hide();
}

function setFasesAC(nome){
	valor = $('#fase').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#fase').val(valor+nome+';').focus();
	// hide proposition list
	$('#fase-list').hide();
}

function motivosKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#motivo').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACM',val:keyword},
			success:function(data){
				if(data!=''){
					$('#motivo-list').show();
					$('#motivo-list').html(data);
				}
				else{
					$('#motivo-list').hide();
					$('#motivo-list').html('');
				}
			}
		});
	}
	else{
		$('#motivo-list').hide();
		$('#motivo-list').html('');
	}
}

function setMotivosAC(nome){
	valor = $('#motivo').val();
	razao = false;
	while(razao==false){
		if(valor.substr(valor.length-1,valor.length)==';' || valor==''){
			razao = true;
		}
		else{
			valor = valor.substr(0,valor.length-1);
		}
	}
	
	// change input value
	$('#motivo').val(valor+nome+';').focus();
	// hide proposition list
	$('#motivo-list').hide();
}

function trtRelatorKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#trtRelator').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACTRTR',val:keyword},
			success:function(data){
				if(data!=''){
					$('#trtRelator-list').show();
					$('#trtRelator-list').html(data);
				}
				else{
					$('#trtRelator-list').hide();
					$('#trtRelator-list').html('');
				}
			}
		});
	}
	else{
		$('#trtRelator-list').hide();
		$('#trtRelator-list').html('');
	}
}

function setTrtRelatorAC(nome){
	// change input value
	$('#trtRelator').val(nome).focus();
	// hide proposition list
	$('#trtRelator-list').hide();
}

function tstRelatorKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#tstRelator').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACTSTR',val:keyword},
			success:function(data){
				if(data!=''){
					$('#tstRelator-list').show();
					$('#tstRelator-list').html(data);
				}
				else{
					$('#tstRelator-list').hide();
					$('#tstRelator-list').html('');
				}
			}
		});
	}
	else{
		$('#tstRelator-list').hide();
		$('#tstRelator-list').html('');
	}
}

function setTstRelatorAC(nome){	
	// change input value
	$('#tstRelator').val(nome).focus();
	// hide proposition list
	$('#tstRelator-list').hide();
}

function juizKeyUp(){
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#juiz').val();
	var akey = keyword.split(';');
	if (keyword.length >= min_length && akey[akey.length-1].trim()!='' && event.keyCode!=27 && event.keyCode!=9) {
		$.ajax({
			url: '/require/php/lp/jpAutocomplete.php',
			type: 'POST',
			data: {status:'ACJuiz',val:keyword},
			success:function(data){
				if(data!=''){
					$('#juiz-list').show();
					$('#juiz-list').html(data);
				}
				else{
					$('#juiz-list').hide();
					$('#juiz-list').html('');
				}
			}
		});
	}
	else{
		$('#juiz-list').hide();
		$('#juiz-list').html('');
	}
}

function setJuizAC(nome){	
	// change input value
	$('#juiz').val(nome).focus();
	// hide proposition list
	$('#juiz-list').hide();
}