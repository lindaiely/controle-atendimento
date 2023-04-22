<?php

$nome = $_POST["nome"];
$cpfcrm = $_POST["cpf_crm"];
$tipo = $_POST["tipo"];

require_once "db/conexao.php";
require_once "util/funcao.php";

// $sql = "SELECT id, nome, cpf, foto FROM tbpaciente p WHERE p.nome LIKE '$nome%'";
$sql = "SELECT id, nome, cpfcrm, foto, tipo FROM(
        SELECT id, nome, crm AS cpfcrm, CONCAT('fotomedico/', foto) as foto, 'MEDICO' AS tipo FROM tbmedico
        UNION ALL 
        SELECT id, nome, cpf AS cpfcrm, CONCAT('fotopaciente/', foto) as foto, 'PACIENTE' AS tipo FROM tbpaciente)
        AS consulta WHERE consulta.nome LIKE '$nome%' ";

if($cpfcrm != ""){
    $sql .= "AND cpfcrm = '$cpfcrm' ";
}

if($tipo != ""){
    $sql .= "AND tipo = '$tipo' ";
}

$sql .= "ORDER BY consulta.nome";

$registro = [];
$resultSetUsuario = $conn->query($sql);
if(mysqli_num_rows($resultSetUsuario) > 0){
    while($usuario = mysqli_fetch_assoc($resultSetUsuario)){
        $usuario["tipo"] = getTipo($usuario["tipo"]);
        array_push($registro, $usuario);
    }
}

$conn->close();

echo json_encode(['usuarios' => $registro]);