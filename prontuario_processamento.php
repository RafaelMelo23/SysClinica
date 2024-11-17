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
    $data_retorno = $_POST['data_retorno']; 

    
    $sql = "INSERT INTO prontuario (id_paciente, sintomas, diagnostico, medicamentos, exames_solicitados, retorno_boolean, data_retorno) 
            VALUES ('$id_paciente', '$sintomas', '$diagnostico', '$medicamentos', '$exames', '$retorno_boolean', '$data_retorno')";

    if ($conn->query($sql) === TRUE) {
        echo "Prontuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar prontuário: " . $conn->error;
    }

    $conn->close();
}
?>
