<?php

	$sql = "SELECT * FROM paciente WHERE id_paciente=".$_REQUEST['id_paciente'];

	$res = $conn->query($sql);

	$row = $res->fetch_object();
?>

<h1>Prontuário do Paciente: <?php print $row->nome_paciente; ?></h1>

<div class="form-group mb-3">
    <label for="symptoms">Sintomas</label>
    <textarea id="symptoms" name="symptoms" class="form-control" rows="4" readonly>
        <!-- Aqui você pode exibir os sintomas do paciente -->
    </textarea>
</div>

<div class="form-group mb-3">
    <label for="diagnosis">Diagnóstico</label>
    <textarea id="diagnosis" name="diagnosis" class="form-control" rows="4" readonly>
        <!-- Aqui você pode exibir o diagnóstico do paciente -->
    </textarea>
</div>

<div class="form-group mb-3">
    <label for="medications">Medicamentos</label>
    <input type="text" id="medications" name="medications" class="form-control" value="Medicamento Exemplo" readonly>
</div>

<div class="form-group mb-3">
    <label for="exams">Exames Solicitados</label>
    <input type="text" id="exams" name="exams" class="form-control" value="Exame de Sangue, Raios-X" readonly>
</div>

<div class="form-group mb-3">
    <label for="return_bool">Retorno</label>
    <select id="return_bool" name="return_bool" class="form-control" disabled>
        <option value="1" selected>Sim</option>
        <option value="0">Não</option>
    </select>
    
    <div id="return_date_container" style="display: block;">
        <label for="return_date">Data de Retorno</label>
        <input type="date" id="return_date" name="return_date" class="form-control" value="2024-12-15" readonly>
    </div>
</div>
