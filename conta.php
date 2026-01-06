<?php
include "config.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Minha Conta | Nito Play</title>
<style>
body {
    background: #4a008a;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 900px;
    margin: 60px auto;
    background: #ffffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

h2 {
    display: flex;
    align-items: center;
    gap: 10px;
}

.section {
    margin-top: 30px;
    padding: 20px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.section h3 {
    color: #ffffffff;
    margin-bottom: 15px;
}

.info p {
    margin: 8px 0;
    font-size: 15px;
}

.logout {
    margin-top: 30px;
    display: inline-block;
    padding: 10px 18px;
    background: #ef4444;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
}
</style>
</head>

<body>

<div class="container">
    <h2>👤 Minha Conta</h2>

    <div class="section">
        <h3>Dados da Conta</h3>

        <div class="info">
            <p><strong>Nome:</strong> <?= $_SESSION['usuario_nome']; ?></p>
            <p><strong>Email:</strong> <?= $_SESSION['usuario_email']; ?></p>
        </div>
    </div>

    <div class="section">
    <h3>Meu Histórico de Pedidos</h3>
    <?php
    // Busca os pedidos do usuário logado
    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY criado_em DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0): ?>
        <table style="width:100%; border-collapse: collapse;">
            <tr style="text-align:left; border-bottom: 2px solid #eee;">
                <th>Pedido</th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
            <?php while($pedido = $result->fetch_assoc()): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td>#<?= $pedido['numero_pedido']; ?></td>
                <td><?= $pedido['produto']; ?></td>
                <td>R$ <?= number_format($pedido['valor'], 2, ',', '.'); ?></td>
                <td>
                    <span style="padding:4px 8px; border-radius:4px; font-size:12px; background: <?= $pedido['status'] == 'pago' ? '#dcfce7' : '#fef9c3'; ?>">
                        <?= ucfirst($pedido['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Você ainda não realizou pedidos.</p>
    <?php endif; ?>
</div>

   <a href="logout.php" class="logout">Sair</a>
</div>

</body>
</html>
