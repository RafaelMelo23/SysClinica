<?php
switch ($_REQUEST['acao']) {
    case 'cadastrar':
        $paciente = $_POST['paciente_id_paciente'];
        $medico = $_POST['medico_id_medico'];
        $data = $_POST['data_consulta'];
        $hora = $_POST['hora_consulta'];
        $descricao = $_POST['descricao_consulta'];

        // Certifique-se de que os valores necessários estão definidos
        if (empty($paciente) || empty($medico) || empty($data) || empty($hora)) {
            print "<script>alert('Todos os campos obrigatórios devem ser preenchidos!');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
            break;
        }

        // Query de inserção corrigida
        $sql = "INSERT INTO consulta (paciente_id_paciente, medico_id_medico, data_consulta, hora_consulta, descricao_consulta) 
                VALUES ($paciente, $medico, '$data', '$hora', '$descricao')";

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Cadastrou com sucesso!');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
        } else {
            print "<script>alert('Erro ao cadastrar: {$conn->error}');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
        }
        break;

    case 'editar':
        $paciente = $_POST['paciente_id_paciente'];
        $medico = $_POST['medico_id_medico'];
        $data = $_POST['data_consulta'];
        $hora = $_POST['hora_consulta'];
        $descricao = $_POST['descricao_consulta'];

        // Certifique-se de que os valores necessários estão definidos
        if (empty($paciente) || empty($medico) || empty($data) || empty($hora)) {
            print "<script>alert('Todos os campos obrigatórios devem ser preenchidos!');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
            break;
        }

        // Query de atualização corrigida
        $sql = "UPDATE consulta SET
                    paciente_id_paciente = $paciente, 
                    medico_id_medico = $medico, 
                    data_consulta = '$data', 
                    hora_consulta = '$hora', 
                    descricao_consulta = '$descricao'
                WHERE
                    id_consulta = " . $_REQUEST["id_consulta"];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Editou com sucesso!');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
        } else {
            print "<script>alert('Erro ao editar: {$conn->error}');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
        }
        break;

    case 'excluir':
        if (empty($_REQUEST["id_consulta"])) {
            print "<script>alert('ID da consulta não fornecido!');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
            break;
        }

        // Query de exclusão corrigida
        $sql = "DELETE FROM consulta
                WHERE id_consulta = " . $_REQUEST["id_consulta"];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Excluiu com sucesso!');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
        } else {
            print "<script>alert('Erro ao excluir: {$conn->error}');</script>";
            print "<script>location.href='?page=listar-consulta';</script>";
        }
        break;

    default:
        print "<script>alert('Ação inválida!');</script>";
        print "<script>location.href='?page=listar-consulta';</script>";
        break;
}
?>
