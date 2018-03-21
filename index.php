<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	@include('function.php');
	@include('conexao.php');
	@include('header.php');

	@include("busca/index.php");

	@include('footer.php');

	@mysql_close($conn);

	unset($query, $var, $result, $conn, $sql);

?>
