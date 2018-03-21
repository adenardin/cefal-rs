<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		if($_POST['session']){
				
			include_once('../conexao.php');
			include_once('../function.php');
			
			$id = $_POST['id'];
			
			$sql = '
				SELECT 
					`cefal-rs_administradores`.`cefal-rs_administrador_id`, 
					`cefal-rs_administradores`.`cefal-rs_administrador_nome`, 
					`cefal-rs_administradores`.`cefal-rs_administrador_e-mail`, 
					`cefal-rs_administradores`.`cefal-rs_administrador_usuario`, 
					`cefal-rs_administradores`.`cefal-rs_administrador_senha`,
					
					`cefal-rs_grupos`.`cefal-rs_grupo`,
					`cefal-rs_grupos`.`cefal-rs_grupo_id`,
					
					`cefal-rs_telefones`.`cefal-rs_telefone`,
					`cefal-rs_telefones`.`cefal-rs_telefone_id`,
					
					DATE_FORMAT(`cefal-rs_administradores`.`cefal-rs_administrador_data_criacao`,"%d/%m/%Y %H:%I") AS `cefal-rs_administrador_data_criacao`, 
					DATE_FORMAT(`cefal-rs_administradores`.`cefal-rs_administrador_data_edicao`,"%d/%m/%Y %H:%I") AS `cefal-rs_administrador_data_edicao`, 
					DATE_FORMAT(`cefal-rs_administradores`.`cefal-rs_administrador_ultimo_login`,"%d/%m/%Y %H:%I") AS `cefal-rs_administrador_ultimo_login`, 
					
					`cefal-rs_administradores_editor`.`cefal-rs_administrador_nome` AS `cefal-rs_administrador_editor`,
					
					`cefal-rs_administradores`.`cefal-rs_administrador_status`
				
				FROM 
					`cefal-rs_administradores`
				
				INNER JOIN `cefal-rs_administradores` AS `cefal-rs_administradores_editor` ON(
					`cefal-rs_administradores_editor`.`cefal-rs_administrador_id` = `cefal-rs_administradores`.`cefal-rs_administrador_id`
				)		
				INNER JOIN `cefal-rs_grupos` AS `cefal-rs_grupos` ON(
					`cefal-rs_administradores`.`cefal-rs_grupo_id` = `cefal-rs_grupos`.`cefal-rs_grupo_id`
				)		
				LEFT JOIN `cefal-rs_telefones` AS `cefal-rs_telefones` ON(
					`cefal-rs_telefones`.`cefal-rs_tabela_id` = '.$id.' AND
					`cefal-rs_telefones`.`cefal-rs_tabela` = "cefal-rs_administradores"
				)
				
				WHERE
					`cefal-rs_administradores`.`cefal-rs_administrador_id` = '.$id.'
			;';
			
			$query = mysql_query($sql, $conn) or die(mysql_error());
			
			$result = mysql_fetch_assoc($query);
			$administrador_id = $result['cefal-rs_administrador_id'];
			$administrador_nome = $result['cefal-rs_administrador_nome'];
			$administrador_email = $result['cefal-rs_administrador_e-mail'];
			$administrador_usuario = $result['cefal-rs_administrador_usuario'];
			$administrador_senha = $result['cefal-rs_administrador_senha'];
			$grupo = $result['cefal-rs_grupo'];
			$grupo_id = $result['cefal-rs_grupo_id'];
			$telefone_id = $result['cefal-rs_telefone_id'];
			$telefone = $result['cefal-rs_telefone'];
			$administrador_data_criacao = $result['cefal-rs_administrador_data_criacao'];
			$administrador_data_edicao = $result['cefal-rs_administrador_data_edicao'];
			$administrador_ultimo_login = $result['cefal-rs_administrador_ultimo_login'];
			$administrador_id_editor = $result['cefal-rs_administrador_editor'];
			$administrador_status = $result['cefal-rs_administrador_status'];

			echo'					
				<h2>Administrador ID: '.$administrador_id.'</h2>
				<div class="form_campos_medios">
					<span>Nome:</span>
					<br>
					<input type="text" name="atualizar_administrador_id" value="'.$administrador_id.'" style="display:none">
					<input type="text" id="nmuser" name="atualizar_administrador_nome" style="width: 225px;" value="'.$administrador_nome.'" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>E-mail:</span>
					<br>
					<input type="text" id="mailuser" name="atualizar_administrador_email" style="width: 225px;" value="'.$administrador_email.'" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Login:</span>
					<br>
					<input type="text" id="loginuser" name="atualizar_administrador_usuario" style="width: 225px;" value="'.$administrador_usuario.'" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Senha:</span>
					<br>
					<input type="password" id="senhauser" name="atualizar_administrador_senha" style="width: 225px;" value="'.$administrador_senha.'" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Grupo:</span>
					<br>
					<input type="text" id="'.$grupo_id.'" class="atualizar_grupo_administrador" style="width: 225px;" value="'.$grupo.'" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Telefone:</span>
					<br>
					<input type="text" class="atualizar_telefone" name="atualizar_telefone" style="width: 225px;" value="'.$telefone.'" />
					<input type="text" style="display:none;" name="atualizar_telefone_id" value="'.$telefone_id.'" />
				</div>
				<div class="form_campos_medios">
					<span>Data Criacão:</span>
					<br>
					<input type="text" id="loginuser" name="administrador_data_criacao" style="width: 225px;" value="'.$administrador_data_criacao.'" readonly disabled />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Data Edição:</span>
					<br>
					<input type="text" id="loginuser" name="loginuser" style="width: 225px;" value="'.$administrador_data_edicao.'" readonly disabled />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Adminstrador Último Login:</span>
					<br>
					<input type="text" id="loginuser" name="loginuser" style="width: 225px;" value="'.$administrador_ultimo_login.'" readonly disabled />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Status:</span>
					<br>
					<select name="atualizar_administrador_status" id="status">
						'; 
							if($administrador_status){
								echo '
									<option value="1">Ativo</option>
									<option value="0">Excluído</option>
								';
							}else{
								echo '
									<option value="0">Excluído</option>
									<option value="1">Ativo</option>
								';
							}
						echo '
					</select>
				</div>
			';
		}
	}
?>	