<?php
	require_once "../../../class/modelo/persistencia/DataBase.class.php";
	require_once "autoload.inc.php";
	
	$bd = new DataBase;
	$query=$bd->selectDB('SELECT p.*, m.sigla FROM pessoa AS p INNER JOIN municipio AS m ON p.municipio=m.cod_municipio');
	
	$medida='mm';
	
	$font='Times, "Times New Roman"';
	$color='#000';
	
	if($medida=='mm'){
		$medida=3.779527559;
	}
	elseif($medida=='cm'){
		$medida=37.795275591;
	}
	
//	Variaveis de Tamanho
	// Margem Esquerda (mm)
	$margemEsquerda = "4";
	// Margem Direita (mm)
	$margemDireita = "4";
	// Margem Superior (mm)
	$margemTopo = "5";
	// Largura da Etiqueta (mm)
	$larguraEtiqueta = "101.6";
	// Altura da Etiqueta (mm)
	$alturaEtiqueta = "25.4";
	// Espaço horizontal entre as Etiquetas (mm)
	$espacoHorizontalEtiqueta = "0";
	// Espaço vertical entre as Etiquetas (mm)
	$espacoVerticalEtiqueta = "5.2";
	
	$html = '
					<html>
						<head>
							<title>Destinatarios</title>
							<style type="text/css">
								*{
									font-family: '.$font.';
									color: '.$color.';
									text-justify: inter-word;
									font-size: 14;
									margin: 0px;
								}
								table{
									margin-top: '.$margemTopo*$medida.'px;
									margin-left: '.$margemEsquerda*$medida.'px;
									margin-right: '.$margemDireita*$medida.'px;
								}
								td{
									height: '.$alturaEtiqueta*$medida.'px;
									width: '.$espacoVerticalEtiqueta*$medida.'px;
									padding-left: 5px;
								}
								td:nth-child(1),
								td:nth-child(3){
									width: '.$larguraEtiqueta*$medida.'px !important;
								}
							</style>
						</head>
						<body>
							<table>
	';
	$linha=0;
	$coluna=0;
	foreach($query as $dados){
		if($coluna==3){
			$linha++;
			$coluna=0;
			$html .= '</tr>';
		}
		
		if($linha==10){
			$linha = 0;
			$coluna =0;
		}
		
		if($coluna==0){
			$html .= '<tr>';
		}
		
		if($coluna%2==0){
			$html .= '<td>';
			$html .= $dados->nome.'<br />'.$dados->logradouro;
			if($dados->numero!='' && $dados->complemento!=''){
				$html .= ', '.$dados->numero.' - '.$dados->complemento;
			}
			elseif($dados->numero!='' && $dados->complemento==''){
				$html .= ', '.$dados->numero;
			}
			elseif($dados->numero=='' && $dados->complemento!=''){
				$html .= ', '.$dados->complemento;
			}
			$html .= ','.$dados->bairro.', '.$dados->cidade.'\\'.$dados->sigla.' - '.$dados->cep;
			$html .= '</td>';
		}
		else{
			$html .= '<td>.</td>';
		}
		$coluna++;
	}
	
	$html .= '
							</table>
						</body>
					</html>
	';
	echo $html;
	/*
	//file_put_contents('teste.html',$wArq);
    $dompdf = new Dompdf\Dompdf();
    //$dompdf->set_option('isHtml5ParserEnabled', true);
    // Carrega seu HTML 
    //$dompdf->load_html_file('teste.html');
    $dompdf->load_html($html);
    //CONFIGURAÇÕES
    $dompdf->set_paper('A4');
    // Renderiza 
    $dompdf->render();
    // Exibe 
    $dompdf->stream(
        "Destinatarios", // Nome do arquivo de saída
        array(
            "Attachment" => true // Para download, altere para true
        )
    );
    */
?>
