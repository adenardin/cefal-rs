<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		if($_POST['session']){
			echo'
				<div id="tabs-3">
					<br />				
					<h2>Gerenciamento dos Administradores</h2>
					<br />					
						<input type="button" value="Listar Administradores" id="listar_administradores" />
						<input type="button" value="Adicionar Administrador" id="adicionar_administrador" />
					<br />					
					<hr>
					<br />
					<h2> Upload de contratos </h2>
					<form method="post" action="recebe_upload.php" enctype="multipart/form-data">
						  <label>Arquivo</label>
						  <input type="file" name="arquivo" />
						  
						  <input type="submit" value="Enviar" />
					</form>
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
				</div>
			';
		}
		else{
			echo '
				<div id="tabs-2">
					Voce não tem permissão!
				</div>		
			';
		}	
	}
