<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		if($_POST['session'] == true){
				
			include_once('../conexao.php');
			include_once('../function.php');
			
			$id = $_POST['id'];

			echo'					
				<h2>Adicionar Novo Administrador</h2>
				<div class="form_campos_medios">
					<span>Nome:</span>
					<br>
					<input type="text" name="adicionar_administrador_nome" style="width: 225px;" value="" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>E-mail:</span>
					<br>
					<input type="text" id="mailuser" name="adicionar_administrador_email" style="width: 225px;" value="" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Login:</span>
					<br>
					<input type="text" id="loginuser" name="adicionar_administrador_usuario" style="width: 225px;" value="" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Senha:</span>
					<br>
					<input type="password" id="senhauser" name="adicionar_administrador_senha" style="width: 225px;" value="" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Grupo:</span>
					<br>
					<input type="text" name="adicionar_grupo_administrador" class="adicionar_grupo_administrador" style="width: 225px;" value="" />
					<br>
				</div>
				<div class="form_campos_medios">
					<span>Telefone:</span>
					<br>
					<input type="text" class="adicionar_telefone_administrador" name="adicionar_telefone_administrador" style="width: 225px;" value="" />
					<br>
				</div>				
			';
		}
	}
?>	