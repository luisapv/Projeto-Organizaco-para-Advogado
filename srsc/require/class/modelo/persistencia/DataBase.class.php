<?php
/*
function __autoload($class){
	$raiz	=	$_SERVER['DOCUMENT_ROOT'];
	if(file_exists($raiz.'/require/class/controller/'.$class.'.class.php'))
		require_once($raiz.'/require/class/controller/'.$class.'.class.php');
	elseif(file_exists($raiz.'/require/class/modelo/'.$class.'.class.php'))
		require_once($raiz.'/require/class/modelo/'.$class.'.class.php');
	elseif(file_exists($raiz.'/require/class/modelo/persistencia/'.$class.'.class.php'))
		require_once($raiz.'/require/class/modelo/persistencia/'.$class.'.class.php');
}
*/
class DataBase{
    /*Metado construtor do banco de dados*/
    //private function __construct(){}
     
    /*Evita que a classe seja clonada*/
    private function __clone(){}
     
	//Metado que destroi a conexão com banco de dados e remove da mem�ria todas as variᶥis setadas
    public function __destruct() {
        $this->disconnect();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }
     
    private static $dbtype   = "mysql";
    private static $host     = "localhost";
    private static $port     = "3306";
    private static $user     = "Admin";
    private static $password = "admin";
    private static $db       = "base_mala_direta";
    private static $charSet	 = "SET CHARACTER SET utf8";
    private	static $conn;
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    private function getDBType()  	{return self::$dbtype;}
    private function getHost()    	{return self::$host;}
    private function getPort()    	{return self::$port;}
    private function getUser()    	{return self::$user;}
    private function getPassword()	{return self::$password;}
    private function getDB()      	{return self::$db;}
    private function getCharSet()  	{return self::$charSet;}
    private function getConn()		{return self::$conn;}
     
    private function connect(){
        try
        {
            $this->conexao = new PDO($this->getDBType().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB(), $this->getUser(), $this->getPassword());
            $this->conexao->exec($this->getCharSet());
        }
        catch (PDOException $i)
        {
            //se houver exce磯, exibe
            die("Erro: <code>" . $i->getMessage() . "</code>");
        }
         
        return ($this->conexao);
    }
     
    private function disconnect(){
        $this->conexao = null;
    }
    
    /*Metado select que retorna TRUE ou False da consulta*/
    public function existeSelectDB($sql,$params=null){
		$query=$this->connect()->prepare($sql);
        $query->execute($params);
        if($query->rowCount()>0){
        	return true;
        }
        else{
        	return false;
        }
	}
    
    /*Metado select que retorna TRUE ou False da consulta*/
    public function quantSelectDB($sql,$params=null){
		$query=$this->connect()->prepare($sql);
        $query->execute($params);
        return $query->rowCount();
	}
     
    /*Metado select que retorna um VO ou um array de objetos*/
    public function selectDB($sql,$params=null,$class=null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);
        
        if($query->rowCount()>0){
    	    if(isset($class)){
    	    	new $class;
	            $rs = $query->fetchAll(PDO::FETCH_CLASS,$class);// or die(print_r($query->errorInfo(), true));
        	}else{
            	$rs = $query->fetchAll(PDO::FETCH_OBJ);// or die(print_r($query->errorInfo(), true));
        	}	
		}
		else{
			$rs = FALSE;
		}
        self::__destruct();
        return $rs;
    }
     
    /*Metado insert que insere valores no banco de dados e retorna o último id inserido*/
    public function insertDB($sql,$params=null){
        $conexao=$this->connect();
        $query=$conexao->prepare($sql);
        $query->execute($params);
        $rs = $conexao->lastInsertId();// or die(print_r($query->errorInfo(), true));
        self::__destruct();
        return $rs;
    }
    
    /*Metado update que altera valores do banco de dados e retorna o número de linhas afetadas*/
    public function updateDB($sql,$params=null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);
        $rs = $query->rowCount();// or die(print_r($query->errorInfo(), true));
        self::__destruct();
        return $rs;
    }
     
    /*Metado delete que exclu�alores do banco de dados retorna o n�mero de linhas afetadas*/
    public function deleteDB($sql,$params=null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);
        $rs = $query->rowCount();// or die(print_r($query->errorInfo(), true));
        self::__destruct();
        return $rs;
    }
}
?>