<?php
// 1. Inicia a sessão para podermos manter o usuário logado depois
session_start();

// 2. Suas credenciais do Supabase (O ideal é puxar de um arquivo .env)
$supabaseUrl = 'https://qrugjmykqbnxbmivqkne.supabase.co';
$apiKey = 'sb_publishable_ESqH6xevL62I-WvRC3wUXw_db6IqQXV';

// Simulando os dados que viriam do seu formulário HTML: $_POST['email']
$email = '';
$password = '';

// 3. Monta a URL da API de Autenticação do Supabase
$url = $supabaseUrl . '/auth/v1/token?grant_type=password';

// 4. Prepara os dados no formato JSON
$dados = json_encode([
    "email" => $email,
    "password" => $senha
]);

// 5. Inicia o cURL (a ferramenta do PHP para fazer requisições API)
$ch = curl_init($url);

// Configurações do cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retornar a resposta como texto
curl_setopt($ch, CURLOPT_POST, true);           // Método POST
curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);   // Enviando o e-mail e senha
curl_setopt($ch, CURLOPT_HTTPHEADER, [          // Cabeçalhos obrigatórios
    'apikey: ' . $apiKey,
    'Content-Type: application/json'
]);

// 6. Executa a requisição e fecha a conexão
$resposta = curl_exec($ch);
curl_close($ch);

// 7. Transforma a resposta do Supabase de volta para um Array do PHP
$resultado = json_decode($resposta, true);

// 8. Verifica se deu certo ou errado
if (isset($resultado['error'])) {
    echo "Erro ao logar: " . $resultado['error_description'];
} else {
    echo "Login feito com sucesso!";
    
    // Salva o token do usuário na sessão do PHP para ele não precisar logar de novo
    $_SESSION['usuario_token'] = $resultado['access_token'];
    
    // Aqui você pode redirecionar o usuário para o painel
     header("Location: index.html");
     exit;
}
?>