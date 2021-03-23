<?php
class ControllerProcesso{
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
	
	public function cadastrar($processo,$arquivo,$juiz,$trtTurma,$trtRelator,$tstTurma,$tstRelator,$autor,$advogadoA,$reu,$advogadoR,$fase,$motivo,$status){
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
		
		if(empty($status)){
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
			$this->bd->insertDB("INSERT INTO processo (n_processo, arquivo, juizDaSentenca, trtTurma, trtRelator, tstTurma, tstRelator, dataArquivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",array($processo, $arquivo, $juiz, $trtTurma, $trtRelator, $tstTurma, $tstRelator, $arquivoData));
			
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
	
	public function editar($processo,$antigoProcesso,$arquivo,$juiz,$trtTurma,$trtRelator,$tstTurma,$tstRelator,$autor,$advogadoA,$reu,$advogadoR,$fase,$motivo,$status){
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
		
		if(empty($status)){
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
			$this->bd->updateDB('UPDATE processo SET n_processo=?, descricao="", arquivo=?, juizdasentenca=?, trtturma=?, trtrelator=?, tstturma=?, tstrelator=?, dataarquivo=? WHERE n_processo=?',array($processo, $arquivo, $juiz, $trtTurma, $trtRelator, $tstTurma, $tstRelator, $arquivoData, $antigoProcesso));
			
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
			$files = array_diff(scandir($dir), array('.','..')); 
		    foreach ($files as $file) { 
		      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
		    } 
    		rmdir($dir);
			$this->bd = new DataBase;
			$this->bd->deleteDB('DELETE FROM processo WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM autor WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM reus WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM processo_fases WHERE n_processo=?',array($processo));
			$this->bd->deleteDB('DELETE FROM processo_motivos WHERE n_processo=?',array($processo));
		}
	}
}
?>