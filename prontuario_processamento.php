<?php
include('config.php');

// Corrigido para verificar se todas as variáveis estão setadas corretamente
if (isset($_POST['id_paciente']) && isset($_POST['sintomas']) && isset($_POST['diagnostico']) && isset($_POST['medicamentos']) && isset($_POST['exames']) && isset($_POST['retorno_boolean']) && isset($_POST['data_retorno'])) {

    $id_paciente = $_POST['id_paciente'];
    $sintomas = $_POST['sintomas'];
    $diagnostico = $_POST['diagnostico'];
    $medicamentos = $_POST['medicamentos'];
    $exames = $_POST['exames'];
    $retorno_boolean = $_POST['retorno_boolean'];
    $data_retorno = !empty($_POST['data_retorno']) ? $_POST['data_retorno'] : null; 

    if (empty($id_paciente)) {
        die("Erro: ID do paciente não fornecido.");
    }

    $nome_medico = $_SESSION['nome_medico'];
    $especialidade_medico = $_SESSION['especialidade_medico'];

    $sql_verificar_paciente = "SELECT * FROM paciente WHERE id_paciente = ?";
    $stmt = $conn->prepare($sql_verificar_paciente);
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Erro: Paciente não encontrado.");
    }


    $sql = "INSERT INTO prontuario (id_paciente, sintomas, diagnostico, medicamentos, exames_solicitados, retorno_boolean, data_retorno, nome_medico, especialidade_medico) 
            VALUES ('$id_paciente', '$sintomas', '$diagnostico', '$medicamentos', '$exames', '$retorno_boolean', '$data_retorno', '$nome_medico', '$especialidade_medico')";

    if ($conn->query($sql) === TRUE) {
        echo "Prontuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar prontuário: " . $conn->error;
    }

    $conn->close();
    
}
?>
