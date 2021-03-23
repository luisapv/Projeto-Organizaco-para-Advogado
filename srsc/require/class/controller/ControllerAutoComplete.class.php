<?php
class ControllerAutoComplete{
	private $bd,$query;
	
	public function autoCompleteAutor($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT p.nome FROM pessoa AS p WHERE p.nome LIKE (?) ORDER BY p.nome",array($val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setAutorAC(\''.$value->nome.'\')">'.$value->nome.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteReu($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT e.razao_social FROM empresa AS e WHERE e.razao_social LIKE (?) ORDER BY e.razao_social",array($val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setReuAC(\''.$value->razao_social.'\')">'.$value->razao_social.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteAdvogadoAutor($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT a.nome FROM advogado AS a WHERE a.nome LIKE (:nome) ORDER BY a.nome",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setAdvogadoAAC(\''.$value->nome.'\')">'.$value->nome.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteAdvogadoReu($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT a.nome FROM advogado AS a WHERE a.nome LIKE (:nome) ORDER BY a.nome",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setAdvogadoRAC(\''.$value->nome.'\')">'.$value->nome.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteFases($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT f.nome FROM fases AS f WHERE f.nome LIKE (:nome) ORDER BY f.nome",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setFasesAC(\''.$value->nome.'\')">'.$value->nome.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteMotivos($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT m.nome FROM motivos AS m WHERE m.nome LIKE (:nome) ORDER BY m.nome",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setMotivosAC(\''.$value->nome.'\')">'.$value->nome.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteCep($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT cep FROM pessoa WHERE cep IN (SELECT cep FROM empresa) AND cep LIKE (:nome)
UNION
SELECT DISTINCT cep FROM pessoa WHERE cep NOT IN (SELECT cep FROM empresa) AND cep LIKE (:nome)
ORDER BY cep",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setCepAC(\''.$value->cep.'\')">'.$value->cep.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteLogradouro($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT logradouro FROM pessoa WHERE logradouro IN (SELECT logradouro FROM empresa) AND logradouro LIKE (:nome)
UNION
SELECT DISTINCT logradouro FROM pessoa WHERE logradouro NOT IN (SELECT logradouro FROM empresa) AND logradouro LIKE (:nome)
ORDER BY logradouro",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setLogradouroAC(\''.$value->logradouro.'\')">'.$value->logradouro.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteBairro($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT bairro FROM pessoa WHERE bairro IN (SELECT bairro FROM empresa) AND bairro LIKE (:nome)
UNION
SELECT DISTINCT bairro FROM pessoa WHERE bairro NOT IN (SELECT bairro FROM empresa) AND bairro LIKE (:nome)
ORDER BY bairro",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setBairroAC(\''.$value->bairro.'\')">'.$value->bairro.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoCompleteMunicipio($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT cidade FROM pessoa WHERE cidade IN (SELECT cidade FROM empresa) AND cidade LIKE (:nome)
UNION
SELECT DISTINCT cidade FROM pessoa WHERE cidade NOT IN (SELECT cidade FROM empresa) AND cidade LIKE (:nome)
ORDER BY cidade",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setMunicipioAC(\''.$value->cidade.'\')">'.$value->cidade.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoTrtRelator($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT trtRelator FROM processo WHERE trtRelator LIKE (:nome)",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setTrtRelatorAC(\''.$value->trtRelator.'\')">'.$value->trtRelator.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoTstRelator($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT tstRelator FROM processo WHERE tstRelator LIKE (:nome)",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setTstRelatorAC(\''.$value->tstRelator.'\')">'.$value->tstRelator.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoProfissao($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT profissao FROM pessoa WHERE profissao LIKE (:nome)",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setProfissaoAC(\''.$value->profissao.'\')">'.$value->profissao.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
	
	public function autoJuiz($val){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB("SELECT DISTINCT juizDaSentenca FROM processo WHERE juizDaSentenca LIKE (:nome)",array(':nome' => $val.'%'))){
			$msg = '';
			foreach($this->query as $value){
				$msg .= '<li onclick="setJuizAC(\''.$value->juizDaSentenca.'\')">'.$value->juizDaSentenca.'</li>';
			}
			return $msg;
		}
		else{
			return '';
		}
	}
}
?>