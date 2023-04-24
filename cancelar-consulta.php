<?php

require_once "db/conexao.php";

$id = mysqli_escape_string($conn, $_GET["id"]);

$sql = "UPDATE tbconsulta SET status = 'CAN ' WHERE id = " . $id;

if($conn->query($sql)){
    $msg = "Consulta cancelada com sucesso";
}else{
    $msg = "Erro ao cancelar consulta";
}

$conn->close();

header("location: buscar-consulta.php?m=" . base64_encode($msg));