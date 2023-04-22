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