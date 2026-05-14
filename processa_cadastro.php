<?php
require 'config.php';
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
        echo "Erro ao cadastrar: nome, email e senha são obrigatórios.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Erro ao cadastrar: email inválido.";
        exit;
    }

    if (strlen($senha) < 6) {
        echo "Erro ao cadastrar: a senha deve ter ao menos 6 caracteres.";
        exit;
    }

    $client = new Client();
    
    // AQUI ESTÁ A MUDANÇA PRINCIPAL: Estamos mandando para o /auth/v1/signup
    $authUrl = $supabaseUrl . '/auth/v1/signup';

    try {
        $response = $client->post($authUrl, [
            'headers' => [
                'apikey' => $supabaseKey,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'email' => $email,
                'password' => $senha,
                'data' => [
                    'nome' => $nome
                ]
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            echo "Usuário cadastrado com sucesso no sistema de Autenticação!";
            echo "<br><a href='login.html'>Ir para o Login</a>";
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        $responseBody = $e->getResponse()->getBody()->getContents();
        $errorData = json_decode($responseBody, true);
        $message = $errorData['msg'] ?? $errorData['error_description'] ?? $errorData['message'] ?? $responseBody;
        echo "Erro ao cadastrar: " . $message;
    } catch (Exception $e) {
        echo "Erro no servidor: " . $e->getMessage();
    }
}
?>