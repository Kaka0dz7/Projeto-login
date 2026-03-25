<?php
include 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

// Base64 (não seguro)
$senha_codificada = base64_encode($senha);

// Inserir
$sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':email' => $email,
        ':senha' => $senha_codificada
    ]);
    echo "Usuário registrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>