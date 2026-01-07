<?php
include "config.php"; 
require_once 'vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$jogo_id = isset($_GET['id']) ? strtolower(trim($_GET['id'])) : '';
if (empty($jogo_id)) { die("Erro: Nenhum jogo selecionado."); }

$stmt = $conn->prepare("SELECT nome, preco FROM produto WHERE slug = ?");
$stmt->bind_param("s", $jogo_id);
$stmt->execute();
$jogo = $stmt->get_result()->fetch_assoc();

if (!$jogo) { die("Erro: Jogo não encontrado."); }

$nomeProduto = (string)$jogo['nome'];
$valorProduto = (float)$jogo['preco'];

// 1. REGISTRO DO PEDIDO NO BANCO
$numeroPedido = 'NP-' . time();
$usuarioId = $_SESSION['usuario_id'];
$emailUser = $_SESSION['usuario_email'] ?? 'comprador_teste@email.com';

$sqlPedido = "INSERT INTO pedidos (numero_pedido, usuario_id, email, produto, valor, status) VALUES (?, ?, ?, ?, ?, 'aguardando_pagamento')";
$stmtPedido = $conn->prepare($sqlPedido);
$stmtPedido->bind_param("sissd", $numeroPedido, $usuarioId, $emailUser, $nomeProduto, $valorProduto);
$stmtPedido->execute();

// 2. CONFIGURAÇÃO MERCADO PAGO
// Usei exatamente o token que você revelou na imagem image_e0469d.png
MercadoPagoConfig::setAccessToken("APP_USR-4798540745051882-010421-4f17c214a66be3478531e2b787c2e496-3110331799");

$client = new PreferenceClient();

try {
    // Criamos a preferência de forma direta
    $preference = $client->create([
        "items" => [
            [
                "title" => $nomeProduto,
                "quantity" => 1,
                "unit_price" => $valorProduto,
                "currency_id" => "BRL"
            ]
        ],
        "external_reference" => (string)$numeroPedido,
        "back_urls" => [
            "success" => "http://localhost/meusite/sucesso.php",
            "failure" => "http://localhost/meusite/erro.php",
            "pending" => "http://localhost/meusite/pendente.php"
        ],
        "auto_return" => "approved"
    ]);

    // REDIRECIONAMENTO COM JAVASCRIPT (Mais estável para localhost)
    if ($preference->init_point) {
        echo "<script>window.location.href='" . $preference->init_point . "';</script>";
        exit;
    }

} catch (Exception $e) {
    echo "<h3>Ocorreu um problema na comunicação:</h3>";
    echo "O Mercado Pago recusou a conexão vinda do seu computador local.<br>";
    echo "Motivo técnico: " . $e->getMessage();
}