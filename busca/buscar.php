<?php
	/*
		BUSCAR RETORNO
		cefal-rs/busca/buscar.php
	*/

	include_once('../conexao.php');
	include_once('../function.php');

	// 	Receber Texts
	$where_sql = "";
	$PodeEditar = false;
	
	if((isset($_POST['buscar_nome']) && $_POST['buscar_nome'] != ""))
		$where_sql			.= (isset($_POST['buscar_nome'])?			' AND retorno_nome LIKE "%'.$_POST['buscar_nome'].'%" ':'');
	if((isset($_POST['buscar_matricula']) && $_POST['buscar_matricula'] != ""))
		$where_sql			.= (isset($_POST['buscar_matricula'])?		' AND retorno_matricula LIKE "%'.$_POST['buscar_matricula'].'%" ':'');
	if((isset($_POST['buscar_cep']) && $_POST['buscar_cep'] != ""))
		$where_sql			.= (isset($_POST['buscar_cep'])?			' AND retorno_cep LIKE "%'.$_POST['buscar_cep'].'%" ':'');
	if((isset($_POST['buscar_gabinete']) && $_POST['buscar_gabinete'] != ""))
		$where_sql			.= (isset($_POST['buscar_gabinete'])?		' AND retorno_gabinete LIKE "%'.$_POST['buscar_gabinete'].'%" ':'');
	
	if((isset($_POST['buscar_edicao']) && $_POST['buscar_edicao'] != ""))
		$PodeEditar	= true;

	// 	Receber Selects
	
	if((isset($_POST['buscar_coordenadoria']) && $_POST['buscar_coordenadoria'] != 0))
		$where_sql			.= (isset($_POST['buscar_coordenadoria'])?	' AND retorno_coordenadoria_id = '.$_POST['buscar_coordenadoria'].' ':'');
	if((isset($_POST['buscar_categoria']) && $_POST['buscar_categoria'] != 0))
		$where_sql			.= (isset($_POST['buscar_categoria'])?		' AND retorno_categoria_id = '.$_POST['buscar_categoria'].' ':'');	
	if((isset($_POST['buscar_setor']) && $_POST['buscar_setor'] != 0))
		$where_sql			.= (isset($_POST['buscar_setor'])?			' AND retorno_setor_id = '.$_POST['buscar_setor'].' ':'');
	if((isset($_POST['buscar_municipio']) && $_POST['buscar_municipio'] != 0))
		$where_sql			.= (isset($_POST['buscar_municipio'])?			' AND retorno_municipio_id = '.$_POST['buscar_municipio'].' ':'');
	
	// 	Receber Checkbox
	//$buscar_sql			.= (isset($_POST['retorno_busca'])?			' AND '.$_POST['retorno_busca'].' ':'');
	$retorno_busca = addslashes($_POST['retorno_busca']);
	$retorno_busca = preg_split('((\&)?retorno_busca\=)', urldecode($retorno_busca), -1, PREG_SPLIT_NO_EMPTY);
	$retorno_busca = explode('retorno_busca[]=',$retorno_busca[0]);
	$retorno_busca = implode($retorno_busca);
	$retorno_busca = explode('&',$retorno_busca);
	
	$sql = '
		SELECT `retorno_id` as "idusuario"
	'; 
	
	$contador = 0;
	foreach($retorno_busca as $retorno_busca_itens){
		
		$limite = count($retorno_busca);
		
			$sql .= ',';
		
		if($retorno_busca_itens == 'dependentes'){
			$sql .= ' (SELECT count(0) FROM `cefal-rs_dependentes` WHERE `cefal-rs_dependentes`.`cefal-rs_associado_id` = `retorno_id`) AS `retorno_dependentes`';
		}
		else if($retorno_busca_itens == 'data_nascimento'){
			$sql .= ' DATE_FORMAT(`retorno_'.$retorno_busca_itens.'`,"%d/%m/%Y") AS `retorno_'.$retorno_busca_itens.'`';
		}
		else{
			$sql .= ' `retorno_'.$retorno_busca_itens.'`';
		}
		$contador++;
	}
	
	if($PodeEditar == true){
		$sql .= ', `retorno_id`';
	}
	
	$sql .=  '
		FROM `view_retorno` WHERE 1=1 '.$where_sql.'
		GROUP BY `retorno_id`
	';
	
	//echo $sql;
	
	$rsRegistro = mysql_query($sql, $conn) or die(mysql_error());
	
	$totalRows_rsRegistro = mysql_num_rows($rsRegistro);

	//Pegando os nomes dos campos
	
	//Obtém o número de campos do resultado
	$numCampos = mysql_num_fields($rsRegistro);
	if($totalRows_rsRegistro == 0){
		echo '
			Nenhum registro encontrado!
		';
	}else{
		
		//Pega o nome dos campos
		for($i = 0;$i<$numCampos; $i++){
			$Campos[] = mysql_field_name($rsRegistro,$i);
		}

		//Montando o cabeçalho da tabela
		$tabela = '<div id="table_buscar_associados"><table border="0" class="tablesorter"><thead><tr>';
		
		//$i = 1 para NÃOOOOOO mostrar o id associado, 0 para mostrar
		for($i = 1;$i < $numCampos; $i++){
			
			switch ($Campos[$i]){		
				case ($Campos[$i] = 'idusuario'):
					$Campos[$i] = 'ID Associado';
				break;	
				
				case ($Campos[$i] = 'retorno_nome'):
					$Campos[$i] = 'Associado';
				break;
				
				case  ($Campos[$i] = 'retorno_endereco'):
					$Campos[$i] = 'Endereço';
				break;
				
				case ($Campos[$i] = 'retorno_rg'):
					$Campos[$i] = 'RG';
				break;
				
				case ($Campos[$i] = 'retorno_cpf'):
					$Campos[$i] = 'CPF';
				break;
				
				case ($Campos[$i] = 'retorno_data_nascimento'):
					$Campos[$i] = 'Data de nascimento';
				break;
				
				case ($Campos[$i] = 'retorno_telefones'):
					$Campos[$i] = 'Telefone';
				break;

				case ($Campos[$i] = 'retorno_emails'):
					$Campos[$i] = 'E-mails';
				break;
				
				case ($Campos[$i] = 'retorno_cep'):
					$Campos[$i] = 'CEP';
				break;
				
				case ($Campos[$i] = 'retorno_dependentes'):
					$Campos[$i] = 'Dependentes';
				break;
				
				case ($Campos[$i] = 'retorno_salario'):
					$Campos[$i] = 'Salário';
				break;
				
				case ($Campos[$i] = 'retorno_limite_de_credito'):
					$Campos[$i] = 'Limite de credito';
				break;
				
				case ($Campos[$i] = 'retorno_limite_usado'):
					$Campos[$i] = 'Limite usado';
				break;
				
				case ($Campos[$i] = 'retorno_limite_atual'):
					$Campos[$i] = 'Limite atual';
				break;
				
				case ($Campos[$i] = 'retorno_matricula'):
					$Campos[$i] = 'Matriculal';
				break;
				
				case ($Campos[$i] = 'retorno_setor'):
					$Campos[$i] = 'Setor';
				break;
				
				case ($Campos[$i] = 'retorno_gabinete'):
					$Campos[$i] = 'Gabinete';
				break;
				
				case ($Campos[$i] = 'retorno_categoria'):
					$Campos[$i] = 'Categoria';
				break;
				
				case ($Campos[$i] = 'retorno_coordenadoria'):
					$Campos[$i] = 'Coordenadoria';
				break;
				
				case ($Campos[$i] = 'retorno_banco'):
					$Campos[$i] = 'Banco';
				break;
				
				case ($Campos[$i] = 'retorno_conta'):
					$Campos[$i] = 'Conta';
				break;
				
				case ($Campos[$i] = 'retorno_agencia'):
					$Campos[$i] = 'Agência';
				break;
				
				case ($Campos[$i] = 'retorno_id'):
					$Campos[$i] = 'Editar';
				break;
		
				default:
					$mensagem = '';
			}

			//Deletar o campo 'retorno_id' do cabeçalho da tabela que é exibida.
			unset($Campos[0]);

			$tabela .= '<th class="header">'.$Campos[$i].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
		}
		
		$tabela .= '
			</thead></tr>
		';

		$id_linha = 0;
		while($row_rsRegistro = mysql_fetch_array($rsRegistro)){
			$tabela .= '
				<tr class="even">
			';	
			
			//$i = 1 para NÃOOOOO mostrar o id associado, 0 para mostrar
			for($i = 1;$i < $numCampos; $i++){
				if($Campos[$i] == "ID Associado"){
					$tabela .= '<td linha="'.$id_linha.'" associado="'.$row_rsRegistro[$i].'">'.$row_rsRegistro[$i].'</td>';
				}
				else if($Campos[$i] == 'Editar'){
					$tabela .= '<td><a href="javascript:void(0)" class="edicao_associado" id_associado="'.$row_rsRegistro[$i].'">'.$row_rsRegistro[$i].'</a></td>';
				}
				else if($Campos[$i] == "Telefone"){
					$tabela .= '<td><a href="javascript:void(0)" class="busca_telefones" id="'.$row_rsRegistro[0].'">'.$row_rsRegistro[$i].'</a></td>';
				}
				else if($Campos[$i] == "E-mails"){
					$tabela .= '<td><a href="javascript:void(0)" class="busca_emails" id="'.$row_rsRegistro[0].'">'.$row_rsRegistro[$i].'</a></td>';
				}
				else if($Campos[$i] == "Dependentes"){
					$tabela .= '<td><a href="javascript:void(0)" class="busca_dependentes" id="'.$row_rsRegistro[0].'">'.$row_rsRegistro[$i].'</a></td>';
				}
				else{
					$tabela .= '<td>'.$row_rsRegistro[$i].'</td>';
				}
			}
			$id_linha++;
			
			$tabela .= '</tr>';	
		}	
		
		$tabela .= '</table></div>';
		
	echo $tabela;
	}
?>
