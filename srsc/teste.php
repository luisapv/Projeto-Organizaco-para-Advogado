<!--
<link type="text/css" rel="stylesheet" href="/require/plugins/jquery/multiple-select/multiple-select.css" />
<script type="text/javascript" src="/require/plugins/jquery/multiple-select/multiple-select.js"></script>
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>

<style type="text/css" rel="stylesheet">
	#selecionaCamposVisiveis{
		-webkit-appearance: none;  /* Remove estilo padrão do Chrome */
		-moz-appearance: none; /* Remove estilo padrão do FireFox */
		appearance: none; /* Remove estilo padrão do FireFox*/
	/*	background: url(http://www.webcis.com.br/images/imagens-noticias/select/ico-seta-appearance.gif) no-repeat #D3D3D3;  /* Imagem de fundo (Seta) */
	/*	background-position: 36.8rem center;  /*Posição da imagem do background*/
		background: #D3D3D3;
		width: 40rem; /* Tamanho do select, maior que o tamanho da div "div-select" */
		height:2.5rem; /* Altura do select, importante para que tenha a mesma altura em todo os navegadores */
		border:1px solid #808080;
		float: right;
		color: #0A246A !important;
		font-weight: bolder !important;
		font-size: 2rem !important;
	}
</style>

<select id="selecionaCamposVisiveis" multiple="multiple">
	<option value="0">PROCESSO</option>
	<option value="8">PROFISSÃO</option>
	<option value="1">PDF</option>
	<option value="9">ADVOGADO (AUTOR)</option>
	<option value="2">JUIZ</option>
	<option value="10">REU</option>
	<option value="3">TRT - TURMA</option>
	<option value="11">ADVOGADO(REU)</option>
	<option value="4">TRT - RELATOR</option>
	<option value="12">FASE</option>
	<option value="5">TST - TURMA</option>
	<option value="13">MATERIA</option>
	<option value="6">TST - RELATOR</option>
	<option value="14">STATUS</option>
	<option value="7">AUTOR</option>
</select>

<br /><br />

<button onclick="GenerateTxtFile()">GetSelect</button>

<script type="text/javascript">
	$('#selecionaCamposVisiveis').multipleSelect({
    	multiple: true,
	    columns: 2,
		multipleWidth: 150,
	    placeholder: 'Colunas para exibir!'
	});
	
	
</script>
-->

<?php
	require_once "require/php/autoload.php";
	$teste = new ControllerProcesso;
	
	var_dump($teste->ControllerXmlProcesso('RelatarConfiguracaoDoCampo','Luis','0,1'));
?>