<?php

	//	Para adicionar um contato é necessário uma observação e um status na alteração para após 
	//	adicionar o contato juntamente com a alteração.
	
	// 	Aquivos necessários para o insert.
	include_once('../conexao.php');
	include_once('../function.php');
	
	function CadastrarPessoais($matricula, $nome, $data_de_nascimento, $cpf, $rg, $categoria, $conn){
		// Adiciona associado.
		
		// Converte a data para cadastrar data de nascimento.
		
		if($data_de_nascimento){
			$aux = explode('/', $data_de_nascimento);
			$data_de_nascimento  = ($aux[2]?($aux[2]>3000?'0000':$aux[2]):'0000').'-';
			$data_de_nascimento .= ($aux[1]?($aux[1]>    12?'00':$aux[1]):'00').'-';
			$data_de_nascimento .= ($aux[0]?($aux[0]>    31?'00':$aux[0]):'00');
		}else{
			$data_de_nascimento = '0000-00-00';
		}
		
		if(!(isset($cpf))){
			$aux = explode('.', $cpf);
			$cpf  = $aux[0].$aux[1].$aux[2];
			$aux = explode('-', $cpf);
			$cpf  = $aux[0].$aux[1];
		}else{
			$cpf = NULL;
		}
		
		$sql = '
			INSERT INTO 
				`cefal-rs`.`cefal-rs_associados` (
					`cefal-rs_associado_id`, 
					`cefal-rs_associado_matricula`, 
					`cefal-rs_associado_nome`, 
					`cefal-rs_associado_data_nascimento`, 
					`cefal-rs_associado_cpf`, 
					`cefal-rs_associado_rg`, 

					`cefal-rs_associado_foto`,
					`cefal-rs_categoria_id`,
					`cefal-rs_coordenadoria_id`, 
					`cefal-rs_gabinete_id`, 
					`cefal-rs_setor_id`, 
					`cefal-rs_banco_id`, 
					`cefal-rs_contabilidade_id`, 
					
					`cefal-rs_associado_data_criacao`, 
					`cefal-rs_associado_data_edicao`, 
					
					`cefal-rs_administrador_id`, 
					`cefal-rs_associado_status`
				) 
				VALUES (
					NULL,
					'.$matricula.',
					"'.$nome.'",
					"'.$data_de_nascimento.'",
					"'.$cpf.'",
					"'.$rg.'",
					
					NULL,
					'.$categoria.',					
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					
					NOW(),
					NOW(),
					
					0,
					1
				)
			;
		';
		// echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());
		$retorno = mysql_insert_id();
		return $retorno;
	}	
	
	function CadastrarTelefones($retorno, $telefones, $conn){		
		$telefones = preg_split('((\&)?adicionar_telefones\=)', urldecode($telefones));
		$count = count($telefones);
		$i = 1;
		while($i < $count){		
			if(($telefones[$i] != '')&&($telefones[$i] != NULL)){
				$sql = '
					INSERT INTO 
						`cefal-rs_telefones`(
							`cefal-rs_telefone_id`, 
							`cefal-rs_telefone`, 
							`cefal-rs_tabela`, 
							`cefal-rs_tabela_id`, 
							`cefal-rs_telefone_data_criacao`, 
							`cefal-rs_telefone_data_edicao`, 
							`cefal-rs_administrador_id`, 
							`cefal-rs_telefone_status`
						)
						VALUES(
							NULL,
							"'.$telefones[$i].'",
							"cefal-rs_associados",
							'.$retorno.',
							
							NOW(),
							NOW(),
							
							0,
							1						
						)
					;
				';				
				$query = mysql_query($sql, $conn) or die(mysql_error());				
			}
			$i++;
		}
		return($retorno);		
	}

	function CadastrarEmails($retorno, $emails, $conn){		
		$emails = preg_split('((\&)?adicionar_emails\=)', urldecode($emails));
		$count = count($emails);
		$i = 1;
		while($i < $count){		
			if(($emails[$i] != '')&&($emails[$i] != NULL)){
				$sql = '
					INSERT INTO 
						`cefal-rs_emails`(
							`cefal-rs_email_id`, 
							`cefal-rs_email`, 
							`cefal-rs_tabela`, 
							`cefal-rs_tabela_id`, 
							`cefal-rs_email_data_criacao`, 
							`cefal-rs_email_data_edicao`, 
							`cefal-rs_administrador_id`, 
							`cefal-rs_email_status`
						)
						VALUES(
							NULL,
							"'.$emails[$i].'",
							"cefal-rs_associados",
							'.$retorno.',
							
							NOW(),
							NOW(),
							
							0,
							1						
						)
					;
				';				
				$query = mysql_query($sql, $conn) or die(mysql_error());				
			}
			$i++;
		}
		return($retorno);		
	}	
	
	function CadastrarEndereco($retorno, $logradouro, $cep, $bairro, $municipio, $conn){
		$sql = '
			INSERT INTO 
				`cefal-rs_enderecos`(
					`cefal-rs_endereco_id`, 
					`cefal-rs_endereco_logradouro`, 
					`cefal-rs_endereco_cep`, 
					`cefal-rs_municipio_id`, 
					`cefal-rs_endereco_bairro`, 
					`cefal-rs_associado_id` ,
					`cefal-rs_endereco_data_criacao`, 
					`cefal-rs_endereco_data_edicao`, 
					`cefal-rs_administrador_id`, 
					`cefal-rs_endereco_status`
				)
				VALUES(
					NULL,
					"'.$logradouro.'",
					"'.$cep.'",
					"'.$municipio.'",
					"'.$bairro.'",
					'.$retorno.',
					
					NOW(),
					NOW(),
					
					0,
					1						
				)
			;
		';
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($retorno);
	}
	
	function CadastrarDependentes($retorno, $nome_dependente, $data_de_nascimento_dependente, $conn){
		$nome_dependente 				= preg_split('((\&)?adicionar_nomes_dependentes\=)', urldecode($nome_dependente), -1, PREG_SPLIT_NO_EMPTY);
		$data_de_nascimento_dependente	= preg_split('((\&)?adicionar_datas_de_nascimentos_dependentes\=)', urldecode($data_de_nascimento_dependente), -1, PREG_SPLIT_NO_EMPTY);
		$count							= count($nome_dependente);
		$i								= 0;
		
		while($i < $count){
			if(($nome_dependente[$i] != '')&&($nome_dependente[$i] != NULL)){
				if($data_de_nascimento_dependente[$i]){
					$aux = explode('/', $data_de_nascimento_dependente[$i]);					
					$data_de_nascimento_dependente_sql  = ($aux[2]?($aux[2]>3000?'0000':$aux[2]):'0000').'-';
					$data_de_nascimento_dependente_sql .= ($aux[1]?($aux[1]>12?'00':$aux[1]):'00').'-';
					$data_de_nascimento_dependente_sql .= ($aux[0]?($aux[0]>31?'00':$aux[0]):'00');
				}else{
					$data_de_nascimento_dependente_sql = '0000-00-00';
				}
				$sql = '
					INSERT INTO 
						`cefal-rs_dependentes`(
							`cefal-rs_dependente_id`, 
							`cefal-rs_dependente_nome`, 
							`cefal-rs_dependente_data_nascimento`,
							`cefal-rs_associado_id`,
							`cefal-rs_dependente_data_criacao`, 
							`cefal-rs_dependente_data_edicao`, 
							`cefal-rs_administrador_id`, 
							`cefal-rs_dependente_status`
						)
						VALUES(
							NULL,
							"'.$nome_dependente[$i].'",
							"'.$data_de_nascimento_dependente_sql.'",
							'.$retorno.',
							
							NOW(),
							NOW(),
							
							0,
							1						
						)
					;
				';
				$query = mysql_query($sql, $conn) or die(mysql_error());			
			}
			$i++;
		}
		return($retorno);			
	}
	
	function CadastrarBanco($retorno, $banco_nome, $banco_agencia, $banco_conta, $conn){
		$sql = '
			INSERT INTO 
				`cefal-rs_bancos`(
					`cefal-rs_banco_id`, 
					`cefal-rs_banco_nome`, 
					`cefal-rs_banco_agencia`, 
					`cefal-rs_banco_conta`, 
					`cefal-rs_associado_id`, 
					`cefal-rs_banco_data_edicao`, 
					`cefal-rs_banco_data_criacao`, 
					`cefal-rs_admintrador_id`, 
					`cefal-rs_banco_status`
				)
				VALUES(
					NULL,
					"'.$banco_nome.'",
					"'.$banco_agencia.'",
					"'.$banco_conta.'",
					'.$retorno.',
					
					NOW(),
					NOW(),
					
					0,
					1						
				)
			;
		';
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($retorno);
	}

	function CadastrarContabel($retorno, $salario, $limite_credito, $limite_usado, $conn){

		$salario 		= toDeceimal($salario);
		$limite_credito = toDeceimal($limite_credito);
		$limite_usado 	= toDeceimal($limite_usado);
	
		$sql = '
			INSERT INTO 
				`cefal-rs_contabilidade`(
					`cefal-rs_contabilidade_id`, 
					`cefal-rs_contabilidade_salario`, 
					`cefal-rs_contabilidade_credito`, 
					`cefal-rs_contabilidade_credito_usado`, 
					`cefal-rs_associado_id`, 
					`cefal-rs_contabilidade_data_criacao`, 
					`cefal-rs_contabilidade_data_edicao`, 
					`cefal-rs_administrador_id`, 
					`cefal-rs_contabilidade_status`
				)
				VALUES(
					NULL,
					'.$salario.',
					'.$limite_credito.',
					'.$limite_usado.',
					'.$retorno.',
					
					NOW(),
					NOW(),
					
					0,
					1						
				)
			;
		';
		$query = mysql_query($sql, $conn) or die(mysql_error());
		$contabel = mysql_insert_id();
		$sql = '				
			UPDATE `cefal-rs_associados` SET
				`cefal-rs_contabilidade_id` = '.$contabel.'
			WHERE
				`cefal-rs_associado_id` = '.$retorno.'
			;
		';
		
		//echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($retorno);
	}
	
	function CadastrarDadoAL($retorno, $gabinete, $categoria, $setor, $coordenadoria, $conn){

		$sql = '
			INSERT INTO 
				`cefal-rs_gabinetes`(
					`cefal-rs_gabinete_id`, 
					`cefal-rs_gabinete_nome`, 
					`cefal-rs_associado_id`, 
					`cefal-rs_partido_id`, 
					`cefal-rs_gabinete_data_criacao`, 
					`cefal-rs_gabinete_data_edicao`, 
					`cefal-rs_administrador_id`, 
					`cefal-rs_gabinete_status`
				)
				VALUES(
					NULL,
					"'.$gabinete.'",
					'.$retorno.',
					'.$coordenadoria.',
					
					NOW(),
					NOW(),
					
					0,
					1
				)
			;
		';
		
		$query = mysql_query($sql, $conn) or die(mysql_error());
		
		$gabinete = mysql_insert_id();
		
		$sql = '				
			UPDATE `cefal-rs_associados` SET
				`cefal-rs_coordenadoria_id` = '.$coordenadoria.',
				`cefal-rs_gabinete_id` = '.$gabinete.',
				`cefal-rs_setor_id` = '.$setor.'
			WHERE
				`cefal-rs_associado_id` = '.$retorno.'
			;
		';

		//echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());

		return($retorno);
	}
	
	// 	Recebendo dados pessoais do associado
	$matricula			= addslashes(urldecode($_POST['adicionar_matricula']));
	$nome 				= addslashes(urldecode($_POST['adicionar_nome']));
	$cpf 				= addslashes(urldecode($_POST['adicionar_cpf']));
	$data_de_nascimento	= urldecode($_POST['adicionar_data_de_nascimento']);
	$rg 					= addslashes(urldecode($_POST['adicionar_rg']));
	
	//	Recebendo Telefones
	$telefones = addslashes(urldecode($_POST['adicionar_telefones']));

	//	Recebendo E-mails
	$emails = addslashes(urldecode($_POST['adicionar_emails']));

	//	Recebendo Endereços
	$logradouro	= addslashes(urldecode($_POST['adicionar_logradouro']));
	$cep 		= addslashes(urldecode($_POST['adicionar_cep']));
	$municipio	= addslashes(urldecode($_POST['adicionar_municipio']));
	$bairro		= addslashes(urldecode($_POST['adicionar_bairro']));
	
	//	Recebendo Dependentes
	$nomes_dependentes					= addslashes(urldecode($_POST['adicionar_nomes_dependentes']));
	$datas_de_nascimentos_dependentes	= urldecode($_POST['adicionar_datas_de_nascimentos_dependentes']);
	
	//	Recebendo Banco
	$banco		= addslashes(urldecode($_POST['adicionar_banco']));
	$agencia		= addslashes(urldecode($_POST['adicionar_agencia']));
	$conta		= addslashes(urldecode($_POST['adicionar_conta']));
	
	//	Recebendo Contabel
	$salario		= addslashes(urldecode($_POST['adicionar_salario']));
	$limite_credito	= addslashes(urldecode($_POST['adicionar_limite_credito']));
	$limite_usado	= addslashes(urldecode($_POST['adicionar_limite_usado']));
	
	//	Recebendo Dados AL
	$gabinete		= addslashes(urldecode($_POST['adicionar_gabinete']));
	$categoria		= addslashes(urldecode($_POST['adicionar_categoria']));
	$setor			= addslashes(urldecode($_POST['adicionar_setor']));
	$coordenadoria 	= addslashes(urldecode($_POST['adicionar_coordenadoria']));

	//	Cria os diretórios padrões.
	//mkdir('../img/entidades/'.$idassociado, 0777);
	//mkdir('../img/entidades/'.$idassociado.'/cartoes', 0777);

	$retorno = CadastrarPessoais($matricula, $nome, $data_de_nascimento, $cpf, $rg, $categoria, $conn);
	if($retorno){
		$retorno = CadastrarTelefones($retorno, $telefones, $conn);
		$retorno = CadastrarEmails($retorno, $emails, $conn);
		$retorno = CadastrarEndereco($retorno, $logradouro, $cep, $bairro, $municipio, $conn);
		$retorno = CadastrarDependentes($retorno, $nomes_dependentes, $datas_de_nascimentos_dependentes, $conn);
		$retorno = CadastrarBanco($retorno, $banco, $agencia, $conta, $conn);
		$retorno = CadastrarContabel($retorno, $salario, $limite_credito, $limite_usado, $conn);
		$retorno = CadastrarDadoAL($retorno, $gabinete, $categoria, $setor, $coordenadoria, $conn);
	}
	if($retorno){
		echo 'Associado cadastrado com sucesso!';
	}else{
		echo $sql;
	}
?>
