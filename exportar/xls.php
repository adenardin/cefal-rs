<?php
	$html = utf8_decode(urldecode($_GET['table_xls']));
	
	// Determina que o arquivo é uma planilha do Excel
	header("Content-type: application/vnd.ms-excel");   

	// Força o download do arquivo
	header("Content-type: application/force-download");  

	// Seta o nome do arquivo
	header("Content-Disposition: attachment; filename=file.xls");

	header("Pragma: no-cache");
	// Imprime o conteúdo da nossa tabela no arquivo que será gerado
	echo $html;
?>