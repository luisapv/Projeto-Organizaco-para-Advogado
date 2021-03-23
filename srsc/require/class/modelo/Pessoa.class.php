<?php
class Pessoa{
	private $nome;
	private $data_nascimento;
	private $identidade;
	private $orgoao;
	private $data_da_expedicao;
	private $observacao;
	private $cpf;
	private $deletado;
	private $cod_endereco;
	private $email;
	private $logradouro;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $municipio;
	private $cep;
	private $profissao;
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($value){
		$this->nome=$value;
	}
	
	public function getData_Nascimento(){
		return $this->data_nascimento;
	}
	
	public function setData_Nascimento($value){
		$this->data_nascimento=$value;
	}
	
	public function getIdentidade(){
		return $this->identidade;
	}
	
	public function setIdentidade($value){
		$this->identidade=$value;
	}
	
	public function getOrgoao(){
		return $this->orgoao;
	}
	
	public function setOrgoao($value){
		$this->orgoao=$value;
	}
	
	public function getData_Da_Expedicao(){
		return $this->data_da_expedicao;
	}
	
	public function setData_Da_Expedicao($value){
		$this->data_da_expedicao=$value;
	}
	
	public function getObservacao(){
		return $this->observacao;
	}
	
	public function setObservacao($value){
		$this->observacao=$value;
	}
	
	public function getCpf(){
		return $this->cpf;
	}
	
	public function setCpf($value){
		$this->cpf=$value;
	}
	
	public function getDeletado(){
		return $this->deletado;
	}
	
	public function setDeletado($value){
		$this->deletado=$value;
	}
	
	public function getCod_Endereco(){
		return $this->cod_endereco;
	}
	
	public function setCod_Endereco($value){
		$this->cod_endereco=$value;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($value){
		$this->email=$value;
	}
	
	public function getLogradouro(){
		return $this->logradouro;
	}
	
	public function setLogradouro($value){
		$this->logradouro=$value;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function setNumero($value){
		$this->numero=$value;
	}
	
	public function getComplemento(){
		return $this->complemento;
	}
	
	public function setComplemento($value){
		$this->complemento=$value;
	}
	
	public function getBairro(){
		return $this->bairro;
	}
	
	public function setBairro($value){
		$this->bairro=$value;
	}
	
	public function getCidade(){
		return $this->cidade;
	}
	
	public function setCidade($value){
		$this->cidade=$value;
	}
	
	public function getMunicipio(){
		return $this->municipio;
	}
	
	public function setMunicipio($value){
		$this->municipio=$value;
	}
	
	public function getCep(){
		return $this->cep;
	}
	
	public function setCep($value){
		$this->cep=$value;
	}
	
	public function getProfissao(){
		return $this->profissao;
	}
	
	public function setProfissao($value){
		$this->profissao=$value;
	}
}
?>