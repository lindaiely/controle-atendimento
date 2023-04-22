<?php

$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$foto = $_FILES["foto"];

$valid = true;
$msg = "";

if($foto["name"] != ""){

    if($foto["size"] > (1024 * 1024 * 2)){
        $msg = "Tamanho da foto é inválido";
        $valid = false;
    }

    if(!in_array($foto["type"], ['image/jpeg', 'image/png'])){
        $msg = "O tipo do arquivo é inválido";
        $valid = false;
    }
}

require_once "db/conexao.php";

// verificando se o cpf ja existe no bd
$sqlCpf = "SELECT id FROM tbpaciente WHERE cpf = '$cpf'";
$rsPaciente = $conn->query($sqlCpf);

if(mysqli_num_rows($rsPaciente) > 0){
    $msg = "Paciente já existe no sistema.";
    $valid = false;
}


if($valid){

    $fileName = "";
    if($foto["name"] != ""){

        $extensao = explode(".", $foto["name"]);
        $numeroPosicao = count($extensao);
        $ext = $extensao[$numeroPosicao - 1];

        $fileName = date('YmdHis').rand(1000,9999) . "." . $ext;
    }
    
    
    $sqlInsertPaciente = "INSERT INTO tbpaciente VALUES(NULL, '$nome', '$cpf', '$fileName')";

    if($conn->query($sqlInsertPaciente)){
        move_uploaded_file($foto["tmp_name"], "fotopaciente/" . $fileName);
        $msg = "Cadastro realizado com sucesso";
    }else{
        $msg = "Erro ao cadastrar paciente";
    }
}

header("location: paciente.php?m= " . base64_encode($msg));