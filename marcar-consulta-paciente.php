<?php

require_once "db/conexao.php";

$cpf = mysqli_escape_string($conn, $_GET["cpf"]);

$sql = "SELECT id, nome, cpf, foto FROM tbpaciente WHERE cpf = " . $cpf;

$resultSet = $conn->query($sql);
if(mysqli_num_rows($resultSet) > 0){
    $paciente = mysqli_fetch_assoc($resultSet);
    echo json_encode(['status' => 'ok', 'paciente' => $paciente]);
}else{
    echo json_encode(['status' => 'error', 'paciente' => []]);
}

$conn->close();