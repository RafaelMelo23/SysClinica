<h1>Listar Paciente</h1>

<div class="form-group mb-3">
    <label for="paciente_nome">Nome do Paciente</label>
    <input type="text" id="paciente_nome" name="paciente_nome" class="form-control" placeholder="Digite o nome do paciente" onkeyup="buscarPacientes()" required>
</div>

<div id="resultados">
    <p id="qtd-resultados"></p>
    <table id="tabela-pacientes" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Fone</th>
                <th>Endereço</th>
                <th>CPF</th>
                <th>Data de Nasc.</th>
                <th>Sexo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

<script>
    function buscarPacientes() {
        const nomePaciente = document.getElementById('paciente_nome').value;
        const tabelaPacientes = document.getElementById('tabela-pacientes').querySelector('tbody');
        const qtdResultados = document.getElementById('qtd-resultados');

        
        fetch(`buscar-paciente-listar.php?nome_paciente=${encodeURIComponent(nomePaciente)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar pacientes');
                }
                return response.json();
            })
            .then(data => {
                tabelaPacientes.innerHTML = ''; 

                if (data.length > 0) {
                    qtdResultados.textContent = `Encontrou ${data.length} resultado(s)`;

                    
                    data.forEach(paciente => {
                        const row = document.createElement('tr');
                        
                        const sexo = (paciente.sexo_paciente === 'm') ? 'Masculino' : 'Feminino';

                        row.innerHTML = `
                            <td>${paciente.id_paciente}</td>
                            <td>${paciente.nome_paciente}</td>
                            <td>${paciente.email_paciente}</td>
                            <td>${paciente.fone_paciente}</td>
                            <td>${paciente.endereco_paciente}</td>
                            <td>${paciente.cpf_paciente}</td>
                            <td>${paciente.dt_nasc_paciente}</td>
                            <td>${sexo}</td>
                            <td>
                                <button class='btn btn-success' onclick="location.href='?page=editar-paciente&id_paciente=${paciente.id_paciente}';">Editar</button>
                                <button class='btn btn-danger' onclick="if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar-paciente&acao=excluir&id_paciente=${paciente.id_paciente}';}else{false;}">Excluir</button>
                                <button class='btn btn-primary' onclick="location.href='?page=listar-prontuario&id_paciente=${paciente.id_paciente}';">Prontuário</button>
                            </td>
                        `;
                        
                        tabelaPacientes.appendChild(row);
                    });
                } else {
                    qtdResultados.textContent = 'Não encontrou resultado';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar pacientes:', error);
            });
    }
</script>
