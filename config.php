<?php
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', '');
	define('BASE', 'clinicasysbd');

	$conn = new MySQLi(HOST,USER,PASS,BASE);

	if($conn==true){
		print "Conexão realizada com sucesso";
	}else{
		print "Não conectou";
	}

