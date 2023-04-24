<?php

function url(){
    return sprintf("%s://%s",
            (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != 'off')?"https":"http",
            $_SERVER["SERVER_NAME"]);
}

function getTipo($tipo = ""){
    
    if($tipo == "MEDICO"){
        return "Médico";
    }else if($tipo == "PACIENTE"){
        return "Paciente";
    }

    return "";
}

function convertDate($data, $patternIn = "/", $patternOut = "-"){
    
    $dataExplode = explode($patternIn, $data); //transforma a data em um array pela barra --> 20/10/2023 = [20, 10, 2023]
    $dataExplode = array_reverse($dataExplode); // inverte esse array --> [2023, 10, 20]

    return implode($patternOut, $dataExplode); // transforma o array invertido numa string --> 2023-10-20
}

//retorna apenas valores numericos, ignorando . e -
function onlyNumber($valor){
    return preg_replace("/[^0-9]/", "", $valor);
}

function getStatus($status){
    switch($status){
        case 'ATV':
            return "Ativo";
        
        case 'FIN':
            return "Finalizado";

        case 'CAN':
            return "Cancelado";
        default : return "N/D";
    }
}