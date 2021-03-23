<?php
class ControllerGrid{
	private $bd;
	private $query;
	
	public function processo(){
		$this->bd = new DataBase;
		$file = "../../php/grid/processo.txt";
		if(file_exists($file)){
			unlink($file);
		}
		
		$wfp = '{"data":[';
		if($this->query = $this->bd->selectDB('SELECT n_processo,arquivo,DATE_FORMAT(dataArquivo,"%d/%m/%Y") AS "dataArquivo",juizDaSentenca,trtTurma,trtRelator,tstTurma,tstRelator FROM processo')){
			foreach($this->query as $processo){
				$wfp .= '[';
				//PROCESSO
				$wfp .= '"'.$processo->n_processo.'",';
				
				//ARQUIVO & DATA-ARQUIVO
				$wfp .= '"<a href="/require/arquivos/processos/'.$processo->n_processo.'/1.pdf" target="_blank"><img src="/require/img/projeto/pdf.jpg" width="20" height="20" /></a>';
				if($processo->dataArquivo != "00/00/0000"){
					$wfp .= $processo->dataArquivo.'",';
				}
				else{
					$wfp .=	'",';
				}
				
				//JUIZ
				$wfp .= '"'.$processo->juizDaSentenca.'",';
				
				//TRT - TURMA
				$wfp .= '"'.$processo->trtTurma.'",';
				
				//TRT - RELATOR
				$wfp .= '"'.$processo->trtRelator.'",';
				
				//TST - TURMA
				$wfp .= '"'.$processo->tstTurma.'",';
				
				//TST - RELATOR
				$wfp .= '"'.$processo->tstRelator.'",';
				
				//AUTOR
				if($queryPrecesso1 = $this->bd->selectDB('SELECT p.nome, p.cpf AS documento	FROM processo AS pr INNER JOIN autor AS a ON pr.n_processo=a.n_processo INNER JOIN pessoa AS p ON a.cod_pessoa=p.cod_pessoa WHERE pr.n_processo=?',array($processo->n_processo))){
					$autores = '';
					foreach($queryPrecesso1 as $autor){
						$autores .= $autor->nome.'<span hidden>'.$autor->documento.'</span><b>;</b> ';
					}
					$wfp .= '"'.substr($autores,0,-9).'",';
				}
				else{
					$wfp .= '"",';
				}
				
				//ADVOGADOS AUTOR
				if($queryPrecesso1 = $this->bd->selectDB('SELECT DISTINCT ad.nome AS advogado, ad.oab, ad.estado, ad.data_da_expedicao FROM processo AS pr INNER JOIN autor AS a ON pr.n_processo=a.n_processo LEFT JOIN advogado AS ad ON a.cod_advogado=ad.cod_advogado WHERE pr.n_processo=? ',array($processo->n_processo))){
					$advogados ='';
					foreach($queryPrecesso1 as $advogado){
						$advogados .= $advogado->advogado.'<span hidden>'.$advogado->oab.'-'.$advogado->data_da_expedicao.'/'.$advogado->estado.'</span><b>;</b> ';
					}
					$wfp .= '"'.substr($advogados,0,-9).'",';
				}
				else{
					$wfp .= '"",';
				}
				
				//REUS
				if($queryPrecesso1 = $this->bd->selectDB('SELECT e.razao_social, e.cnpj AS documento FROM processo AS pr INNER JOIN reus AS r ON pr.n_processo=r.n_processo INNER JOIN empresa e ON r.cod_empresa=e.cod_empresa WHERE pr.n_processo=?',array($processo->n_processo))){
					$reus='';
					foreach($queryPrecesso1 as $reu){
						$reus .= $reu->razao_social.'<span hidden>'.$autor->documento.'</span><b>;</b> ';
					}
					$wfp .= '"'.substr($reus,0,-9).'",';
				}
				else{
					$wfp .= '"",';
				}
						
				//ADVOGADOS REU
				if($queryPrecesso1 = $this->bd->selectDB('SELECT DISTINCT ad.nome AS advogado, ad.oab, ad.estado, ad.data_da_expedicao FROM processo AS pr	INNER JOIN reus AS a ON pr.n_processo=a.n_processo LEFT JOIN advogado AS ad ON a.cod_advogado=ad.cod_advogado WHERE pr.n_processo=?',array($processo->n_processo))){
					$advogados ='';
					foreach($queryPrecesso1 as $advogado){
						$advogados .= $advogado->advogado.'<span hidden>'.$advogado->oab.'-'.$advogado->data_da_expedicao.'/'.$advogado->estado.'</span><b>;</b> ';
					}
					$wfp .= '"'.substr($advogados,0,-9).'",';
				}
				else{
					$wfp .= '"",';
				}
						
				//FASES
				if($queryPrecesso1 = $this->bd->selectDB('SELECT f.nome FROM processo AS pr INNER JOIN processo_fases AS pf ON pr.n_processo=pf.n_processo INNER JOIN fases AS f ON f.idFases=pf.idFases WHERE pr.n_processo=?',array($processo->n_processo))){
					$fases = '';
					foreach($queryPrecesso1 as $fase){
						$fases .= $fase->nome.'<b>;</b> ';
					}
					$wfp .= '"'.substr($fases,0,-9).'",';
				}
				else{
					$wfp .= '"",';
				}
						
				//MOTIVOS
				if($queryPrecesso1 = $this->bd->selectDB('SELECT m.nome FROM processo AS pr INNER JOIN processo_motivos AS pm ON pr.n_processo=pm.n_processo INNER JOIN motivos AS m ON m.idMotivos=pm.idMotivos WHERE pr.n_processo=?',array($processo->n_processo))){
					$motivos = '';
					foreach($queryPrecesso1 as $motivo){
						$motivos .= $motivo->nome.'<b>;</b> ';
					}
					$wfp .= '"'.substr($motivos,0,-9).'",';
				}
				else{
					$wfp .= '"",';
				}
				
				$wfp .= '],';
			}
		}
		$wfp .= substr($wfp,0,-1);
		$wfp .=']}';
		
		$fp = fopen($file, "a+");
		$escreve = fwrite($fp, $wfp);
		fclose($fp);
	}
}
?>