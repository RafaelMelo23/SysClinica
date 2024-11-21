<?php
include('config.php');

// Log de debug para o id_paciente recebido
error_log("ID do paciente recebido: " . $_GET['id_paciente']);

// Verifique a consulta que está sendo executada
$id_paciente = $_GET['id_paciente'];

// Montar a query para buscar as consultas
$query = "SELECT id_consulta, data_consulta, hora_consulta 
FROM consulta 
WHERE paciente_id_paciente = ? 
  AND id_consulta NOT IN (SELECT id_consulta FROM prontuario)
ORDER BY data_consulta ASC";


// Debug da query
error_log("Query executada: " . $query);

// Preparar a consulta SQL
$stmt = $conn->prepare($query);

// Verifique se houve erro na preparação
if ($stmt === false) {
    error_log("Erro na preparação da query: " . $conn->error);
    echo json_encode(['error' => 'Erro na preparação da query']);
    exit;
}

// Associar o parâmetro da query
$stmt->bind_param('i', $id_paciente);

// Executar a consulta
$stmt->execute();

// Verificar se houve erro ao executar
if ($stmt->error) {
    error_log("Erro ao executar a consulta: " . $stmt->error);
    echo json_encode(['error' => 'Erro ao executar a consulta']);
    exit;
}

// Obter os resultados
$result = $stmt->get_result();

// Verifique se encontramos resultados
if ($result->num_rows > 0) {
    $consultas = [];
    while ($row = $result->fetch_assoc()) {
        $consultas[] = $row;
    }
    // Debug de consultas encontradas
    error_log("Consultas encontradas: " . json_encode($consultas));
    echo json_encode($consultas);
} else {
    // Caso nenhuma consulta seja encontrada
    error_log("Nenhuma consulta encontrada para o paciente com ID: " . $id_paciente);
    echo json_encode(["message" => "Nenhuma consulta encontrada."]);
}

// Fechar a consulta e a conexão
$stmt->close();
$conn->close();
?>
