<?php

require_once "db/conexao.php";

$consulta_medica = $_POST["consulta_medica"];
$idconsulta = $_POST["idconsulta"];

$sqlUpdateConsulta = "UPDATE tbconsulta SET consulta = '$consulta_medica', status = 'FIN'
                    WHERE id = " . $idconsulta;

if($conn->query($sqlUpdateConsulta)){
    $msg = "Consulta realizada com sucesso!";
}else{
    $msg = "Erro ao realizar consulta.";
}

$conn->close();

header("location: buscar-consulta.php?m=" . base64_encode($msg));