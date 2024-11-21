<?php
include('config.php');
session_start(); // Certifique-se de iniciar a sessão

// Verificar se id_paciente e consulta_dropdown foram enviados
if (!isset($_POST['id_paciente']) || !isset($_POST['consulta_dropdown'])) {
    die("Erro: id_paciente ou consulta_dropdown não foram enviados.");
}

// Obter o nome do médico da sessão
$nome_medico = isset($_SESSION['nome_medico']) ? $_SESSION['nome_medico'] : 'Desconhecido';

// Capturar os IDs do paciente e da consulta
$id_paciente = intval($_POST['id_paciente']);
$id_consulta = intval($_POST['consulta_dropdown']);

// Verificar se o paciente existe
$sql_verificar_paciente = "SELECT * FROM paciente WHERE id_paciente = ?";
$stmt = $conn->prepare($sql_verificar_paciente);

if (!$stmt) {
    die("Erro na consulta SQL: " . $conn->error);
}

$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Erro: Paciente não encontrado.");
}

// Verificar se a consulta é válida para o paciente
$sql_consulta = "
    SELECT id_consulta, data_consulta, hora_consulta
    FROM consulta
    WHERE id_consulta = ?
      AND paciente_id_paciente = ? 
      AND id_consulta NOT IN (SELECT id_consulta FROM prontuario)";
$stmt = $conn->prepare($sql_consulta);

if (!$stmt) {
    die("Erro na consulta SQL: " . $conn->error);
}

$stmt->bind_param("ii", $id_consulta, $id_paciente);
$stmt->execute();
$result_consulta = $stmt->get_result();

if ($result_consulta->num_rows > 0) {
    $row_consulta = $result_consulta->fetch_object();
    $data_consulta = $row_consulta->data_consulta;
    $hora_consulta = $row_consulta->hora_consulta;
} else {
    die("Erro: Nenhuma consulta válida encontrada para este paciente.");
}

// Inserir prontuário
$sql_prontuario = "
    INSERT INTO prontuario (
    id_paciente, 
    id_consulta, 
    sintomas, 
    diagnostico, 
    medicamentos, 
    exames_solicitados, 
    retorno_boolean, 
    data_retorno, 
    nome_medico
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
";
$stmt = $conn->prepare($sql_prontuario);

if (!$stmt) {
    die("Erro na consulta SQL: " . $conn->error);
}

// Dados do prontuário
$sintomas = $_POST['sintomas'] ?? '';
$diagnostico = $_POST['diagnostico'] ?? '';
$medicamentos = $_POST['medicamentos'] ?? '';
$exames = $_POST['exames'] ?? '';
$retorno_boolean = isset($_POST['retorno_boolean']) ? (string)$_POST['retorno_boolean'] : '0';
$data_retorno = !empty($_POST['data_retorno']) ? $_POST['data_retorno'] : null;

// Corrigir a string de tipos e o número de argumentos
$stmt->bind_param(
    "iisssssss", // 9 argumentos
    $id_paciente,
    $id_consulta,
    $sintomas,
    $diagnostico,
    $medicamentos,
    $exames,
    $retorno_boolean,
    $data_retorno,
    $nome_medico
);

if ($stmt->execute()) {
    echo "<script>
            alert('Prontuário Cadastrado com Sucesso!');
            window.location.href = 'prontuario-medico.php'; // Redireciona após o alerta
          </script>";
    exit(); // Adiciona exit() para garantir que o script pare aqui
} else {
    echo "<script>
            alert('Erro ao cadastrar prontuário');
            window.location.href = 'prontuario-medico.php'; // Redireciona após o alerta
          </script>";
    exit(); // Adiciona exit() para garantir que o script pare aqui
}



$stmt->close();
$conn->close();
?>
