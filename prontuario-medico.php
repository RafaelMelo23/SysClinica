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
<div class="container mt-5">
        
        <h2 class="mb-4">Cadastrar Prontuário</h2>
        <h4 class="mb-4">Médico: <?php echo $_SESSION['nome_medico']; ?></h3>
        <form method="POST" action="prontuario_processamento.php">
         
        <div class="form-group mb-3">
    <label for="paciente_nome">Nome do Paciente</label>
    <input type="text" id="paciente_nome" name="paciente_nome" class="form-control" placeholder="Digite o nome do paciente" onkeyup="buscarPacientes()" required>
    <select id="paciente_dropdown" name="paciente_dropdown" class="form-control mt-2" style="display: none;" onchange="selecionarPaciente()">
         

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
        fetch(`buscar-paciente-prontuario.php?nome_paciente=${encodeURIComponent(nomePaciente)}`)
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            dropdown.style.display = 'block';
            dropdown.innerHTML = '';

            const optionPlaceholder = document.createElement('option');
            optionPlaceholder.value = '';
            optionPlaceholder.textContent = '--Selecione um paciente--';
            dropdown.appendChild(optionPlaceholder);

            data.forEach(paciente => {
                const option = document.createElement('option');
                option.value = paciente.id_paciente; // Valor é o ID do paciente
                option.textContent = paciente.nome_paciente; // Texto exibido é o nome do paciente
                dropdown.appendChild(option);
                
            });

            
            dropdown.onchange = selecionarPaciente;
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
    const pacienteIdInput = document.getElementById('id_paciente');

    if (dropdown.selectedIndex !== -1) {

    
    pacienteNomeInput.value = dropdown.options[dropdown.selectedIndex].text;
    pacienteIdInput.value = dropdown.value;
    console.log(pacienteIdInput.value);
}
    dropdown.style.display = 'none';
    }

</script>

            <div class="form-group mb-3">
                <input type="hidden" id="id_paciente" name="id_paciente">
                <label for="sintomas">Sintomas</label>
                <textarea id="sintomas" name="sintomas" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="diagnostico">Diagnóstico</label>
                <textarea id="diagnostico" name="diagnostico" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="medicamentos">Medicamentos</label>
                <input type="text" id="medicamentos" name="medicamentos" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="exames">Exames Solicitados</label>
                <input type="text" id="exames" name="exames" class="form-control" required>
            </div>
            <div class="form-group mb-3">
            <label for="retorno_boolean">Retorno</label>
            <select id="retorno_boolean" name="retorno_boolean" class="form-control" required>
                <option value=""></option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
            
            
            <div id="container_data_retorno" style="display: none;">
                <label for="data_retorno">Data de Retorno</label>
                <input type="date" id="data_retorno" name="data_retorno" class="form-control" required>
            </div>
            
            <script>
                document.getElementById('retorno_boolean').addEventListener('change', function() {
                    var returnBoolValue = this.value;
                    var returnDateContainer = document.getElementById('container_data_retorno');
            
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
