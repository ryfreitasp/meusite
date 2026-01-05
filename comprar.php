<?php
require_once 'vendor/autoload.php'; // Carrega o Mercado Pago

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// 1. Configure seu Access Token (pegue no painel do desenvolvedor do MP)
MercadoPagoConfig::setAccessToken("SAPP_USR-363557c5-5017-4a86-9dc9-74a2f615763f");

$client = new PreferenceClient();

// 2. Crie a preferência (o "carrinho" que o MP vai processar)
$preference = $client->create([
  "items" => [
    [
      "title" => "Halo Infinite - 25 Dígitos",
      "quantity" => 1,
      "unit_price" => 99.90 // O valor deve ser float
    ]
  ],
  "external_reference" => $numeroPedido, // Aquele número 'NP-...' que você criou
  "back_urls" => [
    "success" => "http://localhost/meusite/sucesso.php",
    "failure" => "http://localhost/meusite/erro.php",
    "pending" => "http://localhost/meusite/pendente.php"
  ],
  "auto_return" => "approved",
]);

// 3. Redireciona para o Mercado Pago
header("Location: " . $preference->init_point);
exit;