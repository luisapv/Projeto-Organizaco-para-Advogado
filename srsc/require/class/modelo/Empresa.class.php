<?php
class Empresa{
	private $razao_social;
	private $nome_fantasia;
	private $cnpj;
	private $observacao;
	private $deletado;
	private $cod_endereco;
	private $pessoa_responsavel;
	private $email;
	private $logradouro;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $municipio;
	private $cep;
	
	public function getRazao_Social(){
		return $this->razao_social;
	}
	
	public function setRazao_Social($value){
		$this->razao_social=$value;
	}
	
	public function getNome_Fantasia(){
		return $this->nome_fantasia;
	}
	
	public function setNome_Fantasia($value){
		$this->nome_fantasia=$value;
	}
	
	public function getCnpj(){
		return $this->cnpj;
	}
	
	public function setCnpj($value){
		$this->cnpj=$value;
	}
	
	public function getObservacao(){
		return $this->observacao;
	}
	
	public function setObservacao($value){
		$this->observacao=$value;
	}
	
	public function getCod_Endereco(){
		return $this->cod_endereco;
	}
	
	public function setCod_Endereco($value){
		$this->cod_endereco=$value;
	}
	
	public function getPessoa_Responsavel(){
		return $this->pessoa_responsavel;
	}
	
	public function setPessoa_Responsavel($value){
		$this->pessoa_responsavel=$value;
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
}
?>