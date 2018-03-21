<?php
	//	ATUALIZAR ADMINISTRADOR
	
	// 	Campos da tabela administrador
	/*
		
	*/
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		if(isset($_POST['session'])){
					
			include_once('../conexao.php');
			include_once('../function.php');
			
			function AtualizarAdministrador($id, $atualizar_administrador_id, $atualizar_administrador_nome, $atualizar_administrador_email, $atualizar_administrador_usuario, $atualizar_administrador_senha, $atualizar_grupo_id, $atualizar_administrador_status, $conn){
				// Atualiza administrador.
				
				$atualizar_administrador_senha = md5($atualizar_administrador_senha);
				
				$sql = '
					UPDATE 
						`cefal-rs_administradores`
						
					SET
						`cefal-rs_administrador_nome` = "'.$atualizar_administrador_nome.'",
						`cefal-rs_administrador_e-mail` = "'.$atualizar_administrador_email.'", 
						`cefal-rs_administrador_usuario` = "'.$atualizar_administrador_usuario.'",
						`cefal-rs_administrador_senha` = "'.$atualizar_administrador_senha.'", 
						`cefal-rs_grupo_id` = '.$atualizar_grupo_id.',
						/*`cefal-rs_administrador_data_criacao`,*/
						`cefal-rs_administrador_data_edicao` = NOW(),
						/*`cefal-rs_administrador_ultimo_login`,*/
						`cefal-rs_administrador_id_editor` = '.$id.',
						`cefal-rs_administrador_status` = '.$atualizar_administrador_status.'
						
					WHERE 
						`cefal-rs_administrador_id` = '.$atualizar_administrador_id.'
					;
				';
				//echo $sql;
				$query = mysql_query($sql, $conn);
				return $sql;
			}			
			
			function AtualizarAdministradorTelefone($id, $atualizar_administrador_id, $telefone_id, $telefone, $conn){
				// Atualiza Telefone administrador.
				
				$sql = '
					UPDATE 
						`cefal-rs_telefones`
						
					SET
						`cefal-rs_telefone` = "'.$telefone.'",
						`cefal-rs_telefone_data_edicao` = NOW(),
						`cefal-rs_administrador_id` = '.$atualizar_administrador_id.'
						
					WHERE 
						`cefal-rs_tabela_id` = '.$id.' AND
						`cefal-rs_tabela` = "cefal-rs_administradores"
					;
				';
				//echo $sql;
				$query = mysql_query($sql, $conn);
				return $sql;
			}
			
			$id									= addslashes($_POST['id']);
			
			$atualizar_administrador_id			= addslashes($_POST['atualizar_administrador_id']);
			$atualizar_administrador_nome 		= addslashes($_POST['atualizar_administrador_nome']);
			$atualizar_administrador_email 		= addslashes($_POST['atualizar_administrador_email']);
			$atualizar_administrador_usuario	= addslashes($_POST['atualizar_administrador_usuario']);
			$atualizar_administrador_senha 		= addslashes($_POST['atualizar_administrador_senha']);
			$atualizar_grupo_id 				= addslashes($_POST['atualizar_grupo_id']);
			
			$atualizar_telefone 				= addslashes($_POST['atualizar_telefone']);
			$atualizar_telefone_id 				= addslashes($_POST['atualizar_telefone_id']);			
			
			$atualizar_administrador_status 	= addslashes($_POST['atualizar_administrador_status']);	
			
			$retorno = AtualizarAdministrador($id, $atualizar_administrador_id, $atualizar_administrador_nome, $atualizar_administrador_email, $atualizar_administrador_usuario, $atualizar_administrador_senha, $atualizar_grupo_id, $atualizar_administrador_status, $conn);
			
			if($retorno){
				$retorno = AtualizarAdministradorTelefone($id, $atualizar_administrador_id, $atualizar_telefone_id, $atualizar_telefone, $conn);
				echo 'Administrador atualizado com sucesso!';
			}else{
				echo $sql;
			}
		}else{
			echo 'Você não tem permissão';
		}
	}
?>