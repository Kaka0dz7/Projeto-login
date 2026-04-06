<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <!--Título que aparece na aba do navegador-->
    <TITLE>Cadastro</title>

    <!-- Conecta o arquivo CSS para estética --> 
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Título da página--> 
<h2>Criar Conta</h2>


<!-- Formulário de cadastro que envia os dados para processa_cadastro.php -->
<form action="processa_cadastro.php" method="POST">

<!-- Campos de entrada para nome, email e senha, todos obrigatórios -->
  <label>Nome:</label>
  <input type="text" name="nome"required>

  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Senha:</label>
  <input type="password" name="senha" required>

  <!-- Botão para enviar o formulário -->
  <button type="submit">Cadastrar</button>

</form>
<!-- Link para a página de login para usuários que já possuem conta -->
<a href="login.php">Já tenho conta</a>


</body>
</html>