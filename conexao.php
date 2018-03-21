<?php

	//header('Content-Type: text/html; charset=utf-8');

	if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){
		header('Location: 404');
	}else{

		//Pega o nome do banco de dados.
		$banco = 'cefal-rs';

		//Pega o usuário do banco de dados.
		$usuario = 'root';

		//Pega a senha do banco de dados.
		$senha = 'proc2008';

		//Pega o nome do servidor do banco de dados.
		$hostname = 'localhost';

		//Atribui a conexãosinistr a uma variável ($conn) para ser chamada posteriormente em outros arquivos.
		$conn = @mysql_connect($hostname,$usuario,$senha);
		@mysql_select_db($banco);

		@mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	}
?>
