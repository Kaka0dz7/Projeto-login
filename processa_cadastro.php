<?php
// Configurações do Supabase
$supabaseUrl = 'postgresql://postgres:[YOUR-PASSWORD]@db.qrugjmykqbnxbmivqkne.supabase.co:5432/postgres';
$supabaseKey = 'sb_publishable_ESqH6xevL62I-WvRC3wUXw_db6IqQXV';
$tableName   = 'usuarios';

// Recebe os dados do formulário
$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Criptografa a senha (sempre mantenha isso!)
$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

// Prepara os dados para o JSON
$dados = [
    'nome'  => $nome,
    'email' => $email,
    'senha' => $senhaSegura
];

// Inicializa o cURL para fazer a requisição HTTP POST
$ch = curl_init($supabaseUrl . "/rest/v1/" . $tableName);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($dados),
    CURLOPT_HTTPHEADER     => [
        "apikey: $supabaseKey",
        "Authorization: Bearer $supabaseKey",
        "Content-Type: application/json",
        "Prefer: return=minimal" // Opcional: economiza banda não retornando o objeto criado
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// No Supabase, o código 201 significa "Criado com sucesso"
if ($httpCode == 201) {
    header("Location: login.php?sucesso=1");
    exit();
} else {
    echo "Erro ao cadastrar no Supabase. Código HTTP: " . $httpCode;
    // Para debug, você pode imprimir o $response:
     var_dump($response);
}
?>    
        