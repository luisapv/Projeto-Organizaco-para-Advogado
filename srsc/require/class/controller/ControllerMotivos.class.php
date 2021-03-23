<?php
class ControllerMotivos{
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
	
	public function exibirMotivos($cod){
		if(!empty($cod)){
			$this->bd = new DataBase;
			if($this->query = $this->bd->selectDB('SELECT * FROM motivos WHERE idMotivos=?',array($cod))){
				foreach($this->query as $Motivos){
					return 	'Motivos;'.					//00
							$Motivos->idMotivos.';'.	//01
							$Motivos->nome.';'.			//02
							$Motivos->descricao;		//03
				}
			}
			else{
				return 'Motivo não existe!';
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
			if($this->bd->selectDB('SELECT true FROM motivos WHERE nome=?',array($nome))){
				$msg .= $this->existe($msg).'Motivo já existe!';
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
				$this->bd->insertDB('INSERT INTO motivos (nome, descricao, dataCadastro, idlogin) VALUES (?, ?, ?, ?)',array($nome,$descricao,$dataCadastro,$login));
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
			if($this->bd->selectDB('SELECT true FROM motivos WHERE nome=?',array($nome))){
				$msg .= $this->existe($msg).'Motivo já existe!';
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
			$this->bd->updateDB('UPDATE motivos SET nome=?, descricao=?, dataCadastro=?, idlogin=? WHERE idMotivos=?',array($nome,$descricao,$dataCadastro,$login,$cod));
	}
	
	public function deletar($cod){
		if(!empty($cod)){
			$this->bd = new DataBase;
			$this->bd->deleteDB('DELETE FROM motivos WHERE idMotivos=?',array($cod));
		}
		else{
			return 'Código em branco!';
		}
	}
}
?>