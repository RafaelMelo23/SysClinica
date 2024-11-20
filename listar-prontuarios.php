<?php
include 'config.php'; // Inclua o arquivo de conexão com o banco de dados

if (isset($_REQUEST['id_paciente'])) {
    $id_paciente = $_REQUEST['id_paciente'];

    // Consulta para obter os prontuários do paciente, ordenados pela data (mais recente primeiro)
    $sql_prontuarios = "SELECT * FROM prontuario WHERE id_paciente = $id_paciente ORDER BY created_at DESC";
    $result = $conn->query($sql_prontuarios);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Prontuários do Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Prontuários do Paciente</h2>
        
        <ul class="list-group">
            <?php
            if ($result && $result->num_rows > 0) {
                // Exibe cada prontuário como um item da lista
                while ($row = $result->fetch_object()) {
                    $created_at = date('d/m/Y H:i', strtotime($row->created_at));
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    echo '<div>';
                    echo '<h5>Consulta: ' . $created_at . '</h5>';
                    echo '<p>ID do Prontuário: ' . $row->id_prontuario . '</p>';
                    echo '</div>';
                    echo '<a href="visualizar-prontuario.php?id_paciente=' . $id_paciente . '&id_prontuario=' . $row->id_prontuario . '" class="btn btn-primary">Ver Prontuário</a>';
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item">Nenhum prontuário encontrado para este paciente.</li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>
