$(document).ready(function() {
	DateTables();
	$('#formMotivos').DataTable({
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
					"mColumns": [0, 1, 2, 3]
				},
				{
					"sExtends": "pdf",
					"sButtonText": "Exportar para PDF",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3]
				},
				{
					"sExtends": "print",
					"sButtonText": "Imprimir",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3]
				},
				{
					"sExtends": "copy",
					"sButtonText": "Copiar",
					"sTitle": "Fases",
					"sPdfOrientation": "landscape",
					"mColumns": [0, 1, 2, 3]
				}
			]
		},
		columnDefs: [
			{ type: 'date-br', targets: 3 }
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
    
    $('head > title').text('SRSC - MATERIA');
});

function exibir(n){
	$.post('/require/php/lp/jpMotivos.php',
		{
			status:'SU',
			cod:n
		},
		function(res)
		{
			if(res){
				limpar();
				var valores = res.split(";");
				$('#cod').val(valores[1]);
				$('#codoculto').val(valores[1]);
				$('#nome').val(valores[2]);
				$('#nomeAnterior').val(valores[2]);
				$('#descricao').val(valores[3]);
				
				$('main form *').attr('Disabled', 'True');
				$('main form button').hide();
				$('#linkEditar').show();
				$('#linkApagar').show();
				abrirDivForm();
			}
			else
				alert('Fase não encontrado!');
		}
	);
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
	$('button#btLimpar').text('Cancelar').attr({title:"Cancelar",onclick:"cancelar('"+$('#codoculto').val()+"')"});
}

function cadastrar(){
	var fd = new FormData(document.getElementById("fMotivos"));
	fd.append("status", "IN");
	fd.append("login", $("#logadoId").text());
	$.ajax({
		url: "/require/php/lp/jpMotivos.php",
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
	var fd = new FormData(document.getElementById("fMotivos"));
	fd.append("status", "ED");
	fd.append("login", $("#logadoId").text());
	$.ajax({
		url: "/require/php/lp/jpMotivos.php",
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
	    			cancelar($("#cod").val());
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
		$.post('/require/php/lp/jpMotivos.php',
			{
				status:'DE',
				cod:$('#codoculto').val()
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
						atualizarDataTables();
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

function atualizarDataTables(){
//	document.getElementById('grid').innerHTML = location.reload();

//	$("#conteudoGrid").load('/require/php/grid/fases.php');

/*
	$.ajax({
	    type: 'POST',
	    url: '/require/php/grid/fases.php',
	    success: function(data) {
	    	$("#conteudoGrid").html(data);
	    }
	});
*/
}