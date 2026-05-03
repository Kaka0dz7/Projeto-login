<?php
require 'config.php';
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $client = new Client();

    try {
        $response = $client->post($apiUrl, [
            'headers' => [
                'apikey'    => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type'  => 'application/json',
                'Prefer'        => 'return=minimal' // Retorna apenas status 201 se der certo
            ],
            'json' => [
                'nome' => $nome,
                'email' => $email
            ]
        ]);

        if ($response->getStatusCode() === 201) {
            echo "Usuário cadastrado com sucesso!";
        }
    } catch (Exception $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}