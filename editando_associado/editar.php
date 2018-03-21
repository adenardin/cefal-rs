<?php

	//	Para adicionar um contato é necessário uma observação e um status na alteração para após 
	//	adicionar o contato juntamente com a alteração.
	
	// 	Aquivos necessários para o insert.
	include_once('../conexao.php');
	include_once('../function.php');
	
	function AtualizarPessoais($id_associado, $matricula, $nome, $data_de_nascimento, $cpf, $rg, $categoria, $setor, $coordenadoria, $conn){
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
		$sql = '
			UPDATE `cefal-rs`.`cefal-rs_associados` 
				SET  `cefal-rs_associado_matricula` = "'.$matricula.'",
					`cefal-rs_associado_nome` = "'.$nome.'", 
					`cefal-rs_associado_data_nascimento` = "'.$data_de_nascimento.'", 
					`cefal-rs_associado_cpf` = "'.$cpf.'", 
					`cefal-rs_associado_rg` = "'.$rg.'", 
					`cefal-rs_categoria_id` = '.$categoria.',
					`cefal-rs_setor_id` = '.$setor.',
					`cefal-rs_coordenadoria_id` = '.$coordenadoria.',
					`cefal-rs_associado_data_edicao` = NOW(), 
					`cefal-rs_associado_status` = 1
					WHERE `cefal-rs_associado_id` = '.$id_associado.'
			;
		';
		// echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($id_associado);		
	}	
	
	function AtualizarTelefones($id_associado, $telefone, $conn){		
		$telefone = preg_split('((\&)?atualizar_telefones\=)', urldecode($telefone));
		$sql_excluir = "DELETE FROM `cefal-rs_telefones` WHERE `cefal-rs_tabela_id` = '".$id_associado."'";
		$query = mysql_query($sql_excluir, $conn) or die(mysql_error());	
				
		$count = count($telefone);
		
		$i = 0;
		while($i < $count){		
			if(($telefone[$i] != '')&&($telefone[$i] != NULL)){
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
							"'.$telefone[$i].'",
							"cefal-rs_associados",
							'.$id_associado.',
							
							NOW(),
							NOW(),
							
							0,
							1						
						)
					;
				';			
				// echo $sql;
				$query = mysql_query($sql, $conn) or die(mysql_error());				
			}
			$i++;
		}
		return($id_associado);		
	}	
	
	function AtualizarEmails($id_associado, $emails, $conn){		
		$emails = preg_split('((\&)?atualizar_emails\=)', urldecode($emails));
		$sql_excluir = "DELETE FROM `cefal-rs_emails` WHERE `cefal-rs_tabela_id` = '".$id_associado."'";
		$query = mysql_query($sql_excluir, $conn) or die(mysql_error());	
				
		$count = count($emails);
		
		$i = 0;
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
							'.$id_associado.',
							
							NOW(),
							NOW(),
							
							0,
							1						
						)
					;
				';			
				// echo $sql;
				$query = mysql_query($sql, $conn) or die(mysql_error());				
			}
			$i++;
		}
		return($id_associado);		
	}	
	
	function AtualizarEndereco($id_associado, $logradouro, $cep, $bairro, $municipio, $conn){
		$sql = '
			UPDATE  `cefal-rs_enderecos`
					SET `cefal-rs_endereco_logradouro` = "'.$logradouro.'", 
					`cefal-rs_endereco_cep` = "'.$cep.'", 
					`cefal-rs_municipio_id` = "'.$municipio.'", 
					`cefal-rs_endereco_bairro` ="'.$bairro.'" , 
					`cefal-rs_endereco_data_edicao` = NOW(), 
					`cefal-rs_administrador_id` = 0, 
					`cefal-rs_endereco_status` = 1
					WHERE `cefal-rs_associado_id` = '.$id_associado.'
			;
		';
		// echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($id_associado);		
	}
	
	function AtualizarDependentes($id_associado, $nome_dependente, $data_de_nascimento_dependente, $conn){
		
		$sql_excluir = 'DELETE FROM `cefal-rs_dependentes` WHERE `cefal-rs_associado_id` = '.$id_associado;
		// echo $sql_excluir;
		$query = mysql_query($sql_excluir, $conn) or die(mysql_error());	
		
		$nome_dependente 				= preg_split('((\&)?atualizar_nomes_dependentes\=)', urldecode($nome_dependente), -1, PREG_SPLIT_NO_EMPTY);
		$data_de_nascimento_dependente	= preg_split('((\&)?atualizar_datas_de_nascimentos_dependentes\=)', urldecode($data_de_nascimento_dependente), -1, PREG_SPLIT_NO_EMPTY);
		$count							= count($nome_dependente);
		$i								= 0;
		// echo $count;
		
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
							'.$id_associado.',
							
							NOW(),
							NOW(),
							
							0,
							1						
						)
					;
				';
				// echo $sql;
				$query = mysql_query($sql, $conn) or die(mysql_error());			
			}
			$i++;
		}
		return($id_associado);	
	}
	
	function AtualizarBanco($id_associado, $banco_nome, $banco_agencia, $banco_conta, $conn){
		$sql = '
				UPDATE `cefal-rs_bancos`
					SET `cefal-rs_banco_nome` = "'.$banco_nome.'", 
					`cefal-rs_banco_agencia` = "'.$banco_agencia.'", 
					`cefal-rs_banco_conta` = "'.$banco_conta.'", 
					`cefal-rs_banco_data_edicao` = NOW(), 
					`cefal-rs_admintrador_id` = 0, 
					`cefal-rs_banco_status` = 1
					WHERE `cefal-rs_associado_id` = '.$id_associado.'
			;
		';
		// echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($id_associado);
	}

	function AtualizarContabel($id_associado, $salario, $limite_credito, $limite_usado, $conn){

		$salario 		= toDeceimal($salario);
		$limite_credito = toDeceimal($limite_credito);
		$limite_usado 	= toDeceimal($limite_usado);
	
		$sql = '
			 UPDATE  `cefal-rs_contabilidade`
					SET `cefal-rs_contabilidade_salario` = '.$salario.', 
					`cefal-rs_contabilidade_credito` = '.$limite_credito.', 
					`cefal-rs_contabilidade_credito_usado` = '.$limite_usado.', 
					`cefal-rs_contabilidade_data_edicao` = NOW(), 
					`cefal-rs_administrador_id` = 0, 
					`cefal-rs_contabilidade_status` = 1
					WHERE `cefal-rs_associado_id` = '.$id_associado.'
			;
		';
		$query = mysql_query($sql, $conn) or die(mysql_error());
		$contabel = mysql_insert_id();
		$sql = '				
			UPDATE `cefal-rs_associados` SET
				`cefal-rs_contabilidade_id` = '.$contabel.'
			WHERE
				`cefal-rs_associado_id` = '.$id_associado.'
			;
		';
		
		// echo $sql;
		$query = mysql_query($sql, $conn) or die(mysql_error());
		return($id_associado);
	}
	
	function AtualizarDadoAL($id_associado, $gabinete, $categoria, $setor, $coordenadoria, $conn){
		
		$id_gabinete = "";
		
		$sql_verificacao = '
			SELECT 
				`cefal-rs_gabinete_id` FROM `cefal-rs_gabinetes` 
				WHERE `cefal-rs_gabinete_nome` = "'.$gabinete.'"
			;';
			
		$query = mysql_query($sql_verificacao, $conn) or die(mysql_error());
		
		while($var = mysql_fetch_array($query))
		{
			$id_gabinete = $var['cefal-rs_gabinete_id'];
		}
		
		if($id_gabinete == ""){
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
						'.$id_associado.',
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
					`cefal-rs_associado_id` = '.$id_associado.'
				;
			';

			//echo $sql;
			$query = mysql_query($sql, $conn) or die(mysql_error());
		}
		else{
			$sql = '
				UPDATE `cefal-rs_associados`
				SET `cefal-rs_gabinete_id` = '.$id_gabinete.'
				WHERE `cefal-rs_associado_id` = '.$id_associado.'
			;';
			$query = mysql_query($sql, $conn) or die(mysql_error());
		}
		return($id_associado);
	}
	
	// 	Recebendo dados pessoais do associado
	$matricula			= addslashes($_POST['atualizar_matricula']);
	$nome 				= addslashes($_POST['atualizar_nome']);
	$cpf 				= addslashes($_POST['atualizar_cpf']);
	$data_de_nascimento	= $_POST['atualizar_data_de_nascimento'];
	$rg 					= addslashes($_POST['atualizar_rg']);
	
	//	Recebendo Telefones
	$telefones = addslashes($_POST['atualizar_telefones']);

	//	Recebendo E-mails
	$emails = addslashes($_POST['atualizar_emails']);

	//	Recebendo Endereços
	$logradouro	= addslashes($_POST['atualizar_logradouro']);
	$cep 		= addslashes($_POST['atualizar_cep']);
	$municipio	= addslashes($_POST['atualizar_municipio']);
	$bairro		= addslashes($_POST['atualizar_bairro']);
	
	//	Recebendo Dependentes
	$nomes_dependentes					= addslashes($_POST['atualizar_nomes_dependentes']);
	$datas_de_nascimentos_dependentes	= $_POST['atualizar_datas_de_nascimentos_dependentes'];
	
	//	Recebendo Banco
	$banco		= addslashes($_POST['atualizar_banco']);
	$agencia		= addslashes($_POST['atualizar_agencia']);
	$conta		= addslashes($_POST['atualizar_conta']);
	
	//	Recebendo Contabel
	$salario		= addslashes($_POST['atualizar_salario']);
	$limite_credito	= addslashes($_POST['atualizar_limite_credito']);
	$limite_usado	= addslashes($_POST['atualizar_limite_usado']);
	
	//	Recebendo Dados AL
	$gabinete		= addslashes($_POST['atualizar_gabinete']);
	$categoria		= addslashes($_POST['atualizar_categoria']);
	$setor			= addslashes($_POST['atualizar_setor']);
	$coordenadoria 	= addslashes($_POST['atualizar_coordenadoria']);
	
	$id_associado 	= addslashes($_POST['edicao_id']);

	//	Cria os diretórios padrões.
	//mkdir('../img/entidades/'.$idassociado, 0777);
	//mkdir('../img/entidades/'.$idassociado.'/cartoes', 0777);

	$retorno = AtualizarPessoais($id_associado, $matricula, $nome, $data_de_nascimento, $cpf, $rg, $categoria, $setor, $coordenadoria, $conn);
	$retorno = AtualizarTelefones($id_associado, $telefones, $conn);
	$retorno = AtualizarEmails($id_associado, $emails, $conn);
	$retorno = AtualizarEndereco($id_associado, $logradouro, $cep, $bairro, $municipio, $conn);
	$retorno = AtualizarDependentes($id_associado, $nomes_dependentes, $datas_de_nascimentos_dependentes, $conn);
	$retorno = AtualizarBanco($id_associado, $banco, $agencia, $conta, $conn);
	$retorno = AtualizarContabel($id_associado, $salario, $limite_credito, $limite_usado, $conn);
	$retorno = AtualizarDadoAL($id_associado, $gabinete, $categoria, $setor, $coordenadoria, $conn);
	
	if($retorno){
		echo 'Associado atualizado com sucesso!';
	}else{
		echo $sql;
	}
?>
