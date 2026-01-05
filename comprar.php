<?php
include "config.php"; // Inclui sua conexão e sessão
require_once 'vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// 1. Pega o ID do jogo vindo da URL (ex: comprar.php?id=minecraft)
$jogo_id = $_GET['id'] ?? '';

// 2. Busca o preço e nome REAL no banco de dados para evitar fraudes
// Nota: Você precisará cadastrar esses jogos na tabela 'produtos' que criamos
$stmt = $conn->prepare("SELECT nome, preco FROM produtos WHERE slug = ?");
$stmt->bind_param("s", $jogo_id);
$stmt->execute();
$res = $stmt->get_result();
$jogo = $res->fetch_assoc();

if (!$jogo) {
    die("Jogo não encontrado no sistema.");
}

$nomeProduto = $jogo['nome'];
$valorProduto = (float)$jogo['preco'];

// 3. Gera o número do pedido e salva na tabela 'pedidos'
$numeroPedido = 'NP-' . date('Ymd') . '-' . rand(1000, 9999);
$usuarioId = $_SESSION['usuario_id'];
$emailUser = $_SESSION['usuario_email'] ?? 'email@naoinformado.com';

$sqlPedido = "INSERT INTO pedidos (numero_pedido, usuario_id, email, produto, valor, status) VALUES (?, ?, ?, ?, ?, 'aguardando_pagamento')";
$stmtPedido = $conn->prepare($sqlPedido);
$stmtPedido->bind_param("sissd", $numeroPedido, $usuarioId, $emailUser, $nomeProduto, $valorProduto);
$stmtPedido->execute();

// 4. Configura o Mercado Pago
MercadoPagoConfig::setAccessToken("SAPP_USR-363557c5-5017-4a86-9dc9-74a2f615763f");
$client = new PreferenceClient();

$preference = $client->create([
  "items" => [
    [
      "title" => $nomeProduto,
      "quantity" => 1,
      "unit_price" => $valorProduto
    ]
  ],
  "external_reference" => $numeroPedido,
  "back_urls" => [
    "success" => BASE_URL . "sucesso.php",
    "failure" => BASE_URL . "erro.php",
    "pending" => BASE_URL . "pendente.php"
  ],
  "auto_return" => "approved",
]);

// 5. Redireciona para o checkout
header("Location: " . $preference->init_point);
exit;