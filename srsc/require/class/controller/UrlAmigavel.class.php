<?php
class UrlAmigavel{
	private $param, $r_URL, $id;

	public function setParam($param){
		$this->param = $param;
	}

	public function setR_URL($r_URL){
		$this->r_URL = $r_URL;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getParam(){
		return $this->param;
	}

	public function getR_URL(){
		return $this->r_URL;
	}

	public function getId(){
		return $this->id;
	}
	
	public function setUrlAmigavel($param){
		$this->setParam($param);
		
		if($this->getParam()){
			$this->setR_URL(explode('/',substr($this->getParam(),1)));
			if(substr($this->getParam(),-1,1)=='/')
					return('404.php');
			elseif(file_exists($this->getR_URL()[0].'.php'))
				return ($this->getR_URL()[0].'.php');
			elseif(file_exists($this->getR_URL()[0].'/'.$this->getR_URL()[1].'.php'))
				return ($this->getR_URL()[0].'/'.$this->getR_URL()[1].'.php');
			elseif(file_exists($this->getR_URL()[0].'/'.$this->getR_URL()[1].'/'.$this->getR_URL()[2].'.php'))
				return ($this->getR_URL()[0].'/'.$this->getR_URL()[1].'/'.$this->getR_URL()[2].'.php');
			else
				return ('404.php');
		}
		else{
			return ("home.php");
		}
	}
}
?>