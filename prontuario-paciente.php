<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o id_prontuario foi passado via GET ou REQUEST
if (isset($_REQUEST['id_prontuario'])) {
    $id_prontuario = $_REQUEST['id_prontuario'];

    

    $sql_prontuario = "
    SELECT 
        p.*, 
        c.data_consulta, 
        c.hora_consulta, 
        p.nome_medico, 
        m.especialidade_medico
    FROM 
        prontuario AS p
    INNER JOIN 
        consulta AS c 
        ON c.id_consulta = p.id_consulta
    LEFT JOIN 
        medico AS m 
        ON m.nome_medico = p.nome_medico
    WHERE 
        p.id_prontuario = ?";

    $stmt = $conn->prepare($sql_prontuario);

    // Verifique se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $id_prontuario);
    $stmt->execute();
    $res_prontuario = $stmt->get_result();

    // Verifica se o prontuário foi encontrado
if ($res_prontuario->num_rows > 0) {
    $row_prontuario = $res_prontuario->fetch_object();

    // Exibe as informações do prontuário
    echo "<div class='container mt-4'>";
    echo "<div class='card'>";
    echo "<div class='card-header bg-primary text-white'>";
    echo "<h1 class='h4'>Prontuário da Consulta #" . htmlspecialchars($row_prontuario->id_consulta) . "</h1>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<p><strong>Data da Consulta:</strong> " . htmlspecialchars($row_prontuario->data_consulta) . "</p>";
    echo "<p><strong>Hora da Consulta:</strong> " . htmlspecialchars($row_prontuario->hora_consulta) . "</p>";
    echo "<p><strong>Médico:</strong> " . htmlspecialchars($row_prontuario->nome_medico) . "</p>";
    echo "<p><strong>Especialidade:</strong> " . htmlspecialchars($row_prontuario->especialidade_medico) . "</p>";
    echo "<p><strong>Sintomas:</strong> " . nl2br(htmlspecialchars($row_prontuario->sintomas)) . "</p>";
    echo "<p><strong>Diagnóstico:</strong> " . nl2br(htmlspecialchars($row_prontuario->diagnostico)) . "</p>";
    echo "<p><strong>Medicamentos:</strong> " . nl2br(htmlspecialchars($row_prontuario->medicamentos)) . "</p>";
    echo "<p><strong>Exames Solicitados:</strong> " . nl2br(htmlspecialchars($row_prontuario->exames_solicitados)) . "</p>";

    // Se houver retorno, exibe a data de retorno
    if ($row_prontuario->retorno_boolean == 1) {
        echo "<p><strong>Data de Retorno:</strong> " . htmlspecialchars($row_prontuario->data_retorno) . "</p>";
    } else {
        echo "<p><strong>Retorno:</strong> Não agendado</p>";
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='alert alert-danger mt-4' role='alert'>Prontuário não encontrado para esta consulta.</div>";
}

} else {
    echo "ID do prontuário não fornecido.";
}
?>
