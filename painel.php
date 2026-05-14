<?php
session_start();
require 'config.php';
use GuzzleHttp\Client;

if (empty($_SESSION['usuario_email'])) {
    header('Location: login.html');
    exit;
}

$client = new Client();
$usuarios = [];
$error = null;

try {
    $response = $client->get($apiUrl . '?select=*', [
        'headers' => [
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Accept' => 'application/json'
        ]
    ]);
    $usuarios = json_decode($response->getBody()->getContents(), true);
} catch (\Exception $e) {
    $error = 'Erro ao carregar usuários: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Painel</h2>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_email']); ?>.</p>
    <p><a href="usuario_form.php">Incluir novo usuário</a> | <a href="logout.php">Sair</a></p>

    <?php if ($error): ?>
        <p style="color:red"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (empty($usuarios)): ?>
        <p>Nenhum registro encontrado.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email'] ?? ''); ?></td>
                        <td>
                            <a href="usuario_form.php?id=<?php echo urlencode($usuario['id']); ?>">Editar</a>
                            |
                            <a href="usuario_delete.php?id=<?php echo urlencode($usuario['id']); ?>" onclick="return confirm('Deseja excluir este registro?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
