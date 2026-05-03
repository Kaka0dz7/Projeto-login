<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$supabaseUrl = $_ENV['SUPABASE_URL'];
$supabaseKey = $_ENV['SUPABASE_KEY'];

// A URL para inserir dados segue o padrão: URL_DO_PROJETO/rest/v1/NOME_DA_TABELA
$apiUrl = $supabaseUrl . '/rest/v1/usuarios';