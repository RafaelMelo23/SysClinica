<?php

    
	
    if (isset($_REQUEST['id_paciente'])) {
    
    $id_paciente = $_REQUEST['id_paciente'];
        $sql_paciente = "SELECT * FROM paciente WHERE id_paciente=".$_REQUEST['id_paciente'];

	$res = $conn->query($sql_paciente);

	$row = $res->fetch_object();

    $sql_prontuario = "SELECT * FROM prontuario WHERE id_paciente=".$_REQUEST['id_paciente'];

    $res = $conn->query($sql_prontuario);

    $row_prontuario = $res->fetch_object();

    

    if (isset($row_prontuario->created_at)) {
        $created_at = $row_prontuario->created_at;
        $formatted_date = date('d/m/Y H:i', strtotime($created_at));
        
    } else {
        echo "Data de criação não encontrada.";
    }
}
?>

<h1>Prontuário do Paciente: <?php print $row->nome_paciente; ?><br>Data da consulta: <?php print $formatted_date; ?></h1>

<div class="form-group mb-3">
    <label for="medico">Médico</label>
    <textarea id="medico" name="medico" class="form-control" rows="1"readonly></textarea>
    <label for="medico_especialidade">Especialidade</label>
    <textarea id="medico_especialidade" name="medico_especialidade" class="form-control" rows="1"readonly></textarea>
</div>
<div class="form-group mb-3">
    <label for="symptoms">Sintomas</label>
    <textarea id="symptoms" name="symptoms" class="form-control" rows="4"readonly><?php echo htmlspecialchars($row_prontuario->sintomas); ?> </textarea>
</div>

<div class="form-group mb-3">
    <label for="diagnosis">Diagnóstico</label>
    <textarea id="diagnosis" name="diagnosis" class="form-control" rows="4" readonly><?php echo htmlspecialchars($row_prontuario->diagnostico); ?> 
    </textarea>
</div>

<div class="form-group mb-3">
    <label for="medications">Medicamentos</label>
    <input type="text" id="medications" name="medications" class="form-control" readonly>
</div>

<div class="form-group mb-3">
    <label for="exams">Exames Solicitados</label>
    <input type="text" id="exams" name="exams" class="form-control" readonly>
</div>

<div class="form-group mb-3">
    <label for="return_bool">Retorno</label>
    <select id="return_bool" name="return_bool" class="form-control" disabled>
    <option value="">--</option>    
    <option value="1" selected>Sim</option>
        <option value="0">Não</option>
    </select>
    
    <div id="return_date_container" style="display: block;">
        <label for="return_date">Data de Retorno</label>
        <input type="date" id="return_date" name="return_date" class="form-control"readonly>
    </div>
</div>

<nav aria-label="Navegação de prontuários">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="?pagina=1" aria-label="Primeira">
                <span aria-hidden="true">&laquo;&laquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?pagina=anterior" aria-label="Anterior">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        
        <!-- Exemplo de páginas numeradas -->
        <li class="page-item"><a class="page-link" href="?pagina=1">1</a></li>
        <li class="page-item"><a class="page-link" href="?pagina=2">2</a></li>
        <li class="page-item"><a class="page-link" href="?pagina=3">3</a></li>
        <li class="page-item"><a class="page-link" href="?pagina=4">4</a></li>
        <li class="page-item"><a class="page-link" href="?pagina=5">5</a></li>
        
        <li class="page-item">
            <a class="page-link" href="?pagina=proxima" aria-label="Próxima">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?pagina=ultima" aria-label="Última">
                <span aria-hidden="true">&raquo;&raquo;</span>
            </a>
        </li>
    </ul>
</nav>

