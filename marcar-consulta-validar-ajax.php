<?php

require_once "db/conexao.php";
require_once "util/funcao.php";

$medico = $_POST["medico"];
$dt_consulta = $_POST["dt_consulta"];
$hr_consulta = $_POST["hr_consulta"];

$dt_consulta_db = convertDate($dt_consulta, "/", "-");

$sqlValidarMedicoHorario = "SELECT id FROM tbconsulta WHERE medico_id = $medico AND dt_consulta =
                        '$dt_consulta_db' AND hr_consulta = '$hr_consulta' ";

$rsValidarMedicoHorario = $conn->query($sqlValidarMedicoHorario);

$dtResposta = ["status" => 'ok'];

if(mysqli_num_rows($rsValidarMedicoHorario) > 0 ){
    $dtResposta = ['status' => 'invalid', 'message' => 'Horário não disponível para este médico'];
}

$conn->close();

echo json_encode($dtResposta);