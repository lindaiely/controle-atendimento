<?php

require_once "db/conexao.php";

$especialidade = mysqli_escape_string($conn, $_POST["especialidade"]);

$sql = "INSERT INTO tbespecialidade VALUES (NULL, '$especialidade')";

if($conn->query($sql)){
    $msg = "Especialidade cadastrada com sucesso!";
}else{
    $msg = "Erro ao cadastrar.";
}

$conn->close();
header("location: especialidade.php?m=" . base64_encode($msg));