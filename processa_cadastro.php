<?php
// Conecta ao banco de dados (certifique-se que $conn está definido aqui)
include("conexao.php"); 

// Recebe os dados do formulário
$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Criptografa a senha
$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

// 1. Usamos "?" como placeholders para evitar SQL Injection
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";

// 2. Prepara a query
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // 3. Vincula os parâmetros ("sss" significa que são 3 strings)
    mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senhaSegura);

    // 4. Executa
    if (mysqli_stmt_execute($stmt)) {
        // Redireciona ANTES de imprimir qualquer texto na tela
        header("Location: login.php?sucesso=1");
        exit(); // Sempre use exit após um header de redirecionamento
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Erro na preparação do banco de dados.";
}

mysqli_close($conn);
?>      
        