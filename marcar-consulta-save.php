<?php

$idpaciente = $_POST["idpaciente"];
$especialidade = $_POST["especialidade"];
$medico = $_POST["medico"];
$dt_consulta = $_POST["dt_consulta"];
$hr_consulta = $_POST["hr_consulta"];


require_once "util/funcao.php";

$dt_consulta_db = convertDate($dt_consulta, "/", "-");


require_once "db/conexao.php";

$sqlMarcarConsulta = "INSERT INTO tbconsulta VALUES(NULL, '$dt_consulta_db', '$hr_consulta', 'ATV', NULL,
                    $medico, $especialidade, $idpaciente)";

//echo $sqlMarcarConsulta;

if($conn->query($sqlMarcarConsulta)){
    $msg = "Consulta marcada com sucesso";
}else{
    $msg = "Erro ao marcar consulta";
}

$conn->close();

header("location: marcar-consulta.php?m=" . base64_encode($msg));