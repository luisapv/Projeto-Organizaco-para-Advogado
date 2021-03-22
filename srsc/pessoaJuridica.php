<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
?>
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="/require/css/pessoaJuridica.css" />
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/require/js/funcoes.js"></script>
<script type="text/javascript" src="/require/js/pessoaJuridica.js"></script>

<div id="grid">
	<?php
		$bd = new DataBase;
		if($queryPessoaJuridica = $bd->selectDB('SELECT e.*, m.sigla, l.nome AS login FROM empresa AS e LEFT JOIN municipio AS m ON e.municipio=m.cod_municipio LEFT JOIN login AS l ON e.idlogin=l.idlogin')){
	?>
	<table id="formPessaJuridica" align="center" border="1" width="100%">
		<thead>
			<tr>
				<th rowspan="2">RAZÃO SOICIAL</th>
				<th rowspan="2">CNPJ</th>
				<th rowspan="2">ENDEREÇO</th>
				<th colspan="2">CADASTRADO</th>
			</tr>
			<tr>
				<th>POR</th>
				<th>DATA</th>
			</tr>
		</thead>
		
		<tfoot>
			<tr>
				<th rowspan="2">RAZÃO SOICIAL</th>
				<th rowspan="2">CNPJ</th>
				<th rowspan="2">ENDEREÇO</th>
				<th>POR</th>
				<th>DATA</th>
			</tr>
			<tr>
				<th colspan="2">CADASTRADO</th>
			</tr>
		</tfoot>
		
		<tbody>
			<?php
				foreach($queryPessoaJuridica as $pessoaJuridica){
			?>
			<tr onclick="exibir('<?=$pessoaJuridica->cnpj;?>')">
				<td><?=$pessoaJuridica->razao_social;?></td>
				<td><?=$pessoaJuridica->cnpj;?></td>
				<td>
					<?php
						echo $pessoaJuridica->logradouro.', ';
						
						if (!empty($pessoaJuridica->numero))
							echo $pessoaJuridica->numero;
							
						if (!empty($pessoaJuridica->complemento)){
							if(!empty($pessoaJuridica->numero))
								echo ' - '.$pessoaJuridica->complemento.',';
							else
								echo $pessoaJuridica->complemento.',';
						}
						else{
							echo ', ';
						}
						
						echo $pessoaJuridica->bairro.', '.$pessoaJuridica->cidade.'\\'.$pessoaJuridica->sigla.' - '.$pessoaJuridica->cep;
					?>
				</td>
				<td><?=$pessoaJuridica->login.' - '.$pessoaJuridica->dataCadastro!=' - 0000-00-00'?$pessoaJuridica->login:"";?></td>
				<td><?=$pessoaJuridica->login.' - '.$pessoaJuridica->dataCadastro!=' - 0000-00-00'?date('d/m/Y', strtotime($pessoaJuridica->dataCadastro)):"";?></td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	<?php
		}
		else{
	?>
		<span class="ndEncontrado">Nenhum Pessoa Jurídica Cadastrado</span>
	<?php
		}
	?>
</div>

<div id="divform" hidden>
	<div id="fechar" align=right>
		<nav>
			<ul>
				<li><a href="javascript:editar()" id="linkEditar">EDITAR</a></li>
				<li><a href="javascript:apagar()" id="linkApagar">APAGAR</a></li>
				<li><a href="javascript:fecharDivForm()" id="linkFechar">FECHAR</a></li>
			</ul>
		</nav>
	</div>
	<div>
		<span class="msg-form"></span>
		<form action="javascript:void(0)" id="formPessoaJuridica" name="formPessoaJuridica" autocomplete="off">
			<div id='dvCadastro'>
				<label for="cod">C&oacute;digo:</label>
				<input type="text" class="inputCampo inputButton" id="cod" name="cod" placeholder="N&ordm; do C&oacute;digo" disabled />
				
				<br />
				
				<label for="razaoSocial">Raz&atilde;o Social:</label>
				<input type="text" class="inputCampo inputButton" id="razaoSocial" name="razaoSocial" placeholder="Raz&atilde;o Social" />
				
				<br />
				
				<label for="nomeFantasia">Nome Fantasia:</label>
				<input type="text" class="inputCampo inputButton" id="nomeFantasia" name="nomeFantasia" placeholder="Nome Fantasia" />
				
				<br />
				
				<label for="cnpj">CNPJ:</label>
				<input type="text" class="inputCampo inputButton" id="cnpj" name="cnpj" placeholder="CNPJ" />
				<input type="text" class="inputCampo inputButton" id="antigocnpj" name="antigocnpj" placeholder="CNPJ" hidden />
				
				<br />
				
				<label for="pessoaResponsavel">Pessoa Responsavel:</label>
				<input type="text" class="inputCampo inputButton" id="pessoaResponsavel" name="pessoaResponsavel" placeholder="Pessoa Responsavel" />
				
				<br />
				
				<label for="email">E-Mail:</label>
				<input type="text" class="inputCampo inputButton" id="email" name="email" placeholder="E-Mail" />
				
				<br />
				
				<label for="observacao">Observação:</label>
				<textarea  class="inputCampo inputButton" id="observacao" name="observacao" placeholder="Observação"></textarea>
				
				<br />
				
				<label for="endereco">Endereço:</label>
				<textarea  class="inputCampo inputButton" id="endereco" name="endereco" placeholder="Endereço" onclick="exibirEndereco()" onfocus="exibirEndereco()"></textarea>
				
				<br />
				
				<button class="inputButton button" id="btEnviar" onclick="cadastrar()">Cadastrar</button>
				<button class="inputButton button" id="btLimpar" onclick="limpar()">Limpar</button>
			</div>
			<div id='dvEndereco' hidden>
				<label for="cep">CEP:</label>
				<input type="text" class="inputCampo inputButton" id="cep" name="cep" placeholder="CEP" onkeyup="cepKeyUp()" onfocus="fecharAutocomplete()" />
				<ul id="cep-list" class="autocomplet"></ul>
				
				<br />
				
				<label for="logradouro">Logradouro:</label>
				<input type="text" class="inputCampo inputButton" id="logradouro" name="logradouro" placeholder="Logradouro" onkeyup="logradouroKeyUp()" onfocus="fecharAutocomplete()" />
				<ul id="logradouro-list" class="autocomplet"></ul>
				
				<br />
				
				<label for="numero">Número:</label>
				<input type="text" class="inputCampo inputButton" id="numero" name="numero" placeholder="Número" onfocus="fecharAutocomplete()" />
				
				<label for="Complemento">Complemento:</label>
				<input type="text" class="inputCampo inputButton" id="complemento" name="complemento" placeholder="Compleento" onfocus="fecharAutocomplete()" />
				
				<br />
				
				<label for="bairro">Bairro:</label>
				<input type="text" class="inputCampo inputButton" id="bairro" name="bairro" placeholder="Bairro"  onkeyup="bairroKeyUp()" onfocus="fecharAutocomplete()" />
				<ul id="bairro-list" class="autocomplet"></ul>
				
				<br />
				
				<label for="municipio">Municipio:</label>
				<input type="text" class="inputCampo inputButton" id="municipio" name="municipio" placeholder="Municipio"  onkeyup="municipioKeyUp()" onfocus="fecharAutocomplete()" />
				<ul id="municipio-list" class="autocomplet"></ul>
				
				<label for="estado" onfocus="fecharAutocomplete()">Estado:</label>
				<select id="estado" name="estado" class="select">
					<option value="">SELECIONE</option>
					<?php
						if($query = $bd->selectDB('SELECT * FROM municipio ORDER BY sigla')){
							foreach($query as $estado){
								echo '<option value="'.$estado->cod_municipio.'">'.$estado->sigla.'</option>';	
							}
						}
					?>
				</select>
				
				<br />
			</div>
		</form>
	</div>
</div>