<?php
class Login{
	private $login,$senha,$log,$dds,$val,$fct,$bd;
	
	public function setLogin($login,$senha){
		$this->bd		=	new DataBase;
		$this->fct		=	new Funcoes;
		$this->val		=	new Validacoes;
		
		if(strlen(trim($login))==11){
			if($this->val->setValidaCPF($login)){
				$this->login=$login;
			}
			else{
				return 'Acesso Negado';
			}
		}
		if(strlen(trim($login))==14){
			if($this->val->setValidaCNPJ($login)){
				$this->login=$login;
			}
			else{
				return 'Acesso Negado';
			}
		}
		if(strlen(ltrim($senha))>7){
			if($this->val->setValidaSenha($senha)){
				$this->senha=$senha;
			}
			else{
				return 'Acesso Negado';
			}
		}
		
		if(((strlen(trim($login))==11) || (strlen(trim($login))==14)) && (strlen(ltrim($senha))>7)){
			$this->log=$this->bd->selectDB('SELECT * FROM cliente WHERE cod_Cliente=? && senha=?',array($this->login,$this->fct->setCripto($this->senha)),'Cliente');
		
			if($this->log && count($this->log)==1){
				foreach($this->log as $this->dds){
					$_SESSION['logado']=$this->dds;
//					header('location:../../../../../index.php');
				}
			}
			else{
				return "Acesso Negado";
			}
		}
		else{
				return 'Acesso Negado';
		}
	}
}
?>