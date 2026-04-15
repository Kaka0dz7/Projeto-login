<?php
// Configurações do banco de dados
$servername = "localhost";  // Ou o host do seu banco (ex.: para Supabase, seria diferente)
$username = "root";         // Seu usuário do banco
$password = "";             // Sua senha do banco
$dbname = "projeto_login";  // Nome do banco de dados

// Cria a conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica se a conexão falhou
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>