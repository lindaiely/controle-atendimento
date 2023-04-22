<?php

require_once "db/conexao.php";

$idEspecialidade = mysqli_escape_string($conn, $_GET["idespecialidade"]);

$sqlMedico = "SELECT id, nome FROM tbmedico m
            INNER JOIN tbmedicoespecialidade espmed ON m.id = espmed.medico_id 
            WHERE espmed.especialidade_id = " . $idEspecialidade;

$resultSetMedico = $conn->query($sqlMedico);
if(mysqli_num_rows($resultSetMedico) > 0){
    $listaMedico = [];
    while ($medico = mysqli_fetch_assoc($resultSetMedico)){
        array_push($listaMedico, $medico);
    }
    echo json_encode(['status' => 'ok', 'medicos' => $listaMedico]);
}else{
    echo json_encode(['status' => 'error', 'medicos' => []]);
}

$conn->close();