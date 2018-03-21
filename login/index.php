<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(addslashes($_POST['usuario']) == '')
			echo 'Login inválido!';
		elseif(addslashes($_POST['senha']) == '')
			echo 'Login inválido!';		
		else{
			
			include_once('../conexao.php');
			$usuario = $_POST['usuario'];
			$senha = md5($_POST['senha']);
			
			/*
				Campos da tabela: cefal-rs_administradores 
				
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
			
			*/
			
			$sql = '
				SELECT				
					`cefal-rs_administrador_id`,
					`cefal-rs_administrador_nome`,
					`cefal-rs_administrador_e-mail`,
					`cefal-rs_administrador_usuario`,
					`cefal-rs_administrador_senha`,					
					`cefal-rs_administrador_data_criacao`,
					`cefal-rs_administrador_data_edicao`,					
					
					DATE_FORMAT(`cefal-rs_administrador_ultimo_login`,"%d/%m/%Y - %H:%i:%s") AS `cefal-rs_administrador_ultimo_login`,

					`cefal-rs_administrador_id_editor`,
					`cefal-rs_administrador_status`,
						
					`cefal-rs_grupo_id`
					
				FROM `cefal-rs_administradores`				
				
				WHERE( 
					`cefal-rs_administrador_usuario`	= "'.$usuario.'"AND
					`cefal-rs_administrador_senha` 	= "'.$senha.'"	AND 
					`cefal-rs_administrador_status` 	= 1
				)
			';
			
			$query = @mysql_query($sql,$conn);
			
			$var = @mysql_fetch_assoc($query);
			
			$cefal_rs_administrador_id 			= $var['cefal-rs_administrador_id'];
			$cefal_rs_administrador_usuario 		= $var['cefal-rs_administrador_usuario'];
			$cefal_rs_administrador_senha 		= $var['cefal-rs_administrador_senha'];
			$cefal_rs_administrador_nome 		= $var['cefal-rs_administrador_nome'];
			$cefal_rs_administrador_email 		= $var['cefal-rs_administrador_e-mail'];
			$cefal_rs_administrador_ultimo_login 	= $var['cefal-rs_administrador_ultimo_login'];
			$cefal_rs_grupo_id 					= $var['cefal-rs_grupo_id'];

			if(isset($cefal_rs_administrador_usuario)&&isset($cefal_rs_administrador_senha)){
				$vetor = array('session'=>true,  'id'=>$cefal_rs_administrador_id,   'nome'=>$cefal_rs_administrador_nome, 'usuario'=>$cefal_rs_administrador_usuario, 'senha'=>$cefal_rs_administrador_senha, 'ultimo_login'=>$cefal_rs_administrador_ultimo_login);
				
				$sql = '
					UPDATE `cefal-rs_administradores`
					
					SET 
						`cefal-rs_administrador_ultimo_login` = NOW()
					
					WHERE( 
						`cefal-rs_administrador_usuario`	= "'.$usuario.'"AND
						`cefal-rs_administrador_senha` 	= "'.$senha.'"	AND 
						`cefal-rs_administrador_status` 	= 1
					)
				';
				$query = @mysql_query($sql,$conn);				

				echo json_encode($vetor);
			}
			else{
				$vetor = array('session'=>false);
				echo json_encode($vetor);
			}
		}
	}
?>