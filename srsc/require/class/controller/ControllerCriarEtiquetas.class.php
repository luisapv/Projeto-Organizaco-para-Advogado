<?php
class ControllerCriarEtiquetas{
	private $bd;
	private $query;
	
	public function gerarEtiquetasPDF($sql,$quant){
		$this->bd = new DataBase;
		
//		$sql = gerarSQLDestinatario($Pesquisa, $Ordena, $Substituir);
		
		$this->query = $this->bd->selectDB($sql);
		if($quant==0){
			$reg = $this->bd->quantSelectDB($sql);
		}
		elseif($quant>0){
			$reg = $quant;
		}
	//Variaveis de Tamanho
		// Margem Esquerda (mm)
		$margemEsquerda = "3.95";
		// Margem Direita (mm)
		$margemDireita = "3.95";
		// Margem Superior (mm)
		$margemTopo = "12.7";
		// Margem Inferior (mm)
		$margemFooter = "12.7";
		// Largura da Etiqueta (mm)
		$larguraEtiqueta = "101.59";
		// Altura da Etiqueta (mm)
		$alturaEtiqueta = "25.4";
		// Espaço horizontal entre as Etiquetas (mm)
		$espacoHorizontalEtiqueta = "0";
		// Espaço vertical entre as Etiquetas (mm)
		$espacoVerticalEtiqueta = "4.76";
		
		// Cria um arquivo novo tipo carta, na vertical.
		$pdf=new TCPDF('P','mm',array(215.9,279.4),TRUE,'UTF-8',FALSE,FALSE);
		// Remover Cabeçalho
		$pdf->SetPrintHeader(false);
		// Remover Rodapé
		$pdf->SetPrintFooter(false);
		// Adicionar margens Esqueda, Topo, Direita
		$pdf->SetMargins($margemEsquerda, $margemTopo, $margemDireita, TRUE);
		// Margem de baixo.
		$pdf->SetFooterMargin($margemFooter);
		// Define o autor
		$pdf->SetAuthor("SRSC-Advogado");
		// Define a fonte
		$pdf->SetFont('Times','',10,'',FALSE,TRUE);
		//Adicinei uma fullpage
		$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');
		// Definir espaçamento interno das celulas.
		$pdf->setCellPaddings('2','','2','');
		// adiciona a primeira pagina
		$pdf->AddPage();
		
		$coluna = 0;
		$linha = 0;
		
		//MONTA A ARRAY PARA ETIQUETAS
		if($quant==0){
			foreach($this->query as $dados){
				$titulo = "DESTINATARIO:";
				$nome = $dados->nome;
				$ende = $dados->logradouro;
				if($dados->numero!='' && $dados->complemento!=''){
					$end = $dados->numero.' - '.$dados->complemento;
				}
				elseif($dados->numero!='' && $dados->complemento==''){
					$end = $dados->numero;
				}
				elseif($dados->numero=='' && $dados->complemento!=''){
					$end = $dados->complemento;
				}

				$bairro = $dados->bairro;
				$estado = $dados->cidade;
				$cida = $dados->sigla;
				$local = $bairro." - ".$estado." - ".$cida;
				$cep = $dados->cep;
				
				if($linha == '10'){
					$pdf->AddPage();
					$linha = 0;
				}
				
				// Se for a terceira coluna
				if($coluna == '2'){
					// $coluna volta para o valor inicial
					$coluna = 0;
					// $linha é igual ela mesma +1
					$linha++; 
				}
				
				// Se for a última linha da página
				if($linha == '10'){
					// Adiciona uma nova página
					$pdf->AddPage();
					// $linha volta ao seu valor inicial
					$linha = 0;
				}
				
				$X=$coluna*$larguraEtiqueta+$coluna*$espacoVerticalEtiqueta+$margemEsquerda;
				$Y=$linha*$alturaEtiqueta+$linha*$espacoHorizontalEtiqueta+$margemTopo;

				$txt = $nome."\n".$ende.', '.$end.', '.$local.' - '.$cep;
				
				$pdf->MultiCell($larguraEtiqueta, $alturaEtiqueta, $txt, 0, 'L', 0, 0, $X, $Y, TRUE, 0, FALSE, TRUE, $alturaEtiqueta, 'M', TRUE);
				
				$coluna++;
			}
		}
		elseif($quant>0){
			for($i=0;$i<$quant;$i++){
				foreach($this->query as $dados){
					$titulo = "REMETENTE:";
					$nome = $dados->nome;
					$ende = $dados->logradouro;
					if($dados->numero!='' && $dados->complemento!=''){
						$end = $dados->numero.' - '.$dados->complemento;
					}
					elseif($dados->numero!='' && $dados->complemento==''){
						$end = $dados->numero;
					}
					elseif($dados->numero=='' && $dados->complemento!=''){
						$end = $dados->complemento;
					}

					$bairro = $dados->bairro;
					$estado = $dados->cidade;
					$cida = $dados->sigla;
					$local = $bairro." - ".$estado." - ".$cida;
					$cep = $dados->cep;
					
					if($linha == '10'){
						$pdf->AddPage();
						$linha = 0;
					}
					
					// Se for a terceira coluna
					if($coluna == '2'){
						// $coluna volta para o valor inicial
						$coluna = 0;
						// $linha é igual ela mesma +1
						$linha++; 
					}
					
					// Se for a última linha da página
					if($linha == '10'){
						// Adiciona uma nova página
						$pdf->AddPage();
						// $linha volta ao seu valor inicial
						$linha = 0;
					}
					
					$X=$coluna*$larguraEtiqueta+$coluna*$espacoVerticalEtiqueta+$margemEsquerda;
					$Y=$linha*$alturaEtiqueta+$linha*$espacoHorizontalEtiqueta+$margemTopo;

					$txt = $nome."\n".$ende.', '.$end.', '.$local.' - '.$cep;
					
					$pdf->MultiCell($larguraEtiqueta, $alturaEtiqueta, $txt, 0, 'L', 0, 0, $X, $Y, TRUE, 0, FALSE, TRUE, $alturaEtiqueta, 'M', TRUE);
					
					$coluna++;
				}
			}
		}
		
		if($reg%20==0 || ($reg+1)%20==0){
			if(($reg+1)%20==0){
				$page = ($reg+1)/20;
			}
			else{
				$page = $reg/20;
			}
			$page++;
			$page = (int) $page;
			$pdf->deletePage($page);
		}
		if($quant==0){
			$pdf->Output(str_replace('//','\\',$_SERVER['DOCUMENT_ROOT']).'\require\arquivos\Destinatarios.pdf','F');
		}
		elseif($quant>0){
			$pdf->Output(str_replace('//','\\',$_SERVER['DOCUMENT_ROOT']).'\require\arquivos\Remetente.pdf','F');
		}
		
		return $sql;
	}
	
	public function gerarGrid($sql){
		$this->bd = new DataBase;
		
//		$sql = gerarSQLDestinatario($Pesquisa, $Ordena, $Substituir);
		
		$this->query = $this->bd->selectDB($sql);
		
		return json_encode($this->query);
	}
}
?>