<?php
	require_once("..\autoload.php");
	$bd = new DataBase;
	if($queryPrecesso = $bd->selectDB('SELECT pr.n_processo,pr.arquivo,DATE_FORMAT(pr.dataArquivo,"%d/%m/%Y") AS "dataArquivo",pr.juizDaSentenca,pr.trtTurma,pr.trtRelator,pr.tstTurma,pr.tstRelator, status,
	(SELECT GROUP_CONCAT(CONCAT(p.nome," <span hidden>(",p.cpf," - ",CASE WHEN p.profissao IS NULL OR p.profissao=\'\' THEN \'\' ELSE p.profissao END,")</span>")) FROM autor AS a INNER JOIN pessoa AS p ON a.cod_pessoa=p.cod_pessoa WHERE a.n_processo=pr.n_processo) AS "Autor",
	(SELECT GROUP_CONCAT(CONCAT(p.nome," <span hidden>(",p.oab,"/",m.sigla,")</span>")) FROM autor AS a INNER JOIN advogado AS p ON a.cod_advogado=p.cod_advogado LEFT JOIN municipio AS m ON p.estado=m.cod_municipio WHERE a.n_processo=pr.n_processo) AS "AdvAutor",
	(SELECT GROUP_CONCAT(CONCAT(p.razao_social," <span hidden>(",p.cnpj,")</span>")) FROM reus AS a INNER JOIN empresa AS p ON a.cod_empresa=p.cod_empresa WHERE a.n_processo=pr.n_processo) AS "Reu",
	(SELECT GROUP_CONCAT(CONCAT(p.nome," <span hidden>(",p.oab,"/",m.sigla,")</span>")) FROM reus a INNER JOIN advogado AS p ON a.cod_advogado=p.cod_advogado LEFT JOIN municipio AS m ON p.estado=m.cod_municipio WHERE a.n_processo=pr.n_processo) AS "AdvReus",
	(SELECT GROUP_CONCAT(p.nome) FROM processo_fases AS a INNER JOIN fases AS p ON a.idFases=p.idFases WHERE a.n_processo=pr.n_processo) AS "Fases",
	(SELECT GROUP_CONCAT(p.nome) FROM processo_motivos AS a INNER JOIN motivos AS p ON a.idMotivos=p.idMotivos WHERE a.n_processo=pr.n_processo) AS "Motivos"
	FROM processo AS pr')){
		foreach($queryPrecesso as $processo){
?>
	<tr onclick="exibir('<?=$processo->n_processo;?>')">
		<td><?=$processo->n_processo;?></td>
		<td align="center">
		<?php
			if ($processo->arquivo==1){
		?>
			<a href="javascript:void(0)" onclick="abrirPDF('<?=$processo->n_processo;?>')">
				<img src="/require/img/projeto/pdf.jpg" width="20" height="20" />
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
		<td hidden><?=$processo->juizDaSentenca;?></td>
		<td hidden><?=$processo->trtTurma>0?$processo->trtTurma:'';?></td>
		<td hidden><?=$processo->trtRelator;?></td>
		<td hidden><?=$processo->tstTurma>0?$processo->tstTurma:'';?></td>
		<td hidden><?=$processo->tstRelator;?></td>
		<td><?=str_replace(",","<b>;</b> ",$processo->Autor);?></td>
		<td hidden><?=str_replace(",","<b>;</b> ",$processo->AdvAutor);?></td>
		<td><?=str_replace(",","<b>;</b> ",$processo->Reu);?></td>
		<td hidden><?=str_replace(",","<b>;</b> ",$processo->AdvReus);?></td>
		<td><?=str_replace(",","<b>;</b> ",$processo->Fases);?></td>
		<td><?=str_replace(",","<b>;</b> ",$processo->Motivos);?></td>
		<td hidden><?=$processo->status==1?'ATIVO':'INATIVO';?></td>
	</tr>
<?php
		}
	}
	else{
		echo '<td colspan="14"><span class="ndEncontrado">Nenhum PROCESSO Cadastrado</span></td>';
	}
?>