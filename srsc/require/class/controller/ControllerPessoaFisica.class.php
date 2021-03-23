<?php
class ControllerPessoaFisica{
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
	
	public function exibirPessoaFisica($cpf){
		if(!empty($cpf)){
			$this->bd = new DataBase;
			if($this->query = $this->bd->selectDB('SELECT * FROM pessoa WHERE cpf=?',array($cpf))){
				foreach($this->query as $pessoaJuridica){
					return 	'pessoaFisica;'.							//00
							$pessoaJuridica->cod_pessoa.';'.			//01
							$pessoaJuridica->nome.';'.					//02
							$pessoaJuridica->identidade.';'.			//03
							$pessoaJuridica->orgoao.';'.				//04
							$pessoaJuridica->cpf.';'.					//05
							$pessoaJuridica->profissao.';'.				//06
							$pessoaJuridica->observacao.';'.			//07
							$pessoaJuridica->email.';'.					//08
							$pessoaJuridica->logradouro.';'.			//09
							$pessoaJuridica->numero.';'.				//10
							$pessoaJuridica->complemento.';'.			//11
							$pessoaJuridica->bairro.';'.				//12
							$pessoaJuridica->cidade.';'.				//13
							$pessoaJuridica->municipio.';'.				//14
							$pessoaJuridica->cep.';'.					//15
							$pessoaJuridica->referencia.';'.			//16
							$pessoaJuridica->longitude.';'.				//17
							$pessoaJuridica->latitude;					//18
				}
			}
			else{
				return 'Pessoa não existe!';
			}
		}
		else{
			return 'Código em branco!';
		}
	}
	
	public function cadastrar($nome,$identidade,$orgao,$cpf,$profissao,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA CNPJ
		if(!empty($cpf)){
			if($this->bd->selectDB('SELECT true FROM pessoa WHERE cpf=?',array($cpf))){
				$msg .= $this->existe($msg).'Pessoa com cpf: "'.$cpf.'", já existe.';
			}
		}
		else{
			$msg .= $this->existe($msg).'CPF em branco!';
		}
		
		//VERIFICA Nome
		if(empty($nome)){
			$msg .= $this->existe($msg).'Nome em branco!';
		}
		
		//VERIFICA ENDEREDEÇO
		if(trim($logradouro)!='' || trim($bairro)!='' || trim($municipio)!='' || trim($estado)!='' || trim($cep)!=''){
			if(trim($logradouro)==''){
				$msg .= $this->existe($msg).'Logradouro em branco!';
			}
			if(trim($bairro)==''){
				$msg .= $this->existe($msg).'Bairro em branco!';
			}
			if(trim($municipio)==''){
				$msg .= $this->existe($msg).'Municipio em branco!';
			}
			if(trim($estado)==''){
				$msg .= $this->existe($msg).'Estado em branco!';
			}
		}
		
		if(!empty($msg)){
			return $msg;
		}
		else{
			//CADASTRAR EMPRESA
			$this->bd->insertDB('INSERT INTO pessoa (nome, identidade, orgoao, cpf, profissao, email, observacao, logradouro, numero, complemento, bairro, cidade, municipio, cep, cod_endereco, deletado, dataCadastro, idlogin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?, ?)',array($nome,$identidade,$orgao,$cpf,$profissao,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$dataCadastro,$login));
		}
	}
	
	public function editar($nome,$identidade,$orgao,$cpf,$antigocpf,$profissao,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA CNPJ
		if(!empty($cpf)){
			if($cpf!=$antigocpf)
			if($this->bd->selectDB('SELECT true FROM pessoa WHERE cpf=?',array($cpf))){
				$msg .= $this->existe($msg).'Pessoa com cpf: "'.$cpf.'", já existe.';
			}
		}
		else{
			$msg .= $this->existe($msg).'CPF em branco!';
		}
		
		//VERIFICA Razão Social
		if(empty($nome)){
			$msg .= $this->existe($msg).'Nome em branco!';
		}
		
		//VERIFICA ENDEREDEÇO
		if(trim($logradouro)!='' || trim($bairro)!='' || trim($municipio)!='' || trim($estado)!='' || trim($cep)!=''){
			if(trim($logradouro)==''){
				$msg .= $this->existe($msg).'Logradouro em branco!';
			}
			if(trim($bairro)==''){
				$msg .= $this->existe($msg).'Bairro em branco!';
			}
			if(trim($municipio)==''){
				$msg .= $this->existe($msg).'Municipio em branco!';
			}
			if(trim($estado)==''){
				$msg .= $this->existe($msg).'Estado em branco!';
			}
		}
		
		
		if(!empty($msg)){
			return $msg;
		}
		else
			//ATUALIZAR Pessoa
			$this->bd->updateDB('UPDATE pessoa SET nome=?, identidade=?, orgoao=?, cpf=?, profissao=?, email=?, observacao=?, logradouro=?, numero=?, complemento=?, bairro=?, cidade=?, municipio=?, cep=?, dataCadastro=?, idlogin=? WHERE cpf=?',array($nome,$identidade,$orgao,$cpf,$profissao,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$dataCadastro,$login,$antigocpf));
	}
	
	public function deletar($cpf){
		if(!empty($cpf)){
			$this->bd = new DataBase;
			$this->bd->deleteDB('DELETE FROM pessoa WHERE cpf=?',array($cpf));
		}
		else{
			return 'CPF em branco!';
		}
	}
}
?>