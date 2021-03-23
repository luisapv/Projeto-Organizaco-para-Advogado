<?php
class ControllerLogin{
	private $login,$senha,$log,$dds,$val,$fct,$bd;
	
	public function setLogin($login,$senha){
		$this->bd		=	new DataBase;
		$this->fct		=	new ControllerFuncoes;
		$this->val		=	new ControllerValidacoes;
/*		
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
*/
		if(strlen(ltrim($login))<2){
			return 'Acesso Negado';
		}
		else{
			$this->login=$login;
		}
		if(strlen(ltrim($senha))>5){
			if($this->val->setValidaSenha($senha)){
				$this->senha=$senha;
			}
			else{
				return 'Acesso Negado';
			}
		}
		
		if((strlen(trim($login))>1) && (strlen(ltrim($senha))>5)){
			$this->log=$this->bd->selectDB('SELECT * FROM login WHERE nome=? && senha=?',array($this->login,$this->fct->setCripto($this->senha)));
		
			if($this->log && count($this->log)==1){
				foreach($this->log as $this->dds){
					session_start();
					$_SESSION['logado']=$this->dds;
//					header('location:../../../../../home.php');
//					return 'Logado!';
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