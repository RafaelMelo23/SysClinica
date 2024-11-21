<h1>Listar Consulta</h1>

<?php

$sql = "SELECT c.id_consulta, c.paciente_id_paciente, c.medico_id_medico, 
               c.data_consulta, c.hora_consulta, c.descricao_consulta,
               p.nome_paciente, m.nome_medico, pr.id_prontuario
        FROM consulta AS c
        INNER JOIN paciente AS p ON p.id_paciente = c.paciente_id_paciente
        INNER JOIN medico AS m ON m.id_medico = c.medico_id_medico
        LEFT JOIN prontuario AS pr ON pr.id_consulta = c.id_consulta";


$res = $conn->query($sql);

$qtd = $res->num_rows;

if($qtd > 0){
    print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";
    print "<table class='table table-bordered table-striped table-hover'>";
    print "<tr>";
    print "<th>#</th>";
    print "<th>Paciente</th>";
    print "<th>Médico</th>";
    print "<th>Data</th>";
    print "<th>Hora</th>";
    print "<th>Descrição</th>";
    print "<th>Ações</th>";
    print "</tr>";

    // Exibe as consultas
    while($row = $res->fetch_object()){
        print "<tr>";
        print "<td>".$row->id_consulta."</td>";
        print "<td>".$row->nome_paciente."</td>";
        print "<td>".$row->nome_medico."</td>";
        print "<td>".$row->data_consulta."</td>";
        print "<td>".$row->hora_consulta."</td>";
        print "<td>".$row->descricao_consulta."</td>";

        // Ações para editar, excluir e visualizar o prontuário
        print "<td>
                    <button class='btn btn-success' onclick=\"location.href='?page=editar-consulta&id_consulta=".$row->id_consulta."';\">Editar</button>
                    <button class='btn btn-danger' onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar-consulta&acao=excluir&id_consulta=".$row->id_consulta."';}else{false;}\">Excluir</button>";
                    
                    // Verifica se existe prontuário associado à consulta
                    if ($row->id_prontuario) {
                        // Se houver prontuário, mostra o botão "Prontuário"
                        print "<button class='btn btn-primary' onclick=\"location.href='?page=prontuario-paciente&id_prontuario=".$row->id_prontuario."';\">Prontuário</button>";
                    } else {
                        // Caso contrário, exibe um aviso ou outro comportamento
                        print "<button class='btn btn-secondary' disabled>Prontuário Não Criado</button>";
                    }

        print "</td>";
        print "</tr>";
    }
    print "</table>";
} else {
    print "Não encontrou resultado";
}
?>
