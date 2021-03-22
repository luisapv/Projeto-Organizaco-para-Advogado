<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
?>
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="/require/css/advogado.css" />
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/require/js/funcoes.js"></script>
<script type="text/javascript" src="/require/js/advogado.js"></script>

<div id="grid">
	<?php
		$bd = new DataBase;
		if($queryAdvogado = $bd->selectDB('SELECT a.*, m.sigla, l.nome AS login FROM advogado AS a LEFT JOIN municipio AS m ON a.estado=m.cod_municipio LEFT JOIN login AS l ON a.idlogin=l.idlogin')){
	?>
	<table id="formAdvogado" align="center" border="1" width="100%">
		<thead>
			<tr>
				<th rowspan="2">NOME</th>
				<th rowspan="2">OAB</th>
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
				<th rowspan="2">OAB</th>
				<th>POR</th>
				<th>DATA</th>
			</tr>
			<tr>
				<th colspan="2">CADASTRADO</th>
			</tr>
		</tfoot>
		
		<tbody>
			<?php
				foreach($queryAdvogado as $Advogados){
					$exibir = $Advogados->oab.'//'.$Advogados->estado;
			?>
			<tr onclick="exibir('<?=$exibir;?>')">
				<td><?=$Advogados->nome;?></td>
				<td><?=$Advogados->oab.'\\'.$Advogados->sigla;?></td>
				<td><?=$Advogados->login.' - '.$Advogados->dataCadastro!=' - 0000-00-00'?$Advogados->login:"";?></td>
				<td><?=$Advogados->login.' - '.$Advogados->dataCadastro!=' - 0000-00-00'?date('d/m/Y', strtotime($Advogados->dataCadastro)):"";?></td>
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
		<span class="ndEncontrado">Nenhum Advogado Cadastrado</span>
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
		<form action="javascript:void(0)" id="fAdvogado" name="fAdvogado" autocomplete="off">
			<div id='dvCadastro'>
				<label for="cod">Código:</label>
				<input type="text" class="inputCampo inputButton" id="cod" name="cod" placeholder="N&ordm; do Código" disabled />
				
				<br />
				
				<label for="nome">Nome:</label>
				<input type="text" class="inputCampo inputButton" id="nome" name="nome" placeholder="Nome" />
				
				<br />
				
				<label for="oab">OAB:</label>
				<input type="text" class="inputCampo inputButton" id="oab" name="oab" placeholder="OAB" />
				<input type="text" class="inputCampo inputButton" id="antigooab" name="antigooab" placeholder="OAB" hidden />
				
				<label for="estado">Estado:</label>
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
				<input type="text" class="inputCampo inputButton" id="antigoestado" name="antigoestado" placeholder="OAB" hidden />
				
				<br />
				
				<label for="dataExpedicao">Data Expediçao:</label>
				<input type="date" class="inputCampo inputButton" id="dataExpedicao" name="dataExpedicao" placeholder="Data Expedição" max="<?=date("Y-m-d");?>" />
				
				<br />
				
				<button class="inputButton button" id="btEnviar" onclick="cadastrar()">Cadastrar</button>
				<button class="inputButton button" id="btLimpar" onclick="limpar()">Limpar</button>
			</div>
		</form>
	</div>
</div>