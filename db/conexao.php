<?php

$dbEnv = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sistema-medico/.git/.env");

$host = $dbEnv["HOST"];
$username = $dbEnv["USERNAME"];
$password = $dbEnv["PASSWORD"];
$dbname = $dbEnv["DBNAME"];

$conn = new mysqli($host, $username, $password, $dbname);

if($conn->connect_error){
    echo "Erro na conexão " . $conn->connect_error;
    exit;
}