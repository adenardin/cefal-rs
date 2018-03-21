<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
		include_once('../conexao.php');
		
		$id = $_POST['associado_id'];			
		
		$sql = '
			SELECT 
				`cefal-rs_telefone_id`,
				`cefal-rs_telefone`,
				`cefal-rs_tabela`,
				`cefal-rs_tabela_id`,
				`cefal-rs_telefone_data_criacao`,
				`cefal-rs_telefone_data_edicao`,
				`cefal-rs_administrador_id`,
				`cefal-rs_telefone_status`
			FROM 
				`cefal-rs_telefones`
			WHERE
				`cefal-rs_tabela` = "cefal-rs_associados" AND
				`cefal-rs_tabela_id` = '.$id.' AND
				`cefal-rs_telefone_status` = 1
		;';
		
		$query = mysql_query($sql, $conn) or die(mysql_error());
		
		//$result = mysql_fetch_assoc($query);
		
		while($result = mysql_fetch_array($query)){
			
			$telefone_id = $result['cefal-rs_telefone_id'];
			$telefone = $result['cefal-rs_telefone'];
			$tabela = $result['cefal-rs_tabela'];
			$tabela_id = $result['cefal-rs_tabela_id'];
			$telefone_data_criacao = $result['cefal-rs_telefone_data_criacao'];
			$telefone_data_edicao = $result['cefal-rs_telefone_data_edicao'];
			$administrador_id = $result['cefal-rs_administrador_id'];
			$telefone_status = $result['cefal-rs_telefone_status'];
		
			$telefones .=	'<p>Telefone: '.$telefone.'</p>';
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
		
		echo '<b>Telefones de '.$result['cefal-rs_associado_nome'].'</b><br>'.$telefones;
	}
?>	
