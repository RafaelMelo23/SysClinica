<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'clinicasysbd');

$conn = new MySQLi(HOST, USER, PASS, BASE);


if ($conn->connect_error) {
    
    error_log("Erro de conexão: " . $conn->connect_error);
    exit; 
}
?>
