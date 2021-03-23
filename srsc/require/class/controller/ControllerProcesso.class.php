<?php
class ControllerProcesso extends ControllerFuncoes{
	private $bd;
	private $filteIn;
	private $query;
	
	private function existe($txt){
		if($txt!=''){
			return '<br />';
		}
		else{
			return '';
		}
	}
	
	public function selectUnicoProcesso($processo){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB('SELECT pr.n_processo,pr.arquivo,DATE_FORMAT(pr.dataArquivo,"%d/%m/%Y") AS "dataArquivo",pr.juizDaSentenca,pr.trtTurma,pr.trtRelator,pr.tstTurma,pr.tstRelator, status,
(SELECT GROUP_CONCAT(p.nome) FROM autor AS a INNER JOIN pessoa AS p ON a.cod_pessoa=p.cod_pessoa WHERE a.n_processo=pr.n_processo) AS "Autor",
(SELECT GROUP_CONCAT(p.nome) FROM autor AS a INNER JOIN advogado AS p ON a.cod_advogado=p.cod_advogado WHERE a.n_processo=pr.n_processo) AS "AdvAutor",
(SELECT GROUP_CONCAT(p.razao_social) FROM reus AS a INNER JOIN empresa AS p ON a.cod_empresa=p.cod_empresa WHERE a.n_processo=pr.n_processo) AS "Reu",
(SELECT GROUP_CONCAT(p.nome) FROM reus a INNER JOIN advogado AS p ON a.cod_advogado=p.cod_advogado WHERE a.n_processo=pr.n_processo) AS "AdvReus",
(SELECT GROUP_CONCAT(p.nome) FROM processo_fases AS a INNER JOIN fases AS p ON a.idFases=p.idFases WHERE a.n_processo=pr.n_processo) AS "Fases",
(SELECT GROUP_CONCAT(p.nome) FROM processo_motivos AS a INNER JOIN motivos AS p ON a.idMotivos=p.idMotivos WHERE a.n_processo=pr.n_processo) AS "Motivos"
FROM processo AS pr WHERE pr.n_processo=?',array($processo))){
			foreach($this->query as $processo){
				$msg['processo']	= 	$processo->n_processo;
				$msg['arquivo']		=	$processo->arquivo;
				$msg['dataArquivo']	=	$processo->dataArquivo!='00/00/0000'?$processo->dataArquivo:'';
				$msg['juiz']		=	$processo->juizDaSentenca;
				$msg['trtTurma'] 	=	$processo->trtTurma!=0?$processo->trtTurma:'';
				$msg['trtRelator']	=	$processo->trtRelator;
				$msg['tstTurma']	=	$processo->tstTurma!=0?$processo->tstTurma:'';
				$msg['tstRelator']	=	$processo->tstRelator;
				$msg['status']		=	$processo->status;
				$msg['Autor']		=	!empty($processo->Autor)?$processo->Autor.',':'';
				$msg['AdvAutor']	=	!empty($processo->AdvAutor)?$processo->AdvAutor.',':'';
				$msg['Reu']			=	!empty($processo->Reu)?$processo->Reu.',':'';
				$msg['AdvReus']		=	!empty($processo->AdvReus)?$processo->AdvReus.',':'';
				$msg['Fases']		=	!empty($processo->Fases)?$processo->Fases.',':'';
				$msg['Motivos']		=	!empty($processo->Motivos)?$processo->Motivos.',':'';
			}
			return	'processo;'.
					$msg['processo'].';'.		//01
					$msg['arquivo'].';'.		//02
					$msg['dataArquivo'].';'.	//03
					$msg['juiz'].';'.			//04
					$msg['trtTurma'].';'.		//05
					$msg['trtRelator'].';'.		//06
					$msg['tstTurma'].';'.		//07
					$msg['tstRelator'].';'.		//08
					$msg['status'].';'.			//09
					$msg['Autor'].';'.			//10
					$msg['AdvAutor'].';'.		//11
					$msg['Reu'].';'.			//12
					$msg['AdvReus'].';'.		//13
					$msg['Fases'].';'.			//14
					$msg['Motivos'];			//15
		}
		else{
			return false;
		}
	}
	
	public function cadastrar($processo,$arquivo,$juiz,$trtTurma,$trtRelator,$tstTurma,$tstRelator,$autor,$advogadoA,$reu,$advogadoR,$fase,$motivo,$status,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		//VERIFICA PROCESSO
		if(!empty($processo)){
			if($this->bd->existeSelectDB('SELECT n_processo FROM processo WHERE n_processo=?',array($processo))){
				$msg .= $this->existe($msg).'Número de processo: "'.$processo.'", já existe.';
			}
		}
		else{
			$msg .= $this->existe($msg).'Processo em branco!';
		}
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA ARQUIVO
		if($arquivo=='1'){
			$arquivoData	=	date('Y-m-d');
		}
		else{
			$arquivoData	=	'00-00-0000';
		}
		
		if(empty($trtTurma)){
			$trtTurma = 0;
		}
		
		if(empty($tstTurma)){
			$tstTurma = 0;
		}
		
		if($status=="0"){
			$status = 0;
		}
		elseif(empty($status)){
			$status = 1;
		}
		
		$autores = '';
		$advogadosA = '';
		$reus = '';
		$advogadosR = '';
		$fases = '';
		$motivos = '';
		
		//VERIFICA AUTOR
		if(!empty($autor)){
			$autor = explode(';',$autor);
			foreach($autor as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_pessoa FROM pessoa WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$autores .= $a->cod_pessoa.';';
					}
					else
						$msg .= $this->existe($msg).'Autor: '.$valor.', não existe!';
				}
			}
		}
		
		//VERIFICA ADVOGADO AUTOR
		if(!empty($advogadoA)){
			$advogadoA = explode(';',$advogadoA);
			$advogadosAutor = '';
			foreach($advogadoA as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_advogado FROM advogado WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$advogadosAutor .= $a->cod_advogado.';';
					}
					else
						$msg .= $this->existe($msg).'Advogado: '.$valor.', não existe!';
				}
			}
		}
		
		//VERFICA SE ADVOGADO É MAIOR DO QUE AUTORES
//		if(count($advogado)>count($autor)){
//			$msg .= existe($msg).'Contém mais advogado(s) do que autor(es)! Por favor mantenha a quantidade de advogado(s) menor ou igual ao de autor(es).';
//		}
		
		//VERIFICA REUS
		if(!empty($reu)){
			$reu = explode(';',$reu);
			foreach($reu as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_empresa FROM empresa WHERE razao_social=?',array($valor))){
						foreach($this->query as $a)
							$reus .= $a->cod_empresa.';';
					}
					else
						$msg .= $this->existe($msg).'Reu: '.$valor.', não existe!';
				}
			}
		}
		
		//VERIFICA ADVOGADO REU
		if(!empty($advogadoR)){
			$advogadoR = explode(';',$advogadoR);
			$advogadosReus = '';
			foreach($advogadoR as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_advogado FROM advogado WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$advogadosReus .= $a->cod_advogado.';';
					}
					else
						$msg .= $this->existe($msg).'Advogado: '.$valor.', não existe!';
				}
			}
		}
		
		//VERFICA SE ADVOGADO É MAIOR DO QUE AUTORES
//		if(count($advogado)>count($autor)){
//			$msg .= existe($msg).'Contém mais advogado(s) do que autor(es)! Por favor mantenha a quantidade de advogado(s) menor ou igual ao de autor(es).';
//		}
		
		//VERIFICA FASES
		if(!empty($fase)){
			$fase = explode(';',$fase);
			foreach($fase as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT idFases FROM fases WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$fases .= $a->idFases.';';
					}
					else
						$msg .= $this->existe($msg).'Fase: '.$valor.', não existe!';
				}
			}
		}
		
		//VERIFICA MOTIVOS
		if(!empty($motivo)){
			$motivo = explode(';',$motivo);
			foreach($motivo as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT idMotivos FROM motivos WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$motivos .= $a->idMotivos.';';
					}
					else
						$msg .= $this->existe($msg).'Fase: '.$valor.', não existe!';
				}
			}
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else{
			//CADASTRAR PROCESSO
			$this->bd->insertDB("INSERT INTO processo (n_processo, arquivo, juizDaSentenca, trtTurma, trtRelator, tstTurma, tstRelator, dataArquivo, status, dataCadastro, idlogin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",array($processo, $arquivo, $juiz, $trtTurma, $trtRelator, $tstTurma, $tstRelator, $arquivoData, $status, $dataCadastro, $login));
			
			//CADASTRAR AUTORES e ADVOGADO
			if(!empty($autores)){
				$x=0;
				$autores	=	explode(';',$autores);
				if (!empty($advogadosAutor)){
					$advogadosAutor	=	explode(';',$advogadosAutor);
					foreach($autores as $valor){
						if(!empty($valor))
							$this->bd->insertDB('INSERT INTO autor (n_processo, cod_pessoa, cod_advogado) VALUES(?, ?, ?)',array($processo, $valor, $advogadosAutor[$x]));
						$x++;
					}
				}
				else{
					foreach($autores as $valor){
						if(!empty($valor))
							$this->bd->insertDB('INSERT INTO autor (n_processo, cod_pessoa) VALUES(?, ?)',array($processo, $valor));
						$x++;
					}
				}
			}
			
			//CADASTRAR REUS
			if(!empty($reus)){
				$x=0;
				$reus	=	explode(';',$reus);
				if (!empty($advogadosReus)){
					$advogadosReus	=	explode(';',$advogadosReus);
					foreach($reus as $valor){
						if(!empty($valor))
							$this->bd->insertDB('INSERT INTO reus (n_processo, cod_empresa, cod_advogado) VALUES(?, ?, ?)',array($processo, $valor, $advogadosReus[$x]));
						$x++;
					}
				}
				else{
					foreach($reus as $valor){
						$this->bd->insertDB('INSERT INTO reus (n_processo, cod_empresa) VALUES(?, ?)',array($processo, $valor));
						$x++;
					}
				}
			}
			
			//CADASTRAR FASES
			if(!empty($fases)){
				$fases	=	explode(';',$fases);
				foreach($fases as $valor){
					if(!empty($valor))
						$this->bd->insertDB('INSERT INTO processo_fases (n_processo, idFases) VALUES(?, ?)',array($processo, $valor));
				}
			}
			
			//CADASTRAR MOTIVOS
			if(!empty($motivos)){
				$motivos	=	explode(';',$motivos);
				foreach($motivos as $valor){
					if(!empty($valor))
						$this->bd->insertDB('INSERT INTO processo_motivos (n_processo, idMotivos) VALUES(?, ?)',array($processo, $valor));
				}
			}
		}
	}
	
	public function editar($processo,$antigoProcesso,$arquivo,$juiz,$trtTurma,$trtRelator,$tstTurma,$tstRelator,$autor,$advogadoA,$reu,$advogadoR,$fase,$motivo,$status,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		//VERIFICA PROCESSO
		if(!empty($processo)){
			if($processo!=$antigoProcesso)
			if($this->bd->existeSelectDB('SELECT n_processo FROM processo WHERE n_processo=?',array($processo))){
				$msg .= $this->existe($msg).'Número de processo: "'.$processo.'", já existe.';
			}
		}
		else{
			$msg .= $this->existe($msg).'Processo em branco!';
		}
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA ARQUIVO
		if($arquivo==1){
			$arquivoData	=	date('Y-m-d');
		}
		else{
			if($this->query = $this->bd->selectDB('SELECT arquivo, dataarquivo FROM processo WHERE n_processo=?',array($antigoProcesso))){
				foreach($this->query as $arquiv)
					if($arquiv->arquivo==1){
						$arquivo 		= 1;
						$arquivoData 	= $arquiv->dataarquivo;
					}
					else{
						$arquivoData	=	'00-00-0000';
					}
			}
			else{
				if($arquivo=='1'){
					$arquivoData	=	date('Y-m-d');
				}
				else{
					$arquivoData	=	'00-00-0000';
				}
			}
		}
		
		if(empty($trtTurma)){
			$trtTurma = 0;
		}
		
		if(empty($tstTurma)){
			$tstTurma = 0;
		}
		
		if($status=="0"){
			$status = 0;
		}
		elseif(empty($status)){
			$status = 1;
		}
		
		$autores = '';
		$advogadosA = '';
		$reus = '';
		$advogadosR = '';
		$fases = '';
		$motivos = '';
		
		//VERIFICA AUTOR
		if(!empty($autor)){
			$autor = explode(';',$autor);
			foreach($autor as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_pessoa FROM pessoa WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$autores .= $a->cod_pessoa.';';
					}
					else
						$msg .= $this->existe($msg).'Autor: '.$valor.', não existe!';
				}
			}
		}
		
		//VERIFICA ADVOGADO AUTOR
		if(!empty($advogadoA)){
			$advogadoA = explode(';',$advogadoA);
			$advogadosAutor = '';
			foreach($advogadoA as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_advogado FROM advogado WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$advogadosAutor .= $a->cod_advogado.';';
					}
					else
						$msg .= $this->existe($msg).'Advogado: '.$valor.', não existe!';
				}
			}
		}
		
		//VERFICA SE ADVOGADO É MAIOR DO QUE AUTORES
//		if(count($advogado)>count($autor)){
//			$msg .= existe($msg).'Contém mais advogado(s) do que autor(es)! Por favor mantenha a quantidade de advogado(s) menor ou igual ao de autor(es).';
//		}
		
		//VERIFICA REUS
		if(!empty($reu)){
			$reu = explode(';',$reu);
			foreach($reu as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_empresa FROM empresa WHERE razao_social=?',array($valor))){
						foreach($this->query as $a)
							$reus .= $a->cod_empresa.';';
					}
					else
						$msg .= $this->existe($msg).'Reu: '.$valor.', não existe!';
				}
			}
		}
		
		//VERIFICA ADVOGADO REU
		if(!empty($advogadoR)){
			$advogadoR = explode(';',$advogadoR);
			$advogadosReus = '';
			foreach($advogadoR as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT cod_advogado FROM advogado WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$advogadosReus .= $a->cod_advogado.';';
					}
					else
						$msg .= $this->existe($msg).'Advogado: '.$valor.', não existe!';
				}
			}
		}
		
		//VERFICA SE ADVOGADO É MAIOR DO QUE AUTORES
//		if(count($advogado)>count($autor)){
//			$msg .= existe($msg).'Contém mais advogado(s) do que autor(es)! Por favor mantenha a quantidade de advogado(s) menor ou igual ao de autor(es).';
//		}
		
		//VERIFICA FASES
		if(!empty($fase)){
			$fase = explode(';',$fase);
			foreach($fase as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT idFases FROM fases WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$fases .= $a->idFases.';';
					}
					else
						$msg .= $this->existe($msg).'Fase: '.$valor.', não existe!';
				}
			}
		}
		
		//VERIFICA MOTIVOS
		if(!empty($motivo)){
			$motivo = explode(';',$motivo);
			foreach($motivo as $valor){
				if(!empty($valor)){
					if($this->query = $this->bd->selectDB('SELECT idMotivos FROM motivos WHERE nome=?',array($valor))){
						foreach($this->query as $a)
							$motivos .= $a->idMotivos.';';
					}
					else
						$msg .= $this->existe($msg).'Fase: '.$valor.', não existe!';
				}
			}
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else{
			//ATUALIZAR PROCESSO
			$this->bd->updateDB('UPDATE processo SET n_processo=?, descricao="", arquivo=?, juizdasentenca=?, trtturma=?, trtrelator=?, tstturma=?, tstrelator=?, dataarquivo=?, status=?, dataCadastro=?, idlogin=? WHERE n_processo=?',array($processo, $arquivo, $juiz, $trtTurma, $trtRelator, $tstTurma, $tstRelator, $arquivoData, $status, $dataCadastro, $login, $antigoProcesso));
			
			//CADASTRAR AUTORES e ADVOGADO
			if(!empty($autores)){
				$x=0;
				$autores	=	explode(';',$autores);
				$this->bd->deleteDB('DELETE FROM autor WHERE n_processo=?',array($antigoProcesso));
				if (!empty($advogadosAutor)){
					$advogadosAutor	=	explode(';',$advogadosAutor);
					foreach($autores as $valor){
						if(!empty($valor))
							$this->bd->insertDB('INSERT INTO autor (n_processo, cod_pessoa, cod_advogado) VALUES(?, ?, ?)',array($processo, $valor, $advogadosAutor[$x]));
						$x++;
					}
				}
				else{
					foreach($autores as $valor){
						if(!empty($valor))
							$this->bd->insertDB('INSERT INTO autor (n_processo, cod_pessoa) VALUES(?, ?)',array($processo, $valor));
						$x++;
					}
				}
			}
			
			//CADASTRAR REUS
			if(!empty($reus)){
				$x=0;
				$reus	=	explode(';',$reus);
				$this->bd->deleteDB('DELETE FROM reus WHERE n_processo=?',array($antigoProcesso));
				if (!empty($advogadosReus)){
					$advogadosReus	=	explode(';',$advogadosReus);
					foreach($reus as $valor){
						if(!empty($valor))
							$this->bd->insertDB('INSERT INTO reus (n_processo, cod_empresa, cod_advogado) VALUES(?, ?, ?)',array($processo, $valor, $advogadosReus[$x]));
						$x++;
					}
				}
				else{
					foreach($reus as $valor){
						$this->bd->insertDB('INSERT INTO reus (n_processo, cod_empresa) VALUES(?, ?)',array($processo, $valor));
						$x++;
					}
				}
			}
			
			//CADASTRAR FASES
			if(!empty($fases)){
				$fases	=	explode(';',$fases);
				$this->bd->deleteDB('DELETE FROM processo_fases WHERE n_processo=?',array($antigoProcesso));
				foreach($fases as $valor){
					if(!empty($valor))
						$this->bd->insertDB('INSERT INTO processo_fases (idFases, n_processo) VALUES(?, ?)',array($valor,$processo));
				}
			}
			
			//CADASTRAR MOTIVOS
			if(!empty($motivos)){
				$motivos	=	explode(';',$motivos);
				$this->bd->deleteDB('DELETE FROM processo_motivos WHERE n_processo=?',array($antigoProcesso));
				foreach($motivos as $valor){
					if(!empty($valor))
						$this->bd->insertDB('INSERT INTO processo_motivos (idMotivos, n_processo) VALUES(?, ?)',array($valor,$processo));
				}
			}
		}
	}
	
	public function deletar($processo){
		if(!empty($processo)){
			$dir = '../../arquivos/processos/'.$processo;
			if(file_exists($dir)){
				$files = array_diff(scandir($dir), array('.','..')); 
			    foreach ($files as $file) { 
			      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
			    } 
	    		rmdir($dir);	
			}
			$this->bd = new DataBase;
			$this->bd->deleteDB('DELETE FROM processo WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM autor WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM reus WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM processo_fases WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM processo_motivos WHERE n_processo=?',array($processo));
		}
	}
	
	private function criarXmlConfiguracaoGrid($login,$array){
		$array = explode(',',$array);
		
		$PROCESSO = $array[0];
		$PDF = $array[1];
		$JUIZ = $array[2];
		$TRT_TURMA = $array[3];
		$TRT_RELATOR = $array[4];
		$TST_TURMA = $array[5];
		$TST_RELATOR = $array[6];
		$AUTOR = $array[7];
		$PROFISSAO = $array[8];
		$ADVOGADO_AUTOR = $array[9];
		$REU = $array[10];
		$ADVOGADO_REU = $array[11];
		$FASE = $array[12];
		$MATERIA = $array[13];
		$STATUS = $array[14];
		$CADASTRADO_POR = $array[15];
		$CADASTRADO_DATA = $array[16];
		
		#versao do encoding xml
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><CONFIGURACAO></CONFIGURACAO>");
		 
		#nó filho (contato)
		$LOGIN = $xml->addChild('LOGIN');
		
		#setanto nomes e atributos dos elementos xml (nós)
		$LOGIN->addAttribute("nome", $login);
		
		#nó filho (contato)
		$PROCESSO_PAI = $LOGIN->addChild("PROCESSO"); 
		
		#nó filho (contato)
		$CAMPOS = $PROCESSO_PAI->addChild("CAMPOS");
		
		#setanto nomes e atributos dos elementos xml (nós)
		$PROCESSO = $CAMPOS->addChild("PROCESSO", $PROCESSO);
		$PDF = $CAMPOS->addChild("PDF", $PDF);
		$JUIZ = $CAMPOS->addChild("JUIZ", $JUIZ);
		$TRT_TURMA = $CAMPOS->addChild("TRT_TURMA", $TRT_TURMA);
		$TRT_RELATOR = $CAMPOS->addChild("TRT_RELATOR", $TRT_RELATOR);
		$TST_TURMA = $CAMPOS->addChild("TST_TURMA", $TST_TURMA);
		$TST_RELATOR = $CAMPOS->addChild("TST_RELATOR", $TST_RELATOR);
		$AUTOR = $CAMPOS->addChild("AUTOR", $AUTOR);
		$PROFISSAO = $CAMPOS->addChild("PROFISSAO", $PROFISSAO);
		$ADVOGADO_AUTOR = $CAMPOS->addChild("ADVOGADO_AUTOR", $ADVOGADO_AUTOR);
		$REU = $CAMPOS->addChild("REU", $REU);
		$ADVOGADO_REU = $CAMPOS->addChild("ADVOGADO_REU", $ADVOGADO_REU);
		$FASE = $CAMPOS->addChild("FASE", $FASE);
		$MATERIA = $CAMPOS->addChild("MATERIA", $MATERIA);
		$STATUS = $CAMPOS->addChild("STATUS", $STATUS);
		$CADASTRADO_POR = $CAMPOS->addChild("CADASTRADO_POR",$CADASTRADO_POR);
		$CADASTRADO_POR = $CAMPOS->addChild("CADASTRADO_DATA",$CADASTRADO_DATA);
		 
		$xml->asXML('../../path/configuracoes.xml');
	}
	
	private function adcionarXmlConfiguracaoGrid($login,$array){
		
		$array = explode(',',$array);
		
		$PROCESSO = $array[0];
		$PDF = $array[1];
		$JUIZ = $array[2];
		$TRT_TURMA = $array[3];
		$TRT_RELATOR = $array[4];
		$TST_TURMA = $array[5];
		$TST_RELATOR = $array[6];
		$AUTOR = $array[7];
		$PROFISSAO = $array[8];
		$ADVOGADO_AUTOR = $array[9];
		$REU = $array[10];
		$ADVOGADO_REU = $array[11];
		$FASE = $array[12];
		$MATERIA = $array[13];
		$STATUS = $array[14];
		$CADASTRADO_POR = $array[15];
		$CADASTRADO_DATA = $array[16];
		
		$xml = simplexml_load_file('../../path/configuracoes.xml');
		
		#nó filho (contato)
		$LOGIN = $xml->addChild('LOGIN');
		
		#setanto nomes e atributos dos elementos xml (nós)
		$LOGIN->addAttribute("nome", $login);
		
		#nó filho (contato)
		$PROCESSO_PAI = $LOGIN->addChild("PROCESSO"); 
		
		#nó filho (contato)
		$CAMPOS = $PROCESSO_PAI->addChild("CAMPOS");
		
		#setanto nomes e atributos dos elementos xml (nós)
		$PROCESSO = $CAMPOS->addChild("PROCESSO", $PROCESSO);
		$PDF = $CAMPOS->addChild("PDF", $PDF);
		$JUIZ = $CAMPOS->addChild("JUIZ", $JUIZ);
		$TRT_TURMA = $CAMPOS->addChild("TRT_TURMA", $TRT_TURMA);
		$TRT_RELATOR = $CAMPOS->addChild("TRT_RELATOR", $TRT_RELATOR);
		$TST_TURMA = $CAMPOS->addChild("TST_TURMA", $TST_TURMA);
		$TST_RELATOR = $CAMPOS->addChild("TST_RELATOR", $TST_RELATOR);
		$AUTOR = $CAMPOS->addChild("AUTOR", $AUTOR);
		$PROFISSAO = $CAMPOS->addChild("PROFISSAO", $PROFISSAO);
		$ADVOGADO_AUTOR = $CAMPOS->addChild("ADVOGADO_AUTOR", $ADVOGADO_AUTOR);
		$REU = $CAMPOS->addChild("REU", $REU);
		$ADVOGADO_REU = $CAMPOS->addChild("ADVOGADO_REU", $ADVOGADO_REU);
		$FASE = $CAMPOS->addChild("FASE", $FASE);
		$MATERIA = $CAMPOS->addChild("MATERIA", $MATERIA);
		$STATUS = $CAMPOS->addChild("STATUS", $STATUS);
		$CADASTRADO_POR = $CAMPOS->addChild("CADASTRADO_POR",$CADASTRADO_POR);
		$CADASTRADO_POR = $CAMPOS->addChild("CADASTRADO_DATA",$CADASTRADO_DATA);
		
		$xml->asXML('../../path/configuracoes.xml');
	}
	
	private function editarXmlConfiguracaoGrid($login,$array){
		
		$array = explode(',',$array);
		
		$PROCESSO = $array[0];
		$PDF = $array[1];
		$JUIZ = $array[2];
		$TRT_TURMA = $array[3];
		$TRT_RELATOR = $array[4];
		$TST_TURMA = $array[5];
		$TST_RELATOR = $array[6];
		$AUTOR = $array[7];
		$PROFISSAO = $array[8];
		$ADVOGADO_AUTOR = $array[9];
		$REU = $array[10];
		$ADVOGADO_REU = $array[11];
		$FASE = $array[12];
		$MATERIA = $array[13];
		$STATUS = $array[14];
		$CADASTRADO_POR = $array[15];
		$CADASTRADO_DATA = $array[16];
		
		$xml = simplexml_load_file('../../path/configuracoes.xml');
		
		foreach($xml AS $xmls){
			if($xmls->attributes()['nome']==$login){
				$xmls->PROCESSO->CAMPOS->PROCESSO = $PROCESSO;
				$xmls->PROCESSO->CAMPOS->PDF = $PDF;
				$xmls->PROCESSO->CAMPOS->JUIZ = $JUIZ;
				$xmls->PROCESSO->CAMPOS->TRT_TURMA = $TRT_TURMA;
				$xmls->PROCESSO->CAMPOS->TRT_RELATOR = $TRT_RELATOR;
				$xmls->PROCESSO->CAMPOS->TST_TURMA = $TST_TURMA;
				$xmls->PROCESSO->CAMPOS->TST_RELATOR = $TST_RELATOR;
				$xmls->PROCESSO->CAMPOS->AUTOR = $AUTOR;
				$xmls->PROCESSO->CAMPOS->PROFISSAO = $PROFISSAO;
				$xmls->PROCESSO->CAMPOS->ADVOGADO_AUTOR = $ADVOGADO_AUTOR;
				$xmls->PROCESSO->CAMPOS->REU = $REU;
				$xmls->PROCESSO->CAMPOS->ADVOGADO_REU = $ADVOGADO_REU;
				$xmls->PROCESSO->CAMPOS->FASE = $FASE;
				$xmls->PROCESSO->CAMPOS->MATERIA = $MATERIA;
				$xmls->PROCESSO->CAMPOS->STATUS = $STATUS;
				$xmls->PROCESSO->CAMPOS->CADASTRADO_POR = $CADASTRADO_POR;
				$xmls->PROCESSO->CAMPOS->CADASTRADO_DATA = $CADASTRADO_DATA;
				
				break;
			}
		}
		$xml->asXML('../../path/configuracoes.xml');
	}
	
	private function relatarConfiguracaoDoCampoXML($login){
		$xml = simplexml_load_file('../../path/configuracoes.xml');
		
		foreach($xml AS $xmls){
			if($xmls->attributes()['nome']==$login){
				$retorno = $xmls->PROCESSO->CAMPOS->PROCESSO.','.$xmls->PROCESSO->CAMPOS->PDF.','.$xmls->PROCESSO->CAMPOS->JUIZ.','.$xmls->PROCESSO->CAMPOS->TRT_TURMA.','.$xmls->PROCESSO->CAMPOS->TRT_RELATOR.','.$xmls->PROCESSO->CAMPOS->TST_TURMA.','.$xmls->PROCESSO->CAMPOS->TST_RELATOR.','.$xmls->PROCESSO->CAMPOS->AUTOR.','.$xmls->PROCESSO->CAMPOS->PROFISSAO.','.$xmls->PROCESSO->CAMPOS->ADVOGADO_AUTOR.','.$xmls->PROCESSO->CAMPOS->REU.','.$xmls->PROCESSO->CAMPOS->ADVOGADO_REU.','.$xmls->PROCESSO->CAMPOS->FASE.','.$xmls->PROCESSO->CAMPOS->MATERIA.','.$xmls->PROCESSO->CAMPOS->STATUS.','.$xmls->PROCESSO->CAMPOS->CADASTRADO_POR.','.$xmls->PROCESSO->CAMPOS->CADASTRADO_DATA;
				break;
			}
		}
		return $retorno;
	}
	
	public function controllerXmlProcesso($status,$login,$array){
		if($status=='Salvar'){
			$array = explode(',',$array);
			
			if(in_array('0',$array)){
				$PROCESSO = 1;
			}
			else{
				$PROCESSO = 0;
			}
			
			if(in_array('1',$array)){
				$PDF = 1;
			}
			else{
				$PDF = 0;
			}
			
			if(in_array('2',$array)){
				$JUIZ = 1;
			}
			else{
				$JUIZ = 0;
			}
			
			if(in_array('3',$array)){
				$TRT_TURMA = 1;
			}
			else{
				$TRT_TURMA = 0;
			}
			
			if(in_array('4',$array)){
				$TRT_RELATOR = 1;
			}
			else{
				$TRT_RELATOR = 0;
			}
			
			if(in_array('5',$array)){
				$TST_TURMA = 1;
			}
			else{
				$TST_TURMA = 0;
			}
			
			if(in_array('6',$array)){
				$TST_RELATOR = 1;
			}
			else{
				$TST_RELATOR = 0;
			}
			
			if(in_array('7',$array)){
				$AUTOR = 1;
			}
			else{
				$AUTOR = 0;
			}
			
			if(in_array('8',$array)){
				$PROFISSAO = 1;
			}
			else{
				$PROFISSAO = 0;
			}
			
			if(in_array('9',$array)){
				$ADVOGADO_AUTOR = 1;
			}
			else{
				$ADVOGADO_AUTOR = 0;
			}
			
			if(in_array('10',$array)){
				$REU = 1;
			}
			else{
				$REU = 0;
			}
			
			if(in_array('11',$array)){
				$ADVOGADO_REU = 1;
			}
			else{
				$ADVOGADO_REU = 0;
			}
			
			if(in_array('12',$array)){
				$FASE = 1;
			}
			else{
				$FASE = 0;
			}
			
			if(in_array('13',$array)){
				$MATERIA = 1;
			}
			else{
				$MATERIA = 0;
			}
			
			if(in_array('14',$array)){
				$STATUS = 1;
			}
			else{
				$STATUS = 0;
			}
			
			if(in_array('15',$array)){
				$CADASTRADO_POR = 1;
			}
			else{
				$CADASTRADO_POR = 0;
			}
			
			if(in_array('16',$array)){
				$CADASTRADO_DATA = 1;
			}
			else{
				$CADASTRADO_DATA = 0;
			}
			
			$array = $PROCESSO.','.$PDF.','.$JUIZ.','.$TRT_TURMA.','.$TRT_RELATOR.','.$TST_TURMA.','.$TST_RELATOR.','.$AUTOR.','.$PROFISSAO.','.$ADVOGADO_AUTOR.','.$REU.','.$ADVOGADO_REU.','.$FASE.','.$MATERIA.','.$STATUS.','.$CADASTRADO_POR.','.$CADASTRADO_DATA;
			
			if(!file_exists('../../path/configuracoes.xml')){
				$this->criarXmlConfiguracaoGrid($login,$array);
			}
			else{
				$existe=FALSE;
				$xml = simplexml_load_file('../../path/configuracoes.xml');
				$position=0;
				foreach($xml as $values){
					if($values->attributes()['nome']==$login){
						$existe=TRUE;
						break;
					}
					$position++;
				}
				if($existe){
					$this->editarXmlConfiguracaoGrid($login,$array);
				}
				else{
					$this->adcionarXmlConfiguracaoGrid($login,$array);
				}
			}
		}
		elseif($status=='Deletar'){
				$existe=FALSE;
				$xml = simplexml_load_file('../../path/configuracoes.xml');
				$position=0;
				foreach($xml as $values){
					if($values->attributes()['nome']==$login){
						$existe=TRUE;
						break;
					}
					$position++;
				}
				if($existe){
					$this->deletarXmlConfiguracaoGrid($login,$position);
				}
				else{
					print "PESSOA LOGADA NÃO EXITE!";
				}
		}
		elseif($status=='RelatarConfiguracaoDoCampo'){
			return $this->relatarConfiguracaoDoCampoXML($login);
		}
	}
}
?>