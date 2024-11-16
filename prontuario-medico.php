<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuário Médico</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
        <h2 class="mb-4">Cadastrar Prontuário</h2>
        <form method="POST" action="prontuario_processamento.php">
         
        <div class="form-group mb-3">
    <label for="paciente_nome">Nome do Paciente</label>
    <input type="text" id="paciente_nome" name="paciente_nome" class="form-control" placeholder="Digite o nome do paciente" onkeyup="buscarPacientes()" required>
    <select id="paciente_dropdown" name="paciente_dropdown" class="form-control mt-2" style="display: none;" onchange="selecionarPaciente()">
        <!-- Pacientes serão carregados dinamicamente aqui -->
    </select>
</div>

<script>
    function buscarPacientes() {
        const nomePaciente = document.getElementById('paciente_nome').value;
        const dropdown = document.getElementById('paciente_dropdown');
        
        if (nomePaciente.length === 0) {
            dropdown.style.display = 'none';
            dropdown.innerHTML = '';
            return;
        }
        
        // Fazendo a requisição ao script PHP usando fetch
        fetch(`buscar-paciente.php?nome_paciente=${encodeURIComponent(nomePaciente)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    dropdown.style.display = 'block';
                    dropdown.innerHTML = '';

                    // Adicionando opções ao dropdown
                    data.forEach(nome => {
                        const option = document.createElement('option');
                        option.value = nome;
                        option.textContent = nome;
                        dropdown.appendChild(option);
                    });
                } else {
                    dropdown.style.display = 'none';
                    dropdown.innerHTML = '';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar pacientes:', error);
            });
    }

    function selecionarPaciente() {
        const dropdown = document.getElementById('paciente_dropdown');
        const pacienteNomeInput = document.getElementById('paciente_nome');

        // Atualiza o campo de texto com o nome selecionado no dropdown
        pacienteNomeInput.value = dropdown.value;
        dropdown.style.display = 'none';
    }
</script>

            <div class="form-group mb-3">
                <label for="symptoms">Sintomas</label>
                <textarea id="symptoms" name="symptoms" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="diagnosis">Diagnóstico</label>
                <textarea id="diagnosis" name="diagnosis" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="medications">Medicamentos</label>
                <input type="text" id="medications" name="medications" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="exams">Exames Solicitados</label>
                <input type="text" id="exams" name="exams" class="form-control" required>
            </div>
            <div class="form-group mb-3">
            <label for="return_bool">Retorno</label>
            <select id="return_bool" name="return_bool" class="form-control" required>
                <option value=""></option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
            
            <div id="return_date_container" style="display: none;">
                <label for="return_date">Data de Retorno</label>
                <input type="date" id="return_date" name="return_date" class="form-control" required>
            </div>
            
            <script>
                document.getElementById('return_bool').addEventListener('change', function() {
                    var returnBoolValue = this.value;
                    var returnDateContainer = document.getElementById('return_date_container');
            
                    if (returnBoolValue == '1') {
                        returnDateContainer.style.display = 'block';
                    } else {
                        returnDateContainer.style.display = 'none';
                    }
                });
            </script>

            </div>
            <button type="submit" class="btn btn-primary">Salvar Prontuário</button>
        </form>
    </div>

   
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
