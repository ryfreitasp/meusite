<?php
// 1. Configurações Iniciais e Conexão
include "config.php"; // Verifique se o config.php define BASE_URL e a conexão $conn
require_once 'vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// 2. Proteção: Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// 3. Captura o ID do jogo e limpa o texto (Garante letras minúsculas e sem espaços)
$jogo_id = isset($_GET['id']) ? strtolower(trim($_GET['id'])) : '';

if (empty($jogo_id)) {
    die("Erro: Nenhum jogo foi selecionado.");
}

// 4. Busca os dados reais no Banco de Dados (Tabela: produtos / Coluna: slug)
$stmt = $conn->prepare("SELECT nome, preco FROM produtos WHERE slug = ?");
$stmt->bind_param("s", $jogo_id);
$stmt->execute();
$res = $stmt->get_result();
$jogo = $res->fetch_assoc();

// Se não encontrar o slug no banco, para a execução e avisa qual ID faltou
if (!$jogo) {
    die("Erro: O jogo com o identificador '$jogo_id' não foi encontrado no banco de dados.");
}

$nomeProduto = $jogo['nome'];
$valorProduto = (float)$jogo['preco'];

// 5. Gera o Pedido no Banco de Dados para controle interno
$numeroPedido = 'NP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
$usuarioId = $_SESSION['usuario_id'];
$emailUser = $_SESSION['usuario_email'] ?? 'email@naoinformado.com';

$sqlPedido = "INSERT INTO pedidos (numero_pedido, usuario_id, email, produto, valor, status) VALUES (?, ?, ?, ?, ?, 'aguardando_pagamento')";
$stmtPedido = $conn->prepare($sqlPedido);
$stmtPedido->bind_param("sissd", $numeroPedido, $usuarioId, $emailUser, $nomeProduto, $valorProduto);
$stmtPedido->execute();

// 6. Configuração do Mercado Pago (Checkout Pro)
// Substitua pelo seu Access Token de PRODUÇÃO se for colocar o site no ar
MercadoPagoConfig::setAccessToken("SAPP_USR-363557c5-5017-4a86-9dc9-74a2f615763f");

$client = new PreferenceClient();

try {
    $preference = $client->create([
        "items" => [
            [
                "title" => $nomeProduto . " - 25 Dígitos",
                "quantity" => 1,
                "unit_price" => $valorProduto
            ]
        ],
        "external_reference" => $numeroPedido,
        "back_urls" => [
            "success" => "http://localhost/sucesso.php", // Ajuste se não for localhost
            "failure" => "http://localhost/erro.php",
            "pending" => "http://localhost/pendente.php"
        ],
        "auto_return" => "approved",
    ]);

    // 7. Redireciona o usuário para a página de pagamento do Mercado Pago
    header("Location: " . $preference->init_point);
    exit;

} catch (Exception $e) {
    die("Erro ao gerar pagamento: " . $e->getMessage());
}