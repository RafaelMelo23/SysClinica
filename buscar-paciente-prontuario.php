<?php
// buscar-paciente-prontuario.php

include 'config.php'; // Inclua a conexão com o banco de dados

$nomePaciente = $_GET['nome_paciente'];

// Execute a consulta para buscar os pacientes com o nome correspondente
$sql = "SELECT id_paciente, nome_paciente FROM paciente WHERE nome_paciente LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $nomePaciente . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Inicialize um array para armazenar os resultados
$pacientes = [];

while ($row = $result->fetch_assoc()) {
    $pacientes[] = $row; // Adicione cada linha ao array
}

// Retorne os dados em formato JSON
echo json_encode($pacientes);
?>
