<?php

    include('config.php');

 
    $nomePaciente = $_GET['nome_paciente'];
    

  
    $sql = "SELECT * FROM paciente WHERE nome_paciente LIKE '%{$nomePaciente}%'";
    
  
    $result = mysqli_query($conn, $sql) or die(json_encode(["Erro" => mysqli_error($conn)]));

 
    $output = [];
    
    
    while ($row = mysqli_fetch_array($result)) {
        $output[] = $row['nome_paciente'] . ' - ' . $row['id_paciente'];
    }

    
    mysqli_close($conn);

    
    echo json_encode($output);

?>
