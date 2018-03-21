<?php

	/*
		INSERIR ADMINISTRADOR
		
	*/
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		if(isset($_POST['session'])){
	
			include_once('../conexao.php');
			include_once('../function.php');
			
			function InserirAdministrador($id, $adicionar_administrador_nome, $adicionar_administrador_email, $adicionar_administrador_usuario, $adicionar_administrador_senha, $adicionar_grupo_administrador, $conn){
				
				// Adiciona administrador.
				
				$sql = '
					INSERT INTO 
						`cefal-rs_administradores`(
							`cefal-rs_administrador_id`, 
							`cefal-rs_administrador_nome`, 
							`cefal-rs_administrador_e-mail`, 
							`cefal-rs_administrador_usuario`,
							`cefal-rs_administrador_senha`, 
							`cefal-rs_grupo_id`, 
							`cefal-rs_administrador_data_criacao`, 
							`cefal-rs_administrador_data_edicao`, 
							`cefal-rs_administrador_ultimo_login`, 
							`cefal-rs_administrador_id_editor`, 
							`cefal-rs_administrador_status`
						
						) VALUES (
							NULL,
							"'.$adicionar_administrador_nome.'",
							"'.$adicionar_administrador_email.'",
							"'.$adicionar_administrador_usuario.'",
							MD5("'.$adicionar_administrador_senha.'"),
							'.$adicionar_grupo_administrador.',
							
							NOW(), 
							NOW(), 
							NULL,
							'.$id.',
							1
						)
					;
				';
				// echo $sql;
				$query = mysql_query($sql, $conn) or die(mysql_error());
				$retorno = mysql_insert_id();
				return $retorno;
			}	
			
			function InserirAdministradorTelefone($retorno, $telefone, $conn){

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
							"'.$telefone.'",
							"cefal-rs_administradores",
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
			
			//	Recebendo dados do formulário para inserir administrador
			$adicionar_administrador_nome	= addslashes($_POST['adicionar_administrador_nome']);
			$adicionar_administrador_email	= addslashes($_POST['adicionar_administrador_email']);
			$adicionar_administrador_usuario	= addslashes($_POST['adicionar_administrador_usuario']);
			$adicionar_administrador_senha 	= addslashes($_POST['adicionar_administrador_senha']);
			$adicionar_grupo_administrador 	= addslashes($_POST['adicionar_grupo_administrador']);
			
			$adicionar_telefone_administrador 	= addslashes($_POST['adicionar_telefone_administrador']);
			
			$id 							= addslashes($_POST['id']);
			$session 						= addslashes($_POST['session']);

			$retorno = InserirAdministrador($id, $adicionar_administrador_nome, $adicionar_administrador_email, $adicionar_administrador_usuario, $adicionar_administrador_senha, $adicionar_grupo_administrador, $conn);
			if($retorno){
				$retorno = InserirAdministradorTelefone($retorno, $adicionar_telefone_administrador, $conn);
			}
			if($retorno){
				echo 'Administrador cadastrado com sucesso!';
			}else{
				echo $sql;
			}
		}
	}
?>