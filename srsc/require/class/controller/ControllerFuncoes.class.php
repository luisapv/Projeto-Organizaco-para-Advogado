<?php
class ControllerFuncoes{
	private $bd;
	private $filteIn;
	private $query;
	
	public function getSiglaUF($estado){
		$this->bd = new DataBase;
		if($this->query = $this->bd->selectDB('SELECT sigla FROM municipio WHERE cod_municipio=?',array($estado))){
			foreach($this->query as $uf)
				return $uf->sigla;
		}
	}
	
	public function setCripto($param){
		#md5($param); //32 caracteres
		#sha1($param); //40 caracteres
		#hash('sha256',$param); //64 caracteres
		#hash('sha384',$param); //96 caracteres
		#hash('sha512',$param); //128 caracteres
		#hash('whirlpool',$param); //128 caracteres
		
		return hash('sha512',hash('sha512',hash('sha384',hash('sha256',sha1(md5($param))))));
	}
}
?>