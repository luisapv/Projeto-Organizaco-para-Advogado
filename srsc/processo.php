<?php
	if(!isset($_SESSION['logado'])){
		header('location:login');
	}
	$bd = new DataBase;
?>
<link type="text/css" rel="stylesheet" href="/require/plugins/jquery/multiple-select/multiple-select.css" />
<script type="text/javascript" src="/require/plugins/jquery/multiple-select/multiple-select.js"></script>
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="/require/css/processo.css" />
<script type="text/javascript" src="/require/plugins/dataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/require/js/funcoes.js"></script>
<script type="text/javascript" src="/require/js/processo.js"></script>
<div id="dvColumnGrid">
	<select id="selecionaCamposVisiveis" multiple="multiple">
		<option value="0">PROCESSO</option>
		<option value="9">ADVOGADO (AUTOR)</option>
		<option value="1">PDF</option>
		<option value="10">REU</option>
		<option value="2">JUIZ</option>
		<option value="11">ADVOGADO(REU)</option>
		<option value="3">TRT - TURMA</option>
		<option value="12">FASE</option>
		<option value="4">TRT - RELATOR</option>
		<option value="13">MATERIA</option>
		<option value="5">TST - TURMA</option>
		<option value="14">STATUS</option>
		<option value="6">TST - RELATOR</option>
		<option value="15">CADASTRADO POR</option>
		<option value="7">AUTOR</option>
		<option value="16">CADASTRADO DATA</option>
		<option value="8">PROFISSÃO</option>
	</select>
</div>
<div id="grid">
	<?php
		if($queryPrecesso = $bd->selectDB('SELECT pr.n_processo,pr.arquivo,DATE_FORMAT(pr.dataArquivo,"%d/%m/%Y") AS "dataArquivo",pr.juizDaSentenca,pr.trtTurma,pr.trtRelator,pr.tstTurma,pr.tstRelator, status, DATE_FORMAT(pr.dataCadastro,"%d/%m/%Y") AS "dataCadastro", l.nome AS login,
(SELECT GROUP_CONCAT(CONCAT(p.nome," <span hidden>(",p.cpf,")</span>")) FROM autor AS a INNER JOIN pessoa AS p ON a.cod_pessoa=p.cod_pessoa WHERE a.n_processo=pr.n_processo) AS "Autor",
(SELECT GROUP_CONCAT(p.profissao) FROM autor AS a INNER JOIN pessoa AS p ON a.cod_pessoa=p.cod_pessoa WHERE a.n_processo=pr.n_processo) AS "Profissao",
(SELECT GROUP_CONCAT(CONCAT(p.nome," <span hidden>(",p.oab,"/",m.sigla,")</span>")) FROM autor AS a INNER JOIN advogado AS p ON a.cod_advogado=p.cod_advogado LEFT JOIN municipio AS m ON p.estado=m.cod_municipio WHERE a.n_processo=pr.n_processo) AS "AdvAutor",
(SELECT GROUP_CONCAT(CONCAT(p.razao_social," <span hidden>(",p.cnpj,")</span>")) FROM reus AS a INNER JOIN empresa AS p ON a.cod_empresa=p.cod_empresa WHERE a.n_processo=pr.n_processo) AS "Reu",
(SELECT GROUP_CONCAT(CONCAT(p.nome," <span hidden>(",p.oab,"/",m.sigla,")</span>")) FROM reus a INNER JOIN advogado AS p ON a.cod_advogado=p.cod_advogado LEFT JOIN municipio AS m ON p.estado=m.cod_municipio WHERE a.n_processo=pr.n_processo) AS "AdvReus",
(SELECT GROUP_CONCAT(p.nome) FROM processo_fases AS a INNER JOIN fases AS p ON a.idFases=p.idFases WHERE a.n_processo=pr.n_processo) AS "Fases",
(SELECT GROUP_CONCAT(p.nome) FROM processo_motivos AS a INNER JOIN motivos AS p ON a.idMotivos=p.idMotivos WHERE a.n_processo=pr.n_processo) AS "Motivos"
FROM processo AS pr LEFT JOIN login AS l ON pr.idlogin=l.idlogin')){
	?>
	<table id="tbProcessoGrid" align="center" border="1" width="100%">
		<thead>
			<tr>
				<th rowspan="2">PROCESSO</th>
				<th rowspan="2">PDF</th>
				<th rowspan="2">JUIZ</th>
				<th colspan="2">TRT</th>
				<th colspan="2">TST</th>
				<th rowspan="2">AUTOR</th>
				<th rowspan="2">PROFISSÃO</th>
				<th rowspan="2">ADVOGADO</th>
				<th rowspan="2">REU</th>
				<th rowspan="2">ADVOGADO</th>
				<th rowspan="2">FASE</th>
				<th rowspan="2">MATERIA</th>
				<th rowspan="2">STATUS</th>
				<th colspan="2">CADASTRADO</th>
			</tr>
			<tr>
				<th>TURMA</th>
				<th>RELATOR</th>
				<th>TURMA</th>
				<th>RELATOR</th>
				<th>POR</th>
				<th>DATA</th>
			</tr>
		</thead>
		
		<tfoot>
			<tr>
				<th rowspan="2">PROCESSO</th>
				<th rowspan="2">PDF</th>
				<th rowspan="2">JUIZ</th>
				<th>TURMA</th>
				<th>RELATOR</th>
				<th>TURMA</th>
				<th>RELATOR</th>
				<th rowspan="2">AUTOR</th>
				<th rowspan="2">PROFISSÃO</th>
				<th rowspan="2">ADVOGADO</th>
				<th rowspan="2">REU</th>
				<th rowspan="2">ADVOGADO</th>
				<th rowspan="2">FASE</th>
				<th rowspan="2">MATERIA</th>
				<th rowspan="2">STATUS</th>
				<th>POR</th>
				<th>DATA</th>
			</tr>
			<tr>
				<th colspan="2">TRT</th>
				<th colspan="2">TST</th>
				<th colspan="2">CADASTRADO</th>
			</tr>
		</tfoot>
		
		<tbody>
			<?php
				foreach($queryPrecesso as $processo){
			?>
			<tr onclick="exibir('<?=$processo->n_processo;?>')">
				<td><?=$processo->n_processo;?></td>
				<td align="center">
				<?php
					if ($processo->arquivo==1){
				?>
					<a href="javascript:void(0)" onclick="abrirPDF('<?=$processo->n_processo;?>')">
						<img src="/require<?=IMG_PROJETOS;?>pdf.jpg" width="20" height="20" />
					</a>
					<br />
					<?php
						if($processo->dataArquivo!='00/00/0000')
							echo $processo->dataArquivo;
					?>
				<?php
					}
				?>
				</td>
				<td><?=$processo->juizDaSentenca;?></td>
				<td><?=$processo->trtTurma>0?$processo->trtTurma:'';?></td>
				<td><?=$processo->trtRelator;?></td>
				<td><?=$processo->tstTurma>0?$processo->tstTurma:'';?></td>
				<td><?=$processo->tstRelator;?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->Autor);?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->Profissao);?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->AdvAutor);?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->Reu);?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->AdvReus);?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->Fases);?></td>
				<td><?=str_replace(",","<b>;</b> ",$processo->Motivos);?></td>
				<td><?=$processo->status==1?'ATIVO':'INATIVO';?></td>
				<td><?=$processo->login.' - '.$processo->dataCadastro!=' - 00/00/0000'?$processo->login:"";?></td>
				<td><?=$processo->login.' - '.$processo->dataCadastro!=' - 00/00/0000'?$processo->dataCadastro:"";?></td>
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
		<span class="ndEncontrado">Nenhum PROCESSO Cadastrado</span>
	<?php
		}
	?>
</div>

<div id="divform" hidden>
	<div id="fechar" align=right>
		<nav>
			<ul>
				<li><a href="javascript:editar('#antigoProcesso')" id="linkEditar">EDITAR</a></li>
				<li><a href="javascript:apagar()" id="linkApagar">APAGAR</a></li>
				<li><a href="javascript:fecharDivForm()" id="linkFechar">FECHAR</a></li>
			</ul>
		</nav>
	</div>
	<div>
	<span class="msg-form"></span>
		<form action="javascript:void(0)" id="formProcesso" autocomplete="off">
			<label for="procsso">Nº Processo:</label>
			<input type="text" class="inputCampo inputButton" id="processo" name="processo" placeholder="Nº do Processo" onfocus="fecharAutocomplete()" />
			<input type="text" class="inputCampo inputButton" id="antigoProcesso" name="antigoProcesso" placeholder="Nº do Processo" hidden />
			
			<br />
			
			<label for="arquivo">PDF:</label>
			<input type="file" class="inputCampo inputButton" id="arquivo" name="arquivo" placeholder="PDF" onfocus="fecharAutocomplete()" />
			<span id="spanPDF" hidden>
				<a href="javascript:void(0)" onclick="abrirPDF('<?=$processo->n_processo;?>')" id="editarArquivo">
					<img src="/require<?=IMG_PROJETOS;?>pdf.jpg" width="20" height="20" />
				</a>
				<label id="editarLabelArquivo"></label>
			</span>
			
			<br />
			
			<label for="juiz">Juiz:</label>
			<input type="text" class="inputCampo inputButton" id="juiz" name="juiz" placeholder="JUIZ" onkeyup="juizKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="juiz-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="trtTurma">TRT - Turma:</label>
			<input type="number" class="inputCampo inputButton" id="trtTurma" name="trtTurma" placeholder="TRT - TURMA" onfocus="fecharAutocomplete()" />
			<label for="trtRelator">TRT - Relator:</label>
			<input type="text" class="inputCampo inputButton" id="trtRelator" name="trtRelator" placeholder="TRT - RELATOR" onkeyup="trtRelatorKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="trtRelator-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="tstTurma">TST - Turma:</label>
			<input type="number" class="inputCampo inputButton" id="tstTurma" name="tstTurma" placeholder="TST - TURMA" onfocus="fecharAutocomplete()" />
			<label for="tstRelator">TST - Relator:</label>
			<input type="text" class="inputCampo inputButton" id="tstRelator" name="tstRelator" placeholder="TST - RELATOR" onkeyup="tstRelatorKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="tstRelator-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="autor">Autor:</label>
			<input type="text" class="inputCampo inputButton" id="autor" name="autor" placeholder="AUTOR" onkeyup="autorKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="autor-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="advogadoA">Advogado:</label>
			<input type="text" class="inputCampo inputButton" id="advogadoA" name="advogadoA" placeholder="ADVOGADO" onkeyup="advogadoAKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="advogadoA-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="reu">Reu:</label>
			<input type="text" class="inputCampo inputButton" id="reu" name="reu" placeholder="REU" onkeyup="reuKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="reu-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="advogadoR">Advogado:</label>
			<input type="text" class="inputCampo inputButton" id="advogadoR" name="advogadoR" placeholder="ADVOGADO" onkeyup="advogadoRKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="advogadoR-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="fase">Fases:</label>
			<input type="text" class="inputCampo inputButton" id="fase" name="fase" placeholder="FASE" onkeyup="fasesKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="fase-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="motivo">Materia:</label>
			<input type="text" class="inputCampo inputButton" id="motivo" name="motivo" placeholder="MATERIA" onkeyup="motivosKeyUp()" onfocus="fecharAutocomplete()" />
			<ul id="motivo-list" class="autocomplet"></ul>
			
			<br />
			
			<label for="statu">Status:</label>
			<select id="statu" name="statu" class="select" onfocus="fecharAutocomplete()">
				<option value="">SELECIONE</option>
				<option value="1">ATIVO</option>
				<option value="0">INATIVO</option>
			</select>
			
			<br />
			
			<button class="inputButton button" id="btEnviar" onclick="cadastrar()">Cadastrar</button>
			<button class="inputButton button" id="btLimpar" onclick="limpar()">Limpar</button>
		</form>
	</div>
</div>