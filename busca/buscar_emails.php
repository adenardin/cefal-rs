<?php
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
		include_once('../conexao.php');
		
		$id = $_POST['associado_id'];			
		
		$sql = '
			SELECT 
				`cefal-rs_email_id`,
				`cefal-rs_email`,
				`cefal-rs_tabela`,
				`cefal-rs_tabela_id`,
				`cefal-rs_email_data_criacao`,
				`cefal-rs_email_data_edicao`,
				`cefal-rs_administrador_id`,
				`cefal-rs_email_status`
			FROM 
				`cefal-rs_emails`
			WHERE
				`cefal-rs_tabela` = "cefal-rs_associados" AND
				`cefal-rs_tabela_id` = "'.$id.'" AND
				`cefal-rs_email_status` = 1
		;';
		
		$query = mysql_query($sql, $conn) or die(mysql_error());
		
		//$result = mysql_fetch_assoc($query);
		
		while($result = mysql_fetch_array($query)){
			
			$email_id = $result['cefal-rs_email_id'];
			$email = $result['cefal-rs_email'];
			$tabela = $result['cefal-rs_tabela'];
			$tabela_id = $result['cefal-rs_tabela_id'];
			$email_data_criacao = $result['cefal-rs_email_data_criacao'];
			$email_data_edicao = $result['cefal-rs_email_data_edicao'];
			$administrador_id = $result['cefal-rs_administrador_id'];
			$email_status = $result['cefal-rs_email_status'];
		
			$emails .=	'<p>E-mail: '.$email.'</p>';
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
		
		echo '<b>E-mails de '.$result['cefal-rs_associado_nome'].'</b><br>'.$emails;
	}
?>	
