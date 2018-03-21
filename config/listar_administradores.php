<?php
	/*
		LISTAR ADMINISTRADORES
		cefal-rs/config/listar administradores.php
	*/

	include_once('../conexao.php');
	include_once('../function.php');
	
	$sql = '
		SELECT 
			`cefal-rs_administradores`.`cefal-rs_administrador_id`, 
			`cefal-rs_administradores`.`cefal-rs_administrador_nome`, 
			`cefal-rs_administradores`.`cefal-rs_administrador_e-mail`, 
			`cefal-rs_administradores`.`cefal-rs_administrador_usuario`, 
			/*`cefal-rs_administradores`.`cefal-rs_administrador_senha`,*/ 
			`cefal-rs_grupos`.`cefal-rs_grupo`, 
			DATE_FORMAT(`cefal-rs_administradores`.`cefal-rs_administrador_data_criacao`,"%d/%m/%Y %H:%I") AS `cefal-rs_administrador_data_criacao`, 
			DATE_FORMAT(`cefal-rs_administradores`.`cefal-rs_administrador_data_edicao`,"%d/%m/%Y %H:%I") AS `cefal-rs_administrador_data_edicao`, 
			DATE_FORMAT(`cefal-rs_administradores`.`cefal-rs_administrador_ultimo_login`,"%d/%m/%Y %H:%I") AS `cefal-rs_administrador_ultimo_login`, 
			
			`cefal-rs_administradores`.`cefal-rs_administrador_id_editor`,
			
			`cefal-rs_administradores`.`cefal-rs_administrador_status`
		FROM 
			`cefal-rs_administradores`
				
		INNER JOIN `cefal-rs_grupos` AS `cefal-rs_grupos` ON(
			`cefal-rs_administradores`.`cefal-rs_grupo_id` = `cefal-rs_grupos`.`cefal-rs_grupo_id`
		)
	;';
	
	$rsRegistro = mysql_query($sql, $conn) or die(mysql_error());
	
	$totalRows_rsRegistro = mysql_num_rows($rsRegistro);

	//Pegando os nomes dos campos
	
	//Obtém o número de campos do resultado
	$numCampos = mysql_num_fields($rsRegistro);
	//Pega o nome dos campos
	for($i = 0;$i<$numCampos; $i++){
	    $Campos[] = mysql_field_name($rsRegistro,$i);
	}

	//Montando o cabeçalho da tabela
	$tabela = '<table border="0" class="tablesorter"><thead><tr>';

	for($i = 0;$i < $numCampos; $i++){
		
		switch ($Campos[$i]){
			
			case ($Campos[$i] = 'cefal-rs_administrador_id'):
				$Campos[$i] = 'ID';
			break;
			
			case  ($Campos[$i] = 'cefal-rs_administrador_nome'):
				$Campos[$i] = 'Administrador';
			break;
			
			case ($Campos[$i] = 'cefal-rs_administrador_e-mail'):
				$Campos[$i] = 'E-mail';
			break;	
			
			case ($Campos[$i] = 'cefal-rs_administrador_usuario'):
				$Campos[$i] = 'Login';
			break;
			
			case ($Campos[$i] = 'cefal-rs_grupo'):
				$Campos[$i] = 'Grupo';
			break;
			
			case ($Campos[$i] = 'cefal-rs_administrador_data_criacao'):
				$Campos[$i] = 'Criação';
			break;
			
			case ($Campos[$i] = 'cefal-rs_administrador_data_edicao'):
				$Campos[$i] = 'Edição';
			break;
			
			case ($Campos[$i] = 'cefal-rs_administrador_ultimo_login'):
				$Campos[$i] = 'Ultimo Acesso';
			break;
			
			case ($Campos[$i] = 'cefal-rs_administrador_id_editor'):
				$Campos[$i] = 'Último Editor';
			break;
			
			case ($Campos[$i] = 'cefal-rs_administrador_status'):
				$Campos[$i] = 'Status';
			break;
			
			default:
				$mensagem = '';
		}
			 $tabela .= '<th class="header">'.$Campos[$i].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
	}
	
	$tabela .= '
		</thead></tr>
	';

	while($row_rsRegistro = mysql_fetch_array($rsRegistro)){
		$tabela .= '
			<tr class="even">
		';	

		for($i = 0;$i < $numCampos; $i++){
			if($Campos[$i] == 'ID'){
				$tabela .= '<td><a href="javascript:void(0)" class="editar_administrador" id="'.$row_rsRegistro[$i].'">'.$row_rsRegistro[$i].'</a></td>';
			}
			elseif($Campos[$i] == 'Status'){
				$tabela .= '<td>'.($row_rsRegistro[$i] == 1?'Ativo':'<span style="color:red">Excluído</span>').'</td>';
			}
			elseif($Campos[$i] == 'Último Editor'){
				$sql2 = '
					SELECT 
						`cefal-rs_administrador_nome` 
						
					FROM 
						`cefal-rs_administradores` 
					
					WHERE 
						`cefal-rs_administrador_id` = '.$row_rsRegistro[$i].'
					;
				';
				
				$query2 = mysql_query($sql2, $conn);
				
				$result2 = mysql_fetch_assoc($query2);
				
				$tabela .= '<td>'.$result2['cefal-rs_administrador_nome'].'</td>';
			}
			else{
				$tabela .= '<td>'.$row_rsRegistro[$i].'</td>';
			}
		}
		
		$tabela .= '</tr>';	
	}	
	
	$tabela .= '</table>';
	
	echo $tabela;
?>