<?php
	require_once"../autoload.php";
	$criarEtiquetas = new ControllerCriarEtiquetas;
 
	extract($_POST);
	extract($_FILES);
//	$status='Destinario';
//	$status2='gerarR';
//	$Pesquisa = "";
//	$Ordena = "";
//	$Substituir = "";
//	$Pesquisa = "Inicia,,Nome,A;Exato,,Municipio,DUQUE DE CAXIAS";
//	$Ordena = "Crescente,Nome";
//	$Substituir = "";

//	$status = "Remetente";
//	$status2 = "gerarPDF";
//	$quantidade = 5;
 
	if($status=='Destinario'){
		if($status2=='gerarR'){
			print $criarEtiquetas->gerarGrid(gerarSQLDestinatario($Pesquisa, $Ordena, $Substituir));
//			print gerarSQLDestinatario($Pesquisa, $Ordena, $Substituir);
		}
		elseif($status2=='gerarPDF'){
			print $criarEtiquetas->gerarEtiquetasPDF(gerarSQLDestinatario($Pesquisa, $Ordena, $Substituir),0);
		}
	}
 
	elseif($status=='Remetente'){
		if($status2=='gerarR'){
			print $criarEtiquetas->gerarGrid(gerarSQLRemetente($quantidade));
		}
		elseif($status2=='gerarPDF'){
			print $criarEtiquetas->gerarEtiquetasPDF(gerarSQLRemetente(),$quantidade);
		}
	}
 
	function gerarSQLDestinatario($Pesquisa=NULL, $Ordena=NULL, $Substituir=NULL){
		$sql = "SELECT ";
 
		if($Substituir!='' && $Substituir!=NULL){
			$nome		= 'p.nome';
			$endereco	= "p.logradouro";
			$bairro		= "p.bairro";
			$municipio	= "p.cidade";
			$estado		= "m.sigla";
			$Substituirmos=explode(';',$Substituir);
			foreach($Substituirmos as $values){
				$value = explode(',',$values);
				if($value[0]!="" && $value[0]!=NULL){
					if($value[0]=='Nome'){
						$nome = 'replace('.$nome.',"'.$value[1].'","'.$value[2].'")';
					}
					elseif($value[0]=='Endereco'){
						$endereco = 'replace('.$endereco.',"'.$value[1].'","'.$value[2].'")';
					}
					elseif($value[0]=='Bairro'){
						$bairro = 'replace('.$bairro.',"'.$value[1].'","'.$value[2].'")';
					}
					elseif($value[0]=='Municipio'){
						$municipio = 'replace('.$municipio.',"'.$value[1].'","'.$value[2].'")';
					}
					elseif($value[0]=='Estado'){
						$estado = 'replace('.$estado.',"'.$value[1].'","'.$value[2].'")';
					}
				}
			}
			$sql .= $nome.' AS nome, '.$endereco.' AS logradouro, numero, complemento, '.$bairro.' AS bairro, '.$municipio.' AS cidade, '.$estado.' AS sigla, p.cep FROM pessoa AS p INNER JOIN municipio AS m ON p.municipio=m.cod_municipio ';
		}
		else{
			$sql .= 'p.nome, p.logradouro, numero, complemento, p.bairro, p.cidade, m.sigla, p.cep FROM pessoa AS p INNER JOIN municipio AS m ON p.municipio=m.cod_municipio ';
		}
 
		if($Pesquisa!="" && $Pesquisa!=NULL){
			$pesquisar = "";
			$x = 0;
			$Pesquisas = explode(';',$Pesquisa);
			foreach($Pesquisas as $values){
				$value = explode(',',$values);
				if($value[2]!="" && $value[2]!=NULL){
					if($x>0 && $x<count($Pesquisas)){
						$pesquisar .= ' AND ';
					}
					if($value[2]=='Nome'){
						if($value[0]=='Inicia'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.nome NOT LIKE "'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.nome LIKE "'.$value[3].'%" ';
							}
						}
						elseif($value[0]=='Contenha'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.nome NOT LIKE "%'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.nome LIKE "%'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Termine'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.nome NOT LIKE "%'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.nome LIKE "%'.$value[3].'"';
							}
						}
						elseif($value[0]=='Exato'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.nome!="'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.nome="'.$value[3].'"';
							}
						}
					}
					elseif($value[2]=='Endereco'){
						if($value[0]=='Inicia'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.logradouro NOT LIKE "'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.logradouro LIKE "'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Contenha'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.logradouro NOT LIKE "%'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.logradouro LIKE "%'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Termine'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.logradouro NOT LIKE "%'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.logradouro LIKE "%'.$value[3].'"';
							}
						}
						elseif($value[0]=='Exato'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.logradouro!="'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.logradouro="'.$value[3].'"';
							}
						}
					}
					elseif($value[2]=='Bairro'){
						if($value[0]=='Inicia'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.bairro NOT LIKE "'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.bairro LIKE "'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Contenha'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.bairro NOT LIKE "%'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.bairro LIKE "%'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Termine'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.bairro NOT LIKE "%'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.bairro LIKE "%'.$value[3].'"';
							}
						}
						elseif($value[0]=='Exato'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.bairro!="'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.bairro="'.$value[3].'"';
							}
						}
					}
					elseif($value[2]=='Municipio'){
						if($value[0]=='Inicia'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.cidade NOT LIKE "'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.cidade LIKE "'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Contenha'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.cidade NOT LIKE "%'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.cidade LIKE "%'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Termine'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.cidade NOT LIKE "%'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.cidade LIKE "%'.$value[3].'"';
							}
						}
						elseif($value[0]=='Exato'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.cidade!="'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.cidade="'.$value[3].'"';
							}
						}
					}
					elseif($value[2]=='Estado'){
						if($value[0]=='Inicia'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.municipio NOT LIKE "'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.municipio LIKE "'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Contenha'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.municipio NOT LIKE "%'.$value[3].'%"';
							}
							else{
								$pesquisar .= 'p.municipio LIKE "%'.$value[3].'%"';
							}
						}
						elseif($value[0]=='Termine'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.municipio NOT LIKE "%'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.municipio LIKE "%'.$value[3].'"';
							}
						}
						elseif($value[0]=='Exato'){
							if($value[1]=='Nao'){
								$pesquisar .= 'p.municipio!="'.$value[3].'"';
							}
							else{
								$pesquisar .= 'p.municipio="'.$value[3].'"';
							}
						}
					}
					$x++;
				}
			}
 
			if($pesquisar!=''){
				$sql .= 'WHERE '.$pesquisar;
			}
		}
 
		if($Ordena!='' && $Ordena!=NULL){
			$Ordenas = explode(';',$Ordena);
			$x=0;
			$ordem = '';
			foreach($Ordenas as $values){
				$value = explode(',',$values);
				if($value[1]!="" && $value[1]!=NULL){
					if($x>0 && $x<count($Ordenas)){
						$ordem .= ', ';
					}
					if($value[1]=='Nome'){
						if($value[0]=='Crescente'){
							$ordem .= 'p.nome';
						}
						elseif($value[0]=='Decrescente'){
							$ordem .= 'p.nome DESC';
						}
					}
					elseif($value[1]=='Endereco'){
						if($value[0]=='Crescente'){
							$ordem .= 'p.logradouro';
						}
						elseif($value[0]=='Decrescente'){
							$ordem .= 'p.logradouro DESC';
						}
					}
					elseif($value[1]=='Bairro'){
						if($value[0]=='Crescente'){
							$ordem .= 'p.bairro';
 
						}
						elseif($value[0]=='Decrescente'){
							$ordem .= 'p.bairro DESC';
						}
					}
					elseif($value[1]=='Municipio'){
						if($value[0]=='Crescente'){
							$ordem .= 'p.cidade';
						}
						elseif($value[0]=='Decrescente'){
							$ordem .= 'p.cidade DESC';
						}
					}
					elseif($value[1]=='Estado'){
						if($value[0]=='Crescente'){
							$ordem .= 'p.estado';
						}
						elseif($value[0]=='Decrescente'){
							$ordem .= 'p.estado DESC';
						}
					}
					$x++;
				}
			}
			if($ordem!=''){
				$sql .= ' ORDER BY '.$ordem;
			}
		}
		return $sql;
	}
	
	function gerarSQLRemetente($quant=NULL){
		$sql = 	'SELECT ae.pessoa AS nome, l.nome AS logradouro, en.numero, en.complemento, b.nome AS bairro, ct.nome AS cidade, m.sigla, c.cep FROM aempresa AS ae INNER JOIN endereco AS en ON ae.cod_endereco=en.cod_endereco INNER JOIN cep AS c ON en.cod_cep=c.cod_cep INNER JOIN logradouro AS l ON c.cod_logradouro=l.cod_logradouro INNER JOIN bairro AS b ON c.cod_bairro=b.cod_bairro INNER JOIN cidade AS ct ON c.cod_cidade=ct.cod_cidade INNER JOIN municipio AS m ON c.cod_municipio=m.cod_municipio';
		return $sql;
	}
?>