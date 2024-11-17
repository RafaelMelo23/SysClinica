<?php
include('config.php');

// Recebe o nome do paciente
$nomePaciente = $_GET['nome_paciente'];

// Consulta no banco de dados
$sql = "SELECT id_paciente, nome_paciente, email_paciente, fone_paciente, endereco_paciente, cpf_paciente, dt_nasc_paciente, sexo_paciente FROM paciente WHERE nome_paciente LIKE '%{$nomePaciente}%'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$output = [];

// Processa cada linha do resultado
while ($row = mysqli_fetch_assoc($result)) {
    $output[] = $row;
}

mysqli_close($conn);

// Retorna os dados em formato JSON
echo json_encode($output);
?>
