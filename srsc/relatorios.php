<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
?>
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="/require/css/relatorios.css" />
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/require/js/funcoes.js"></script>
<script type="text/javascript" src="/require/js/relatorios.js"></script>

<div id="dvMenu">
	<select name="tipo1" id="tipo1">
		<option value="1">MALA DIRETA</option>
	</select>
	<select name="tipo2" id="tipo2">
		<option value="1">REMETENTE</option>
		<option value="2">DESTINATARIO</option>
	</select>
	<button onclick="gerarR()">Gerar Relatório</button>
	<button onclick="gerarPDF()">Gerar PDF</button>
	<input type="checkbox" id="checkboxAvancados" onchange="destinatariosAvancados()">Avançado...</input>
	<div>
		
	</div>
</div>

<div id="dvGrid">
	<table id="tbGrid" align="center" border="1" width="100%">
		<thead>
			<tr>
				<th>NOME</th>
				<th>LOGRADOURO</th>
				<th>NUMERO</th>
				<th>COMPLEMENTO</th>
				<th>BAIRRO</th>
				<th>CIDADE</th>
				<th>ESTADO</th>
				<th>CEP</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>

<div id="divMensagem"></div>

<div id="dvDestinatariosAvancados" class="divform">
	<div class="tdLabel">
		CONSULTA AVANÇADA
		<a href="javascript:fecharAvancado()">X</a>
	</div>
	<fieldset id="Pesquisar">
		<legend>PESQUISAR</legend>
		<div id="dvCampoPesquisar">
			<fieldset id="radio">
				<input type="radio" name="pesquisa" id="pesquisa" value="Inicia">Inicia</input>
				<input type="radio" name="pesquisa" id="pesquisa" value="Contenha">Contenha</input>
				<input type="radio" name="pesquisa" id="pesquisa" value="Termine">Termine</input>
				<input type="radio" name="pesquisa" id="pesquisa" value="Exato">Exato</input>
			</fieldset>
			<input type="checkbox" name="naoPesquisa" id="naoPesquisa" value="Nao">Não</input>
			<select name="localPesquisa" id="localPesquisa">
				<option value=""></option>
				<option value="Nome">NOME</option>
				<option value="Endereco">ENDEREÇO</option>
				<option value="Bairro">BAIRRO</option>
				<option value="Municipio">MUNICIPIO</option>
				<option value="Estado">ESTADO</option>
			</select>
			TEXTO:<input type="text" name="textoPesquisa" id="textoPesquisa" />
		</div>
		<div id="dvButtonPesquisar">
			<button id="buttonAddPesquisar">Adicionar</button>
			<br />
			<button id="buttonRemovePesquisar">Remover</button>
		</div>
		<div id="dvGridPesquisar">
			<table id="tbPesquisar" border="1">
				<thead>
					<tr>
						<th>FORMA</th>
						<th>NEGAÇÃO</th>
						<th>CAMPO</th>
						<th>TEXTO</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</fieldset>
	<fieldset id="Ordenar">
		<legend>ORDENAR</legend>
		<div id="dvCampoOrdenar">
			<fieldset id="radio">
				<input type="radio" name="ordenar" value="Crescente">Crescente</input>
				<input type="radio" name="ordenar" value="Decrescente">Decrescente</input>
			</fieldset>
			<select name="localOrdenar" id="localOrdenar">
				<option value=""></option>
				<option value="Nome">NOME</option>
				<option value="Endereco">ENDEREÇO</option>
				<option value="Bairro">BAIRRO</option>
				<option value="Municipio">MUNICIPIO</option>
				<option value="Estado">ESTADO</option>
			</select>
		</div>
		<div id="dvButtonOrdenar">
			<button id="buttonAddOrdenar">Adicionar</button>
			<br />
			<button id="buttonRemoveOrdenar">Remover</button>
		</div>
		<div id="dvGridOrdenar">
			<table id="tbOrdenar" border="1">
				<thead>
					<tr>
						<th>ORDEM</th>
						<th>CAMPO</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</fieldset>
	<fieldset id="Substitur">
		<legend>
			SUBSTITUIR
		</legend>
		<div id="dvCampoSubstuir">
			<select id="localSubstituir" name="localSubstituir">
				<option value=""></option>
				<option value="Nome">NOME</option>
				<option value="Endereco">ENDEREÇO</option>
				<option value="Bairro">BAIRRO</option>
				<option value="Municipio">MUNICIPIO</option>
				<option value="Estado">ESTADO</option>
			</select>
			<br />
			<label>De:</label><input type="text" id="deSubstituir" name="deSubstituir" />
			<br />
			<label>Para:</label><input type="text" id="paraSubstituir" name="paraSubstituir" />
		</div>
		<div id="dvButtonSubstuir">
			<button id="buttonAddSubstituir">Adicionar</button>
			<br />
			<button id="buttonRemoveSubstituir">Remover</button>
		</div>
		<div id="dvTableSubstuir">
			<table id="tbSubstuir" border="1">
				<thead>
					<tr>
						<th>CAMPO</th>
						<th>DE</th>
						<th>PARA</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</fieldset>
</div>