<?php 
session_start();

// Definir erros para debugging (desativar em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuário Médico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .top-left {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <button class="btn btn-primary top-left" onclick="window.history.back();">Voltar</button>
</div>
<div class="container mt-5">
    <h2 class="mb-4">Cadastrar Prontuário</h2>
    <h4 class="mb-4">Médico: <?= htmlspecialchars($_SESSION['nome_medico'] ?? 'Desconhecido') ?></h4>

    <form id="prontuario-form" method="POST" action="prontuario_processamento.php">
        <!-- Campo de busca por paciente -->
        <div class="form-group mb-3">
            <label for="paciente_nome">Nome do Paciente</label>
            <input type="text" id="paciente_nome" name="paciente_nome" class="form-control" placeholder="Digite o nome do paciente" required>
            <div id="paciente_dropdown_container" class="mt-2" style="display: none;">
                <select id="paciente_dropdown" name="paciente_dropdown" class="form-control">
                    <option value="">--Selecione um Paciente--</option>
                </select>
            </div>
            <input type="hidden" id="id_paciente" name="id_paciente">
        </div>

        <!-- Dropdown de consultas -->
        <div class="form-group mb-3">
            <label for="consulta_dropdown">Selecione a Consulta</label>
            <select id="consulta_dropdown" name="consulta_dropdown" class="form-control">
                <option value="">--Selecione uma consulta--</option>
            </select>
        </div>

        <!-- Outros campos -->
        <?php 
        function gerarCampo($id, $label, $tipo = "text", $extra = "") {
            return "
            <div class='form-group mb-3'>
                <label for='{$id}'>{$label}</label>
                <input type='{$tipo}' id='{$id}' name='{$id}' class='form-control' {$extra}>
            </div>";
        }
        ?>

        <?= gerarCampo("sintomas", "Sintomas", "textarea", "rows='4' required") ?>
        <?= gerarCampo("diagnostico", "Diagnóstico", "textarea", "rows='4' required") ?>
        <?= gerarCampo("medicamentos", "Medicamentos", "text", "required") ?>
        <?= gerarCampo("exames", "Exames Solicitados", "text", "required") ?>

        <div class="form-group mb-3">
            <label for="retorno_boolean">Retorno</label>
            <select id="retorno_boolean" name="retorno_boolean" class="form-control" required>
                <option value="">--Selecione--</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
            <div id="container_data_retorno" style="display: none;">
                <label for="data_retorno">Data de Retorno</label>
                <input type="date" id="data_retorno" name="data_retorno" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Prontuário</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const pacienteNomeInput = document.getElementById('paciente_nome');
    const pacienteDropdown = document.getElementById('paciente_dropdown');
    const consultaDropdown = document.getElementById('consulta_dropdown');
    const idPacienteHidden = document.getElementById('id_paciente');
    const retornoDropdown = document.getElementById('retorno_boolean');
    const dataRetornoContainer = document.getElementById('container_data_retorno');
    const dataRetornoInput = document.getElementById('data_retorno');

    // Controla exibição do campo de data de retorno
    retornoDropdown.addEventListener("change", () => {
        if (retornoDropdown.value === "1") {
            dataRetornoContainer.style.display = 'block'; // Mostra o campo de data
            dataRetornoInput.setAttribute("required", "required"); // Torna obrigatório
        } else {
            dataRetornoContainer.style.display = 'none'; // Esconde o campo de data
            dataRetornoInput.removeAttribute("required"); // Remove obrigatoriedade
            dataRetornoInput.value = ''; // Limpa o valor
        }
    });

    // Outros eventos como busca de pacientes e consultas...
    pacienteNomeInput.addEventListener("keyup", () => {
        const nome = pacienteNomeInput.value.trim();
        console.log(`[DEBUG] Nome digitado: ${nome}`);
        if (!nome) {
            pacienteDropdown.innerHTML = '<option value="">--Selecione um Paciente--</option>';
            pacienteDropdown.parentElement.style.display = 'none';
            return;
        }

        fetch(`buscar-paciente-prontuario.php?nome_paciente=${encodeURIComponent(nome)}`)
            .then(res => {
                console.log('[DEBUG] Resposta da busca de pacientes:', res);
                if (!res.ok) {
                    throw new Error(`HTTP Error: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('[DEBUG] Pacientes recebidos:', data);
                pacienteDropdown.innerHTML = data.length
                    ? `<option value="">--Selecione um Paciente--</option>` +
                      data.map(paciente => `<option value="${paciente.id_paciente}">${paciente.nome_paciente}</option>`).join('')
                    : `<option value="">Nenhum paciente encontrado</option>`;
                pacienteDropdown.parentElement.style.display = 'block';
            })
            .catch(err => console.error("[DEBUG] Erro ao buscar pacientes:", err));
    });

    pacienteDropdown.addEventListener("change", () => {
        const selectedPaciente = pacienteDropdown.value;
        console.log(`[DEBUG] Paciente selecionado: ${selectedPaciente}`);
        idPacienteHidden.value = selectedPaciente || '';

        if (selectedPaciente) {
            fetch(`buscar-consultas.php?id_paciente=${encodeURIComponent(selectedPaciente)}`)
                .then(res => {
                    console.log('[DEBUG] Resposta da busca de consultas:', res);
                    if (!res.ok) {
                        throw new Error(`HTTP Error: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('[DEBUG] Consultas recebidas:', data);

                    consultaDropdown.innerHTML = `<option value="">--Selecione uma consulta--</option>` + 
                        (data.error
                            ? `<option value="">${data.error}</option>`
                            : data.length
                                ? data.map(consulta => `<option value="${consulta.id_consulta}">${consulta.data_consulta} - ${consulta.hora_consulta}</option>`).join('')
                                : `<option value="">Nenhuma consulta encontrada</option>`);
                })
                .catch(err => console.error("[DEBUG] Erro ao buscar consultas:", err));
        } else {
            consultaDropdown.innerHTML = '<option value="">--Selecione uma consulta--</option>';
        }
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
