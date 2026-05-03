<?php
require 'config.php';
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

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
            echo "<br><a href='login.php'>Ir para o Login</a>";
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        $responseBody = $e->getResponse()->getBody()->getContents();
        $errorData = json_decode($responseBody, true);
        echo "Erro ao cadastrar: " . ($errorData['msg'] ?? 'Verifique os dados.');
    } catch (Exception $e) {
        echo "Erro no servidor: " . $e->getMessage();
    }
}
?>