<?php
session_start();
include 'config.php'; // Inclui a conexão com o banco de dados

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $crm = trim($_POST['crm_medico']);
    $senha = trim($_POST['senha']);

    // Prepara a consulta SQL para verificar as credenciais
    $sql = "SELECT * FROM medico WHERE crm_medico = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $crm, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verifica se foi encontrado um registro
    if ($resultado->num_rows == 1) {
        $medico = $resultado->fetch_assoc();

        // Armazena informações do médico na sessão
        $_SESSION['id_medico'] = $medico['id_medico'];
        $_SESSION['crm_medico'] = $medico['crm_medico'];
        $_SESSION['nome_medico'] = $medico['nome_medico'];

        // Redireciona para a página inicial ou painel do médico
        header('Location: prontuario-medico.php');
        exit();
    } else {
        // Credenciais incorretas
        echo "<script>alert('CRM ou senha incorretos!');</script>";
        echo "<script>window.location.href = 'login-medico.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redireciona para a página de login se não foi um POST
    header('Location: login-medico.php');
    exit();
}
?>
