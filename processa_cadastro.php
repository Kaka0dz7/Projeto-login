<?php
// Conecta ao banco de dados
include("login.php");

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Criptografa a senha usando password_hash para segurança
$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

// Insere os dados no banco de dados
$sql = "INSERT INTO usuarios (nome, email, senha)
VALUES ('$nome', '$email', '$senhaSegura')";


// Verifica se a inserção foi bem-sucedida e redireciona para a página de login
if(mysqli_query($conn, $sql)){
   echo "Cadastro realizado com sucesso!";

   // Redireciona para a página de login após o cadastro
   header("Location: login.php");

 }else{
 // Exibe uma mensagem de erro caso o cadastro falhe
        echo "Erro ao cadastrar.";
        }       
        