<?php
class ControllerFases{
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
	
	public function exibirFases($cod){
		if(!empty($cod)){
			$this->bd = new DataBase;
			if($this->query = $this->bd->selectDB('SELECT * FROM fases WHERE idFases=?',array($cod))){
				foreach($this->query as $Fases){
					return 	'Fases;'.				//00
							$Fases->idFases.';'.	//01
							$Fases->nome.';'.		//02
							$Fases->descricao;		//03
				}
			}
			else{
				return 'Fase não existe!';
			}
		}
		else{
			return 'Código em branco!';
		}
	}
	
	public function cadastrar($nome,$descricao=NULL,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA OAB
		if(!empty($nome)){
			if($this->bd->selectDB('SELECT true FROM fases WHERE nome=?',array($nome))){
				$msg .= $this->existe($msg).'Fase já existe!';
			}
		}
		else{
			$msg .= $this->existe($msg).'Nome em branco!';
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else{
			//CADASTRAR EMPRESA
				$this->bd->insertDB('INSERT INTO fases (nome, descricao, dataCadastro, idlogin) VALUES (?, ?, ?, ?)',array($nome,$descricao,$dataCadastro,$login));
		}
	}
	
	public function editar($cod,$nome,$nomeAnterior,$descricao=NULL,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA Nome
		if(!empty($nome)){
			if($nome!=$nomeAnterior)
			if($this->bd->selectDB('SELECT true FROM fases WHERE nome=?',array($nome))){
				$msg .= $this->existe($msg).'Fase já existe!';
			}
		}
		else{
			$msg .= $this->existe($msg).'Nome em branco!';
		}
		
		//VERIFICA Código
		if(empty($cod)){
			$msg .= $this->existe($msg).'Código em branco!';
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else
			//ATUALIZAR Pessoa
			$this->bd->updateDB('UPDATE fases SET nome=?, descricao=?, dataCadastro=?, idlogin=? WHERE idFases=?',array($nome,$descricao,$dataCadastro,$login,$cod));
	}
	
	public function deletar($cod){
		if(!empty($cod)){
			$this->bd = new DataBase;
			$this->bd->deleteDB('DELETE FROM fases WHERE idFases=?',array($cod));
		}
		else{
			return 'Código em branco!';
		}
	}
}
?>