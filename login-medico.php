<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<style>
    .top-left {
        position: absolute;
        top: 10px; 
        left: 10px;
    }
</style>
<div class="container mt-4">
    <button class="btn btn-primary top-left" onclick="window.history.back();">
        Voltar
    </button>
</div>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4" style="width: 400px;">
        <h2 class="text-center mb-4">Login do Médico</h2>
        <form id="loginForm" action="login-processamento.php" method="POST">
            
            <div class="mb-3">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" class="form-control" id="crm" name="crm_medico" required placeholder="Digite seu CRM">
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required placeholder="Digite sua senha">
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>

<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
