<?php
include "config.php";
session_start();

// O Mercado Pago envia o status via URL
$status = $_GET['status'] ?? '';
$pedido_id = $_GET['external_reference'] ?? '';

// Atualiza o status no banco se o pagamento foi aprovado
if ($status === 'approved' && !empty($pedido_id)) {
    $stmt = $conn->prepare("UPDATE pedidos SET status = 'pago' WHERE numero_pedido = ?");
    $stmt->bind_param("s", $pedido_id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento Confirmado - Nito Play</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="text-align: center; padding-top: 100px; background-color: #121212; color: white; font-family: 'Poppins', sans-serif;">
    <div class="container">
        <h1 style="color: #00ff00;">✓ Pagamento Recebido!</h1>
        <p>Obrigado pela sua compra. O código do seu jogo será enviado para seu e-mail em breve.</p>
        <p>Pedido: <strong><?php echo htmlspecialchars($pedido_id); ?></strong></p>
        <br>
        <a href="index.php" class="btn-primary" style="text-decoration: none; padding: 10px 20px; background: #6a11cb; color: white; border-radius: 5px;">Voltar para a Loja</a>
    </div>
</body>
</html>