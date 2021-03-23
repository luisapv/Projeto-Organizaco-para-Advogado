<?php
class ControllerPessoaJuridica{
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
	
	public function exibirPessoaJuridica($cnpj){
		if(!empty($cnpj)){
			$this->bd = new DataBase;
			if($this->query = $this->bd->selectDB('SELECT * FROM empresa WHERE cnpj=?',array($cnpj))){
				foreach($this->query as $pessoaJuridica){
					return 	'pessoaJuridica;'.							//00
							$pessoaJuridica->cod_empresa.';'.			//01
							$pessoaJuridica->razao_social.';'.			//02
							$pessoaJuridica->nome_fantasia.';'.			//03
							$pessoaJuridica->cnpj.';'.					//04
							$pessoaJuridica->observacao.';'.			//05
							$pessoaJuridica->deletado.';'.				//06
							$pessoaJuridica->cod_endereco.';'.			//07
							$pessoaJuridica->pessoa_responsavel.';'.	//08
							$pessoaJuridica->email.';'.					//09
							$pessoaJuridica->logradouro.';'.			//10
							$pessoaJuridica->numero.';'.				//11
							$pessoaJuridica->complemento.';'.			//12
							$pessoaJuridica->bairro.';'.				//13
							$pessoaJuridica->cidade.';'.				//14
							$pessoaJuridica->municipio.';'.				//15
							$pessoaJuridica->cep.';'.					//16
							$pessoaJuridica->referencia.';'.			//17
							$pessoaJuridica->longitude.';'.				//18
							$pessoaJuridica->latitude;					//19
				}
//				return $pJ;
			}
			else{
				return 'Empresa não existe!';
			}
		}
		else{
			return 'Código em branco!';
		}
	}
	
	public function cadastrar($razaoSocial,$nomeFantasia,$cnpj,$pessoaResponsavel,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA CNPJ
		if(!empty($cnpj)){
			if($this->bd->selectDB('SELECT true FROM empresa WHERE cnpj=?',array($cnpj)) && $cnpj!='00'){
				$msg .= $this->existe($msg).'Empresa com cnpj: "'.$cnpj.'", já existe.';
			}
		}
		else{
			$msg .= $this->existe($msg).'CNPJ em branco!';
		}
		
		//VERIFICA Razão Social
		if(empty($razaoSocial)){
			$msg .= $this->existe($msg).'Razão Social em branco!';
		}
		
		//VERIFICA Nome Fantasia
		if(empty($nomeFantasia)){
			$msg .= $this->existe($msg).'Nome Fantasia em branco!';
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
			$this->bd->insertDB('INSERT INTO empresa (razao_social, nome_fantasia, cnpj, observacao, cod_endereco, deletado, pessoa_responsavel, email, logradouro, numero, complemento, bairro, cidade, municipio, cep, dataCadastro, idlogin) VALUES (?, ?, ?, ?, 0, 0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',array($razaoSocial, $nomeFantasia, $cnpj, $observacao, $pessoaResponsavel, $email, $logradouro, $numero, $complemento, $bairro, $municipio, $estado, $cep, $dataCadastro, $login));
		}
	}
	
	public function editar($razaoSocial,$nomeFantasia,$cnpj,$antigocnpj,$pessoaResponsavel,$email,$observacao,$logradouro,$numero,$complemento,$bairro,$municipio,$estado,$cep,$login){
		$this->bd = new DataBase;
		$this->filteIn = new ControllerValidacoes;
		$msg = '';
		
		$dataCadastro = date('Y-m-d');
		
		//VERIFICA CNPJ
		if(!empty($cnpj)){
			if($cnpj!=$antigocnpj)
			if($this->bd->selectDB('SELECT true FROM empresa WHERE cnpj=?',array($cnpj))){
				$msg .= $this->existe($msg).'Empresa com cnpj: "'.$cnpj.'", já existe.';
			}
		}
		else{
			$msg .= $this->existe($msg).'CNPJ em branco!';
		}
		
		//VERIFICA Razão Social
		if(empty($razaoSocial)){
			$msg .= $this->existe($msg).'Razão Social em branco!';
		}
		
		//VERIFICA Nome Fantasia
		if(empty($nomeFantasia)){
			$msg .= $this->existe($msg).'Nome Fantasia em branco!';
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
			//ATUALIZAR EMPRESA
			$this->bd->updateDB('UPDATE empresa SET razao_social=?, nome_fantasia=?, cnpj=?, observacao=?, cod_endereco=0, pessoa_responsavel=?, email=?, logradouro=?, numero=?, complemento=?, bairro=?, cidade=?, municipio=?, cep=?, dataCadastro=?, idlogin=? WHERE cnpj=?',array($razaoSocial, $nomeFantasia, $cnpj, $observacao, $pessoaResponsavel, $email, $logradouro, $numero, $complemento, $bairro, $municipio, $estado, $cep, $dataCadastro, $login, $antigocnpj));
	}
	
	public function deletar($cnpj){
		if(!empty($cnpj)){
			$this->bd = new DataBase;		
			$this->bd->deleteDB('DELETE FROM empresa WHERE cnpj=?',array($cnpj));
		}
		else{
			return 'CNPJ em branco!';
		}
	}
}
?>