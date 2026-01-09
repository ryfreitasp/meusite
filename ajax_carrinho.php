<?php
include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_id = $_SESSION['usuario_id'] ?? 0;
$acao = $_REQUEST['acao'] ?? '';

if (!$usuario_id) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Faça login primeiro']);
    exit;
}

// AÇÃO: ADICIONAR
if ($acao == 'adicionar') {
    $produto_id = (int)$_POST['produto_id'];
    $stmt = $conn->prepare("INSERT INTO carrinho (usuario_id, produto_id, quantidade) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE quantidade = quantidade + 1");
    $stmt->bind_param("ii", $usuario_id, $produto_id);
    if ($stmt->execute()) {
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => $conn->error]);
    }
    exit;
}

// AÇÃO: REMOVER (O que você pediu para o X)
if ($acao == 'remover') {
    $produto_id = (int)$_POST['produto_id'];
    $stmt = $conn->prepare("DELETE FROM carrinho WHERE usuario_id = ? AND produto_id = ?");
    $stmt->bind_param("ii", $usuario_id, $produto_id);
    if ($stmt->execute()) {
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false]);
    }
    exit;
}

// AÇÃO: LISTAR
if ($acao == 'listar') {
    // IMPORTANTE: Buscamos o p.id (ID real do produto) para o botão X funcionar
    $sql = "SELECT p.id, p.nome, p.preco, p.imagem, c.quantidade 
            FROM carrinho c 
            JOIN produtos p ON c.produto_id = p.id 
            WHERE c.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 0) {
        echo "<p style='color:#888; text-align:center; padding:20px;'>Carrinho vazio</p>";
    } else {
        while ($item = $res->fetch_assoc()) {
            echo "
            <div class='item-carrinho' style='display:flex; align-items:center; gap:10px; margin-bottom:15px; background:#1a1a1a; padding:10px; border-radius:5px; position:relative;'>
                <img src='img/{$item['imagem']}' style='width:50px; height:60px; object-fit:cover; border-radius:4px;'>
                <div style='flex-grow:1;'>
                    <div style='font-size:14px; color:#fff; font-weight:bold;'>{$item['nome']}</div>
                    <div style='color:#8a2be2; font-size:13px;'>R$ " . number_format($item['preco'], 2, ',', '.') . " <span style='color:#666;'>x{$item['quantidade']}</span></div>
                </div>
                <button onclick='removerDoCarrinho({$item['id']})' style='background:none; border:none; color:#ff4d4d; cursor:pointer; font-size:18px; font-weight:bold;'>&times;</button>
            </div>";
        }
    }
    exit;
}

// AÇÃO: CONTAR
if ($acao == 'contar') {
    $sql = "SELECT SUM(quantidade) as total FROM carrinho WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    echo json_encode(['total' => $res['total'] ?? 0]);
    exit;
}
?>