<?php

$id = $_POST["id"];
$nome = $_POST["nome"];
$crm = $_POST["crm"];

$foto = $_FILES["foto"];
$valid = true;
$msg = "";
// var_dump($foto);

if($foto["name"] != ""){

    if($foto["size"] > (1024 * 1024 * 2)){
        $msg = "Tamanho da foto é inválido";
        $valid = false;
    }

    if(!in_array($foto["type"], ['image/jpeg'])){
        $msg = "O tipo do arquivo é inválido";
        $valid = false;
    }

    /*
    if($valid){
        //envia a foto pro servidor
        move_uploaded_file($foto["tmp_name"], "fotomedico/foto1.png");
    } */
}

if(!$valid){
    header("location: medico.php?m=" . base64_encode($msg));
    exit;
}

require_once "db/conexao.php";

$extensao = explode(".", $foto["name"]);
$numeroPosicao = count($extensao);
$ext = $extensao[$numeroPosicao - 1];

$fileName = date('YmdHis').rand(1000,9999) . "." . $ext;

// id != "" == editar dados
if($id != ""){
    $sqlMedico = "SELECT id, foto FROM tbmedico WHERE id = " . $id;

    $resultSetMedico = $conn->query($sqlMedico);
    if(mysqli_num_rows($resultSetMedico) > 0){
        $medico = mysqli_fetch_assoc($resultSetMedico);
        if($foto["name"] == ""){
            $fileName = $medico["foto"];
        }
        $sql = "UPDATE tbmedico SET nome = '$nome', crm = '$crm', foto = '$fileName' WHERE id = " . $id;
        if($conn->query($sql)){
            if($foto["name"] != ""){
                unlink("fotomedico/" . $medico["foto"]);
                move_uploaded_file($foto["tmp_name"], "fotomedico/" . $fileName);
            }
            $msg = "Cadastrado com sucesso!";
        }
    }
}else{
    // id == "" gravar dados
    $sql = "INSERT INTO tbmedico VALUES(NULL, '$nome', '$crm', '$fileName')";
    if($conn->query($sql)){
        move_uploaded_file($foto["tmp_name"], "fotomedico/" . $fileName);
        $msg = "Cadastro realizado com sucesso!";
    }else{
        $msg = "Erro ao cadastrar.";
    }
}

$conn->close();

header("location: medico.php?m=" . base64_encode($msg));
exit;