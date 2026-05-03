<?php
session_start();
require 'config.php'; // Adicione isso para carregar a URL e a KEY

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // O endpoint de login do Supabase
    $url = $supabaseUrl . '/auth/v1/token?grant_type=password';

    $dados = json_encode([
        "email" => $email,
        "password" => $senha
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $supabaseKey,
        'Content-Type: application/json'
    ]);

    $resposta = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $resultado = json_decode($resposta, true);

    if ($httpCode !== 200) {
        echo "Erro ao logar: " . ($resultado['error_description'] ?? 'Credenciais inválidas');
    } else {
        $_SESSION['usuario_token'] = $resultado['access_token'];
        header("Location: index.html");
        exit;
    }
}
?>