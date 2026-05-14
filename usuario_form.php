<?php
session_start();
require 'config.php';
use GuzzleHttp\Client;

if (empty($_SESSION['usuario_email'])) {
    header('Location: login.html');
    exit;
}

$client = new Client();
$error = null;
$nome = '';
$email = '';
$id = null;

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $response = $client->get($apiUrl . '?select=*&id=eq.' . urlencode($id), [
            'headers' => [
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Accept' => 'application/json'
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        if (!empty($data[0])) {
            $nome = $data[0]['nome'] ?? '';
            $email = $data[0]['email'] ?? '';
        }
    } catch (\Exception $e) {
        $error = 'Erro ao buscar usuário: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nome === '' || $email === '') {
        $error = 'Nome e email são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido.';
    } else {
        try {
            if ($id) {
                $response = $client->patch($apiUrl . '?id=eq.' . urlencode($id), [
                    'headers' => [
                        'apikey' => $supabaseKey,
                        'Authorization' => 'Bearer ' . $supabaseKey,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => [
                        'nome' => $nome,
                        'email' => $email
                    ]
                ]);
                header('Location: painel.php');
                exit;
            } else {
                $response = $client->post($apiUrl, [
                    'headers' => [
                        'apikey' => $supabaseKey,
                        'Authorization' => 'Bearer ' . $supabaseKey,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => [
                        'nome' => $nome,
                        'email' => $email
                    ]
                ]);
                header('Location: painel.php');
                exit;
            }
        } catch (\Exception $e) {
            $error = 'Erro ao salvar usuário: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Editar usuário' : 'Cadastrar usuário'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2><?php echo $id ? 'Editar usuário' : 'Cadastrar usuário'; ?></h2>
    <?php if ($error): ?>
        <p style="color:red"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="usuario_form.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <button type="submit"><?php echo $id ? 'Salvar alterações' : 'Cadastrar'; ?></button>
    </form>
    <p><a href="painel.php">Voltar ao Painel</a></p>
</body>
</html>
