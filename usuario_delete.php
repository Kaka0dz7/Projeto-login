<?php
session_start();
require 'config.php';
use GuzzleHttp\Client;

if (empty($_SESSION['usuario_email'])) {
    header('Location: login.html');
    exit;
}

if (empty($_GET['id'])) {
    header('Location: painel.php');
    exit;
}

$id = $_GET['id'];
$client = new Client();

try {
    $client->delete($apiUrl . '?id=eq.' . urlencode($id), [
        'headers' => [
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey
        ]
    ]);
} catch (\Exception $e) {
    // Ignorar erro para exibir no painel se necessário.
}

header('Location: painel.php');
exit;
