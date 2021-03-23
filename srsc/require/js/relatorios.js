$(document).ready(function(){
	DataTables('Geral','tbPesquisar');
	$('#tbPesquisar tbody').on('click','tr',function(){
    	if ($(this).hasClass('selected')){
        	$(this).removeClass('selected');
    	}
    	else{
    	    $('#tbPesquisar').DataTable().$('tr.selected').removeClass('selected');
    	    $(this).addClass('selected');
    	}
	});
	$('#buttonAddPesquisar').click(function(){
		var indice	= $("input[name='pesquisa']:checked").val();
		var n	  	= $("input[name='naoPesquisa']:checked").val();
		var campo	= $("#localPesquisa").val();
		var texto	= $("#textoPesquisa").val();
		var msg		= "";
		if(indice=="" || indice==null){
			msg += "Escolha como deseja a pesquisa.\n";
		}
		if(campo=="" || campo==null){
			msg += "Escolha um campo que deseja consultar.\n";
		}
		if(texto=="" || texto==null){
			msg += "Digite o que deseja consultar.";
		}
		
		if(msg!=""){
			alert(msg);
		}
		else{
			if(n!='Nao'){
				n=null;
			}
        	$('#tbPesquisar').DataTable().row.add([indice,n,campo,texto]).draw(false);
        	$("input[name='pesquisa']").prop('checked',false);
        	$("input[name='naoPesquisa']").prop('checked',false);
        	$("#localPesquisa").val('');
        	$("#textoPesquisa").val('');
        }
    });
    $('#buttonRemovePesquisar').click(function(){
        $('#tbPesquisar').DataTable().row('.selected').remove().draw(false);
    });
    
    
	DataTables('Geral','tbOrdenar');
	$('#tbOrdenar tbody').on('click','tr',function(){
		if($(this).hasClass('selected')){
        	$(this).removeClass('selected');
        }
        else{
            $('#tbOrdenar').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    $('#buttonAddOrdenar').click(function(){
		var indice	= $("input[name='ordenar']:checked").val();
		var campo	= $("#localOrdenar").val();
		var msg		= "";
		if(indice=="" || indice==null){
			msg += "Escolha a forma de ordenar.\n";
		}
		if(campo=="" || campo==null){
			msg += "Escolha um campo que deseja ordenar.";
		}
		
		if(msg!=""){
			alert(msg);
		}
		else{
        	$('#tbOrdenar').DataTable().row.add([indice,campo]).draw(false);
        	$("input[name='ordenar']").prop('checked',false);
        	$("#localOrdenar").val('');
        }
    });
    $('#buttonRemoveOrdenar').click(function(){
        $('#tbOrdenar').DataTable().row('.selected').remove().draw(false);
    });
    
    
	DataTables('Geral','tbSubstuir');
	$('#tbSubstuir tbody').on('click','tr',function(){
    	if($(this).hasClass('selected')){
        	$(this).removeClass('selected');
    	}
    	else{
        	$('#tbSubstuir').DataTable().$('tr.selected').removeClass('selected');
        	$(this).addClass('selected');
    	}
	});
    $('#buttonAddSubstituir').click(function(){
		var local	= $("#localSubstituir").val();
		var de		= $("#deSubstituir").val();
		var para		= $("#paraSubstituir").val();
		var msg		= "";
		if(local=="" || local==null){
			msg += "Escolha o local que deseja a substituir.\n";
		}
		if(de=="" || de==null){
			msg += "Digite o que deseja substituir.\n";
		}
		if(para=="" || para==null){
			para = "";
		}
		
		if(msg!=""){
			alert(msg);
		}
		else{
        	$('#tbSubstuir').DataTable().row.add([local,de,para]).draw(false);
        	$("#localSubstituir").val('');
			$("#deSubstituir").val('');
			$("#paraSubstituir").val('');
        }
    });
    $('#buttonRemoveSubstituir').click(function(){
         $('#tbSubstuir').DataTable().row('.selected').remove().draw(false);
    } );
	
	$("#dvDestinatariosAvancados").hide();
	$("divMensagem").hide();
	DataTables('DestinatarioRemetente','tbGrid');
	
	$('head > title').text('SRSC - RELATORIOS');
});

function DataTables(tipo,id){
	if(tipo=='Geral'){
		$('#'+id).DataTable({
			"select": {
	            style: 'multi'
	        },
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": false,
	        "sDom": '<"H"Tlfr>t<"F"ip>',
	        "bFilter": false,
	        "ordering": false,
	        "info": false,
	        "oTableTools": {
	            "sSwfPath": "/require/img/projeto/dataTables/swf/copy_csv_xls_pdf.swf",
	            "aButtons":
	        	[
	                {
	                    "sExtends": "xls",
	                    "sButtonText": "Exportar para Excel",
	                    "sTitle": "Fases",
	                    "mColumns": [0, 1, 2]
	                },
	                {
	                    "sExtends": "pdf",
	                    "sButtonText": "Exportar para PDF",
	                    "sTitle": "Fases",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2]
	                },
	                {
	                    "sExtends": "print",
	                    "sButtonText": "Imprimir",
	                    "sTitle": "Fases",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2]
	                },
	                {
	                    "sExtends": "copy",
	                    "sButtonText": "Copiar",
	                    "sTitle": "Fases",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2]
	                }
	            ]
	        },
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
	        "aaSorting": [[0, 'desc']],
	        "aoColumnDefs": [
	            {"sType": "num-html", "aTargets": [0]}
	        ]
	    });
	}
	else if(tipo=='DestinatarioRemetente'){
		$('#'+id).DataTable({
			"select": {
	            style: 'multi'
	        },
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": false,
	        "sDom": '<"H"Tlfr>t<"F"ip>',
	        "bFilter": false,
	        "ordering": false,
	        "contentType": "application/json; charset=utf-8",
        	"dataType": "json",
	        "oTableTools": {
	            "sSwfPath": "/require/img/projeto/dataTables/swf/copy_csv_xls_pdf.swf",
	            "aButtons":
	        	[
	                {
	                    "sExtends": "xls",
	                    "sButtonText": "Exportar para Excel",
	                    "sTitle": "Fases",
	                    "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
	                },
	                {
	                    "sExtends": "pdf",
	                    "sButtonText": "Exportar para PDF",
	                    "sTitle": "Fases",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
	                },
	                {
	                    "sExtends": "print",
	                    "sButtonText": "Imprimir",
	                    "sTitle": "Fases",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
	                },
	                {
	                    "sExtends": "copy",
	                    "sButtonText": "Copiar",
	                    "sTitle": "Fases",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
	                }
	            ]
	        },
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
	        "aoColumnDefs": [
	            {"sType": "num-html", "aTargets": [0]}
	        ]
	    });
	}
}

function destinatariosAvancados(){
	if($("#checkboxAvancados").is(':checked')){
		$("#dvDestinatariosAvancados").slideDown(500);
		$("#dvDestinatariosAvancados").css("display","block");
	}
}

function fecharAvancado(){
	$("#dvDestinatariosAvancados").slideUp(500);
	$("#checkboxAvancados").prop('checked',false);
}

function gerarR(){
	if($('#tipo1').val()=='1' && $('#tipo2').val()=='2'){
		$('#tbGrid').DataTable().clear().draw(false);
		var avancPesquisar	= "";
		var avancOrdenar	= "";
		var avancSubstituir	= "";
		
		if(!$('#tbPesquisar > tbody > tr > td').hasClass('dataTables_empty')){
			$('#tbPesquisar tbody').find('tr').each(function(i,el){
				var $tds = $(this).find('td');
				avancPesquisar += $tds.eq(0).text()+','+$tds.eq(1).text()+','+$tds.eq(2).text()+','+$tds.eq(3).text()+';';
			});
		}
		if(!$('#tbOrdenar > tbody > tr > td').hasClass('dataTables_empty')){
			$('#tbOrdenar tbody').find('tr').each(function(i,el){
				var $tds = $(this).find('td');
				avancOrdenar += $tds.eq(0).text()+','+$tds.eq(1).text()+';';
			});
		}
		if(!$('#tbSubstuir > tbody > tr > td').hasClass('dataTables_empty')){
			$('#tbSubstuir tbody').find('tr').each(function(i,el){
				var $tds = $(this).find('td');
				avancSubstituir += $tds.eq(0).text()+','+$tds.eq(1).text()+','+$tds.eq(2).text()+';';
			});
		}
		if(avancPesquisar!="")
			avancPesquisar	= avancPesquisar.substring(0,avancPesquisar.length-1);
		if(avancOrdenar!="")
			avancOrdenar	= avancOrdenar.substring(0,avancOrdenar.length-1);
		if(avancSubstituir!="")
			avancSubstituir	= avancSubstituir.substring(0,avancSubstituir.length-1);
		
		var fd = new FormData();
		fd.append("status", "Destinario");
		fd.append("status2", "gerarR");
		fd.append("Pesquisa", avancPesquisar);
		fd.append("Ordena", avancOrdenar);
		fd.append("Substituir", avancSubstituir);
		
		$.ajax({
			url: '/require/php/lp/jpRelatorios.php',
			type: 'POST',
			data: fd,
			processData: false,  // Diga ao jQuery para não processar os dados
			contentType: false,   // Diga jQuery para não definir contentType
			beforeSend: function(){
		        //Aqui adicionas o loader
		        $("#divMensagem").slideDown().html("<center><img src='require/img/projeto/LoaderIcon.gif' /><BR /><h2>CARREGANDO<marquee direction='right'>...</marquee</h2></center>").css({background:'#ECE660'});
		    },
			success:function(data){
				$('#divMensagem').hide();
/*
				if (typeof($("#tbGrid > thead > tr > th")) !== "undefined"){
					$("#tbGrid > thead > tr").closest('#tbGrid > thead > tr').remove();
				}
				var header = $('tr');
				var cols = "";
				cols += "<th>NOME</th>";
				cols += "<th>LOGRADOURO</th>";
				cols += "<th>NUMERO</th>";
				cols += "<th>COMPLEMENTO</th>";
				cols += "<th>BAIRRO</th>";
				cols += "<th>CIDADE</th>";
				cols += "<th>ESTADO</th>";
				cols += "<th>CEP</th>";
				header.append(cols);
				$("#tbGrid > thead").append(header);
				
//				DataTables('tbGrid');
				
				if (typeof($("#tbGrid > thead > tr")) !== "undefined"){
					$('#tbGrid').DataTable().clear().draw(false);
				}
				
				$('#tbGrid').DataTable().rows.add(data).draw(false);
*/
				var obj = JSON.parse(data);
				$.each(obj,function(i, item){
					$('#tbGrid').DataTable().row.add([item.nome.toString(),item.logradouro.toString(),item.numero.toString(),item.complemento.toString(),item.bairro.toString(),item.cidade.toString(),item.sigla.toString(),item.cep.toString()]).draw(false);
				});
			},
		    error: function(data){
				alert('ERRO');				
			}
		});
	}
	else if($('#tipo1').val()=='1' && $('#tipo2').val()=='1'){
		$('#tbGrid').DataTable().clear().draw(false);
		var fd = new FormData();
		fd.append("status", "Remetente");
		fd.append("status2", "gerarR");
		fd.append("quantidade", "1");
		
		$.ajax({
			url: '/require/php/lp/jpRelatorios.php',
			type: 'POST',
			data: fd,
			processData: false,  // Diga ao jQuery para não processar os dados
			contentType: false,   // Diga jQuery para não definir contentType
			beforeSend: function(){
		        //Aqui adicionas o loader
		        $("#divMensagem").slideDown().html("<center><img src='require/img/projeto/LoaderIcon.gif' /><BR /><h2>CARREGANDO<marquee direction='right'>...</marquee</h2></center>").css({background:'#ECE660'});
		    },
			success:function(data){
				$('#divMensagem').hide();
				
				var obj = JSON.parse(data);
				$.each(obj,function(i, item){
					$('#tbGrid').DataTable().row.add([item.nome.toString(),item.logradouro.toString(),item.numero.toString(),item.complemento.toString(),item.bairro.toString(),item.cidade.toString(),item.sigla.toString(),item.cep.toString()]).draw(false);
				});
			},
		    error: function(data){
				alert('ERRO');				
			}
		});
	}
}

function gerarPDF(){
	if($('#tipo1').val()=='1' && $('#tipo2').val()=='2'){
		var avancPesquisar	= "";
		var avancOrdenar	= "";
		var avancSubstituir	= "";
		
		if(!$('#tbPesquisar > tbody > tr > td').hasClass('dataTables_empty')){
			$('#tbPesquisar tbody').find('tr').each(function(i,el){
				var $tds = $(this).find('td');
				avancPesquisar += $tds.eq(0).text()+','+$tds.eq(1).text()+','+$tds.eq(2).text()+','+$tds.eq(3).text()+';';
			});
		}
		if(!$('#tbOrdenar > tbody > tr > td').hasClass('dataTables_empty')){
			$('#tbOrdenar tbody').find('tr').each(function(i,el){
				var $tds = $(this).find('td');
				avancOrdenar += $tds.eq(0).text()+','+$tds.eq(1).text()+';';
			});
		}
		if(!$('#tbSubstuir > tbody > tr > td').hasClass('dataTables_empty')){
			$('#tbSubstuir tbody').find('tr').each(function(i,el){
				var $tds = $(this).find('td');
				avancSubstituir += $tds.eq(0).text()+','+$tds.eq(1).text()+','+$tds.eq(2).text()+';';
			});
		}
		
		var fd = new FormData();
		fd.append("status", "Destinario");
		fd.append("status2", "gerarPDF");
		fd.append("Pesquisa", avancPesquisar);
		fd.append("Ordena", avancOrdenar);
		fd.append("Substituir", avancSubstituir);
		
		$.ajax({
			url: '/require/php/lp/jpRelatorios.php',
			type: 'POST',
			data: fd,
			processData: false,  // Diga ao jQuery para não processar os dados
			contentType: false,   // Diga jQuery para não definir contentType
			beforeSend: function(){
		        //Aqui adicionas o loader
		        $("#divMensagem").slideDown().html("<center><img src='require/img/projeto/LoaderIcon.gif' /><BR /><h2>CARREGANDO<marquee direction='right'>...</marquee</h2></center>").css({background:'#ECE660'});
		    },
			success:function(data){
				$("#divMensagem").hide();
				window.open('http://srsc-advogado.com.br/arquivos/Destinatarios.pdf', '_blank');
			},
		    error: function(data){
				alert('ERRO');				
			}
		});
	}
	else if($('#tipo1').val()=='1' && $('#tipo2').val()=='1'){
		var quantidade = prompt("Digite a quantidade de etiquetas desejadas:", "");
		if(quantidade == ""){
			quantidade = 1;
		}
		$('#tbGrid').DataTable().clear().draw(false);
		var fd = new FormData();
		fd.append("status", "Remetente");
		fd.append("status2", "gerarPDF");
		fd.append("quantidade", quantidade);
		
		$.ajax({
			url: '/require/php/lp/jpRelatorios.php',
			type: 'POST',
			data: fd,
			processData: false,  // Diga ao jQuery para não processar os dados
			contentType: false,   // Diga jQuery para não definir contentType
			beforeSend: function(){
		        //Aqui adicionas o loader
		        $("#divMensagem").slideDown().html("<center><img src='require/img/projeto/LoaderIcon.gif' /><BR /><h2>CARREGANDO<marquee direction='right'>...</marquee</h2></center>").css({background:'#ECE660'});
		    },
			success:function(data){
				$("#divMensagem").hide();
				window.open('http://srsc-advogado.com.br/arquivos/Remetente.pdf', '_blank');
			},
		    error: function(data){
				alert('ERRO');				
			}
		});
	}
}