<?php 
switch ($_REQUEST['acao']) {
    case 'cadastrar':

        function gerarSenha($comprimento = 12) {
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#!$%';
            $senha = '';
            for ($i = 0; $i < $comprimento; $i++) {
                $senha .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }
            return $senha;
        }

        // Gerar senha com 12 caracteres
        $senhaGerada = gerarSenha(12);
        echo $senhaGerada; 

        // Verifique se os dados foram passados via POST
        if (isset($_POST['nome_medico'], $_POST['crm_medico'], $_POST['especialidade_medico'])) {
            $nome = mysqli_real_escape_string($conn, $_POST['nome_medico']);
            $crm = mysqli_real_escape_string($conn, $_POST['crm_medico']);
            $especialidade = mysqli_real_escape_string($conn, $_POST['especialidade_medico']);

            // Inserir no banco de dados
            $sql = "INSERT INTO medico (
                        nome_medico,
                        crm_medico,
                        especialidade_medico,
                        senha
                    ) VALUES (
                        '{$nome}',
                        '{$crm}',
                        '{$especialidade}',
                        '{$senhaGerada}'
                    )";

            $res = $conn->query($sql);

            if($res) {
                print "<script>alert('Cadastrado com sucesso!');</script>";
                print "<script>alert('Senha temporária do médico: $senhaGerada');</script>";
                print "<script>location.href='?page=listar-medico';</script>";
            } else {
                print "<script>alert('Erro ao cadastrar o médico!');</script>";
                print "<script>location.href='?page=listar-medico';</script>";
            }
        } else {
            print "<script>alert('Dados inválidos!');</script>";
            print "<script>location.href='?page=listar-medico';</script>";
        }
        break;

    case 'editar':
        // código para editar
        break;

    case 'excluir':
        // código para excluir
        break;
}
?>
