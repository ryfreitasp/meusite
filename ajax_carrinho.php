<?php
include "config.php";

$usuario_id = $_SESSION['usuario_id'] ?? 0;
$acao = $_REQUEST['acao'] ?? '';

if (!$usuario_id) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Faça login primeiro']);
    exit;
}

if ($acao == 'adicionar') {
    $produto_id = (int)$_POST['produto_id'];
    
    // Verifica se já existe no carrinho para apenas aumentar a quantidade ou só inserir
    $stmt = $conn->prepare("INSERT INTO carrinho (usuario_id, produto_id, quantidade) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE quantidade = quantidade + 1");
    $stmt->bind_param("ii", $usuario_id, $produto_id);
    
    if ($stmt->execute()) {
        echo json_encode(['sucesso' => true]);
    }
    exit;
}

if ($acao == 'listar') {
    // Busca os jogos que estão no carrinho do usuário
    $sql = "SELECT p.nome, p.preco, p.imagem, c.quantidade FROM carrinho c 
            JOIN produtos p ON c.produto_id = p.id 
            WHERE c.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();v
    $res = $stmt->get_result();

    if ($res->num_rows == 0) {
        echo "<p style='color:#888; text-align:center;'>Carrinho vazio</p>";
    } else {
        while ($item = $res->fetch_assoc()) {
            echo "
            <div class='item-carrinho' style='display:flex; align-items:center; gap:10px; margin-bottom:10px; color:#fff;'>
                <img src='img/{$item['imagem']}' style='width:50px;'>
                <div>
                    <div style='font-size:14px;'>{$item['nome']}</div>
                    <div style='color:#8a2be2;'>R$ " . number_format($item['preco'], 2, ',', '.') . "</div>
                </div>
            </div>";
        }
    }
    exit;
}