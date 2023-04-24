<?php

require_once "db/conexao.php";
require_once "util/funcao.php";

$cpf = $_POST["cpf"];
$medico = $_POST["medico"];
$data = $_POST["data"];
$status = $_POST["status"];

$cpf = onlyNumber($cpf);

if($data != ""){
    $dataDb = convertDate($data);
}else{
    $dataDb = date('Y-m-d');
    //$dataDb = now();
}

$sqlConsulta = "SELECT c.id AS idconsulta, c.dt_consulta, c.hr_consulta, c.status, m.nome AS nomemedico,
                p.nome AS nomepaciente, e.especialidade
                FROM tbconsulta c
                INNER JOIN tbpaciente p ON p.id = c.paciente_id
                INNER JOIN tbmedico m ON m.id = c.medico_id
                INNER JOIN tbespecialidade e ON e.id = c.especialidade_id
                WHERE c.dt_consulta = '" .$dataDb. "' ";

if($medico != ""){
    $sqlConsulta .= " AND m.id = " . $medico ;
}

if($cpf != ""){
    $sqlConsulta .= " AND p.cpf = '" .$cpf. "' ";
}
/*
    status
    ATV -- ativo
    CAN -- cancelado
    FIN -- finalizado
*/

if($status != ""){
    $sqlConsulta .= " AND c.status = '".$status."' ";
}else{
    $sqlConsulta .= " AND c.status IN ('ATV', 'FIN') ";
}

$sqlConsulta .= " ORDER BY hr_consulta";


$resultSetConsulta = $conn->query($sqlConsulta);
$lista = [];
if(mysqli_num_rows($resultSetConsulta) > 0){
    while($consulta = mysqli_fetch_assoc($resultSetConsulta)){
        $dt = DateTime::createFromFormat("Y-m-d", $consulta["dt_consulta"]);
        $consulta["status"] = getStatus($consulta["status"]);
        $consulta["dt_consulta"] = $dt->format("d/m/Y");
        array_push($lista, $consulta);
    }
}

echo json_encode(['status' => 'ok', 'dados' => $lista]);

$conn->close();