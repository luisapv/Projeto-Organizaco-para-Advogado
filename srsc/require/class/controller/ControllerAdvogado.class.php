<?php
class ControllerAdvogado{
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
	
	public function exibirAdvogado($oab){
		if(!empty($oab)){
		$documento=explode('//',$oab);
			$this->bd = new DataBase;
			if($this->query = $this->bd->selectDB('SELECT * FROM advogado WHERE oab=? AND estado=?',$documento)){
				foreach($this->query as $pessoaJuridica){
					return 	'Advogado;'.								//00
							$pessoaJuridica->cod_advogado.';'.			//01
							$pessoaJuridica->nome.';'.					//02
							$pessoaJuridica->oab.';'.					//03
							$pessoaJuridica->estado.';'.				//04
							$pessoaJuridica->data_da_expedicao;			//05
				}
			}
			else{
				return 'Advogado não existe!';
			}
		}
	}
	
	public function cadastrar($nome,$oab,$estado,$dataExpedicao=NULL,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA OAB
		if(!empty($oab) && !empty($estado)){
			if($this->bd->selectDB('SELECT true FROM advogado WHERE oab=? AND estado=?',array($oab,$estado))){
				if($query = $this->bd->selectDB('SELECT sigla FROM municipio WHERE cod_municipio=?',array($estado))){
					foreach($query as $uf){
						$msg .= $this->existe($msg).'Pessoa com OAB//UF: "'.$oab.'//'.$uf->sigla.'", já existe.';	
					}
				}
				else{
					$msg .= $this->existe($msg).'Pessoa com OAB: "'.$oab.'" deste estado, já existe.';
				}
			}
		}
		else{
			if(empty($oab))
				$msg .= $this->existe($msg).'OAB em branco!';
			if(empty($estado))
				$msg .= $this->existe($msg).'Estado em branco!';
		}
		
		//VERIFICA Nome
		if(empty($nome)){
			$msg .= $this->existe($msg).'Nome em branco!';
		}
		
		if(empty($dataExpedicao)){
			$dataExpedicao = '0000-00-00';
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else{
			//CADASTRAR ADVOGADO
				$this->bd->insertDB('INSERT INTO advogado (nome, oab, estado, data_da_expedicao, dataCadastro, idlogin) VALUES (?, ?, ?, ?, ?, ?)',array($nome,$oab,$estado,$dataExpedicao, $dataCadastro, $login));
		}
	}
	
	public function editar($nome,$oab,$antigooab,$estado,$antigoestado,$dataExpedicao=NULL,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA OAB
		if(!empty($oab) && !empty($estado)){
			if($oab!=$antigooab || $estado!=$antigoestado)
			if($this->bd->selectDB('SELECT true FROM advogado WHERE oab=? AND estado=?',array($oab,$estado))){
				if($query = $this->bd->selectDB('SELECT sigla FROM municipio WHERE cod_municipio=?',array($estado))){
					foreach($query as $uf){
						$msg .= $this->existe($msg).'Pessoa com OAB//UF: "'.$oab.'//'.$uf->sigla.'", já existe.';	
					}
				}
				else{
					$msg .= $this->existe($msg).'Pessoa com OAB: "'.$oab.'" deste estado, já existe.';
				}
			}
		}
		else{
			if(empty($oab))
				$msg .= $this->existe($msg).'OAB em branco!';
			if(empty($estado))
				$msg .= $this->existe($msg).'Estado em branco!';
		}
		
		//VERIFICA Razão Social
		if(empty($nome)){
			$msg .= $this->existe($msg).'Nome em branco!';
		}
		
		if(empty($dataExpedicao)){
			$dataExpedicao = '0000-00-00';
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else
			//ATUALIZAR Pessoa
			$this->bd->updateDB('UPDATE advogado SET nome=?, oab=?, estado=?,  data_da_expedicao=?, dataCadastro=?, idlogin=? WHERE oab=? AND estado=?',array($nome,$oab,$estado,$dataExpedicao,$dataCadastro,$login,$antigooab,$antigoestado));
	}
	
	public function deletar($oab, $estado){
		$msg='';
		if(!empty($oab) && !empty($estado)){
			$this->bd = new DataBase;
			$this->bd->deleteDB('DELETE FROM advogado WHERE oab=? AND estado=?',array($oab,$estado));
		}
		else{
			if(empty($oab)){
				$msg .= $this->existe($msg).'OAB em Branco!';
			}
			if(empty($estado)){
				$msg .= $this->existe($msg).'Estado em Branco!';
			}
			if(!empty($msg)){
				return $msg;
			}
		}
	}
}
?>