<?php
// Inicia a sessão para podermos "lembrar" que o usuário está logado
session_start();
require 'config.php';
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // trim() para evitar o erro do espaço no e-mail
    $senha = $_POST['senha'];

    $client = new Client();
    
    // URL da API para verificar e-mail e senha
    $authUrl = $supabaseUrl . '/auth/v1/token?grant_type=password';

    try {
        $response = $client->post($authUrl, [
            'headers' => [
                'apikey' => $supabaseKey,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'email' => $email,
                'password' => $senha
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            // Transforma a resposta do Supabase em um array do PHP
            $resultado = json_decode($response->getBody()->getContents(), true);
            
            // Salva o token de acesso (crachá do usuário) na sessão do PHP
            $_SESSION['usuario_token'] = $resultado['access_token'];
            $_SESSION['usuario_email'] = $email;
            
            // Redireciona para o painel com CRUD
            header('Location: painel.php');
            exit;
        }
        
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        // Se cair aqui, significa que o Supabase rejeitou o e-mail ou a senha
        echo "<h2>Acesso Negado</h2>";
        echo "<p>E-mail ou senha incorretos. <a href='login.html'>Tente novamente</a>.</p>";
    } catch (Exception $e) {
        // Erros gerais de servidor
        echo "Erro no servidor: " . $e->getMessage();
    }
}
?>