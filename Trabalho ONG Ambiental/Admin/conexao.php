<?php
$host = "localhost";
$user = "root";
$senha = "";
$banco = "ong";
/*$port = "3308";*/

$conn = new mysqli($host, $user, $senha, $banco /*,$port*/);

if($conn->connect_error){
    die("Erro de conexão: " . $conn->connect_error);
}
?>