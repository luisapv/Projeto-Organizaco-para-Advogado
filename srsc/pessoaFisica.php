<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
?>
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="/require/css/pessoaFisica.css" />
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/require/js/funcoes.js"></script>
<script type="text/javascript" src="/require/js/pessoaFisica.js"></script>

<div id="grid">
	<?php
		$bd = new DataBase;
		if($queryPessoaFisica = $bd->selectDB('SELECT p.*, m.sigla, l.nome AS login FROM pessoa AS p LEFT JOIN municipio AS m ON p.municipio=m.cod_municipio LEFT JOIN login AS l ON p.idlogin=l.idlogin')){
	?>
	<table id="formPessaFisica" align="center" border="1" width="100%">
		<thead>
			<tr>
				<th rowspan="2">NOME</th>
				<th rowspan="2">CPF</th>
				<th rowspan="2">PROFISSÃO</th>
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
				<th rowspan="2">NOME</th>
				<th rowspan="2">CPF</th>
				<th rowspan="2">PROFISSÃO</th>
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
				foreach($queryPessoaFisica as $PessoaFisica){
			?>
			<tr onclick="exibir('<?=$PessoaFisica->cpf;?>')">
				<td><?=$PessoaFisica->nome;?></td>
				<td><?=$PessoaFisica->cpf;?></td>
				<td><?=$PessoaFisica->profissao;?></td>
				<td>
					<?php
						echo $PessoaFisica->logradouro.', ';
						
						if (!empty($PessoaFisica->numero))
							echo $PessoaFisica->numero;
							
						if (!empty($PessoaFisica->complemento)){
							if(!empty($PessoaFisica->numero))
								echo ' - '.$PessoaFisica->complemento.',';
							else
								echo $PessoaFisica->complemento.',';
						}
						else{
							echo ', ';
						}
						
						echo $PessoaFisica->bairro.', '.$PessoaFisica->cidade.'\\'.$PessoaFisica->sigla.' - '.$PessoaFisica->cep;
					?>
				</td>
				<td><?=$PessoaFisica->login.' - '.$PessoaFisica->dataCadastro!=' - 0000-00-00'?$PessoaFisica->login:"";?></td>
				<td><?=$PessoaFisica->login.' - '.$PessoaFisica->dataCadastro!=' - 0000-00-00'?date('d/m/Y', strtotime($PessoaFisica->dataCadastro)):"";?></td>
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
		<span class="ndEncontrado">Nenhum Pessoa Física Cadastrado</span>
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
		<form action="javascript:void(0)" id="formPessoaFisica" name="formPessoaFisica" autocomplete="off">
			<div id='dvCadastro'>
				<label for="cod">Código:</label>
				<input type="text" class="inputCampo inputButton" id="cod" name="cod" placeholder="N&ordm; do Código" disabled />
				
				<br />
				
				<label for="nome">Nome:</label>
				<input type="text" class="inputCampo inputButton" id="nome" name="nome" placeholder="Nome" onfocus="fecharAutocomplete()" />
				
				<br />
				
				<label for="identidade">Identidade:</label>
				<input type="text" class="inputCampo inputButton" id="identidade" name="identidade" placeholder="Identidade" onfocus="fecharAutocomplete()" />
				
				<label for="orgao">Órgão:</label>
				<input type="text" class="inputCampo inputButton" id="orgao" name="orgao" placeholder="Órgão" onfocus="fecharAutocomplete()" />
				
				<br />
				
				<label for="cpf">CPF:</label>
				<input type="text" class="inputCampo inputButton" id="cpf" name="cpf" placeholder="CPF" onfocus="fecharAutocomplete()" />
				<input type="text" class="inputCampo inputButton" id="antigocpf" name="antigocpf" placeholder="CPF" hidden />
				
				<br />
				
				<label for="profissao">Profissão:</label>
				<input type="text" class="inputCampo inputButton" id="profissao" name="profissao" placeholder="Profissão"  onkeyup="profissaoKeyUp()" onfocus="fecharAutocomplete()" />
				<ul id="profissao-list" class="autocomplet"></ul>
				
				<br />
				
				<label for="email">E-Mail:</label>
				<input type="text" class="inputCampo inputButton" id="email" name="email" placeholder="E-Mail" onfocus="fecharAutocomplete()" />
				
				<br />
				
				<label for="observacao">Observação:</label>
				<textarea  class="inputCampo inputButton" id="observacao" name="observacao" placeholder="Observação" onfocus="fecharAutocomplete()"></textarea>
				
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
				
				<label for="estado">Estado:</label>
				<select id="estado" name="estado" class="select" onfocus="fecharAutocomplete()">
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