<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
?>
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="/require/css/fases.css" />
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/require/js/funcoes.js"></script>
<script type="text/javascript" src="/require/js/fases.js"></script>

<div id="grid">
	<?php
		$bd = new DataBase;
		if($queryFases = $bd->selectDB('SELECT f.*,l.nome AS login FROM fases AS f LEFT JOIN login AS l ON f.idlogin=l.idlogin')){
	?>
	<table id="formFases" align="center" border="1" width="100%">
		<thead>
			<tr>
				<th rowspan="2">NOME</th>
				<th rowspan="2">DESCRIÇÃO</th>
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
				<th rowspan="2">DESCRIÇÃO</th>
				<th>POR</th>
				<th>DATA</th>
			</tr>
			<tr>
				<th colspan="2">CADASTRADO</th>
			</tr>
		</tfoot>
		
		<tbody id="conteudoGrid">
			<?php
				foreach($queryFases as $Fases){
			?>
			<tr onclick="exibir('<?=$Fases->idFases;?>')">
				<td><?=$Fases->nome;?></td>
				<td><?=$Fases->descricao;?></td>
				<td><?=$Fases->login.' - '.$Fases->dataCadastro!=' - 0000-00-00'?$Fases->login:"";?></td>
				<td><?=$Fases->login.' - '.$Fases->dataCadastro!=' - 0000-00-00'?date('d/m/Y', strtotime($Fases->dataCadastro)):"";?></td>
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
		<span class="ndEncontrado">Nenhuma Fase Cadastrada</span>
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
		<form action="javascript:void(0)" id="fFases" name="fFases" autocomplete="off">
			<div id='dvCadastro'>
				<label for="cod">Código:</label>
				<input type="text" class="inputCampo inputButton" id="cod" name="cod" placeholder="N&ordm; do Código" disabled />
				<input type="text" class="inputCampo inputButton" id="codoculto" name="codoculto" placeholder="N&ordm; do Código" hidden />
				
				<br />
				
				<label for="nome">Nome:</label>
				<input type="text" class="inputCampo inputButton" id="nome" name="nome" placeholder="Nome" />
				<input type="text" class="inputCampo inputButton" id="nomeAnterior" name="nomeAnterior" placeholder="Nome" hidden />
				
				<br />
				
				<label for="descricao">Descrição:</label>
				<textarea type="text" class="inputCampo inputButton" id="descricao" name="descricao" placeholder="Descrição"></textarea>
				
				<br />
				
				<button class="inputButton button" id="btEnviar" onclick="cadastrar()">Cadastrar</button>
				<button class="inputButton button" id="btLimpar" onclick="limpar()">Limpar</button>
			</div>
		</form>
	</div>
</div>