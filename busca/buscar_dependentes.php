<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
		include_once('../conexao.php');
		
		$id = $_POST['associado_id'];			
		
		$sql = '
			SELECT 
			
				`cefal-rs_dependente_id`, 
				`cefal-rs_dependente_nome`, 
				DATE_FORMAT(`cefal-rs_dependente_data_nascimento`,"%d/%m/%Y") AS `cefal-rs_dependente_data_nascimento`,
				`cefal-rs_associado_id`, 
				`cefal-rs_dependente_data_criacao`, 
				`cefal-rs_dependente_data_edicao`, 
				`cefal-rs_administrador_id`, 
				`cefal-rs_dependente_status`
				
				FROM 
				`cefal-rs_dependentes`
			WHERE
				`cefal-rs_associado_id` = "'.$id.'" AND
				`cefal-rs_dependente_status` = 1
		;';
		
		$query = mysql_query($sql, $conn) or die(mysql_error());
		$rowCount = mysql_num_rows($query);
		
		if($rowCount == 0){
			echo'
				<p>Nenhum dependente cadastrado!</p>
			';
		}
		
		while($result = mysql_fetch_array($query)){
			$dependente_id = $result['cefal-rs_dependente_id'];
			$dependente = $result['cefal-rs_dependente_nome'];
			$dependente_data_nascimento = $result['cefal-rs_dependente_data_nascimento'];
			$associado_id = $result['cefal-rs_associado_id'];
			$dependente_data_criacao = $result['cefal-rs_dependente_data_criacao'];
			$dependente_data_edicao = $result['cefal-rs_dependente_data_edicao'];
			$associado_id = $result['cefal-rs_associado_id'];
			$dependente_status = $result['cefal-rs_dependente_status'];
		
			$dependentes .=	'<p>Dependente: '.$dependente.' - Nascimento: '.$dependente_data_nascimento.'</p>';
		}

		$sql = '
			SELECT 
				`cefal-rs_associado_nome` 
			
			FROM 
				`cefal-rs_associados`

			WHERE 
				`cefal-rs_associado_id` = "'.$id.'" AND
				`cefal-rs_associado_status` = 1
		;';
		
		$query = mysql_query($sql, $conn) or die(mysql_error());
		
		$result = mysql_fetch_array($query);
		
		echo '<b>Dependentes de '.$result['cefal-rs_associado_nome'].'</b><br>'.$dependentes;
	}
?>	
