<?php
include "config.php"; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Pega o slug da URL
$slug = $_GET['id'] ?? '';

// 2. Busca o jogo no banco (já usando o nome da coluna 'imagem' que você arrumou no SQL)
$stmt = $conn->prepare("SELECT * FROM produtos WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$jogo = $stmt->get_result()->fetch_assoc();

if (!$jogo) {
    die("<h1 style='color:white; text-align:center;'>Jogo não encontrado! <a href='index.php'>Voltar</a></h1>");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $jogo['nome']; ?> - Nito Play</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background:#000; color:white;">

    <header class="main-header">
        <div class="container header-content" style="display:flex; justify-content:space-between; align-items:center; padding:20px;">
            <a href="index.php"><img src="Fotos/Logo NIto Play.png" width="150"></a>
            <div class="cart-icon" onclick="toggleCarrinho()" style="cursor:pointer; position:relative;">
                <i class="fas fa-shopping-cart" style="color:#8a2be2; font-size:24px;"></i>
                <span class="badge-carrinho" style="position:absolute; top:-10px; right:-10px; background:#8a2be2; border-radius:50%; padding:2px 6px; font-size:12px;">0</span>
            </div>
        </div>
    </header>

    <main class="container">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:40px; margin-top:50px;">
            <section>
                <?php if(!empty($jogo['trailer'])): ?>
                    <iframe width="100%" height="315" src="<?= $jogo['trailer']; ?>" frameborder="0" allowfullscreen style="border-radius:15px; margin-bottom:20px;"></iframe>
                <?php endif; ?>
                <img src="<?= $jogo['imagem']; ?>" style="width:100%; border-radius:15px;">
            </section>

            <aside>
                <h1><?= $jogo['nome']; ?></h1>
                <p style="font-size:30px; color:#8a2be2; font-weight:bold;">R$ <?= number_format($jogo['preco'], 2, ',', '.'); ?></p>
                
                <button onclick="adicionarAoCarrinho(<?= $jogo['id']; ?>)" class="btn-comprar" style="background:#8a2be2; color:white; border:none; padding:20px; border-radius:10px; cursor:pointer; width:100%; font-size:18px; font-weight:bold;">
                    ADICIONAR AO CARRINHO
                </button>
            </aside>
        </div>
    </main>

    <div id="carrinho-overlay" onclick="toggleCarrinho()"></div>
    <aside id="carrinho-lateral" class="carrinho-sidebar">
        <div style="padding:20px; border-bottom:1px solid #333; display:flex; justify-content:space-between;">
            <h3>Meu Carrinho</h3>
            <button onclick="toggleCarrinho()" style="background:none; border:none; color:white; font-size:25px; cursor:pointer;">&times;</button>
        </div>
        <div id="itens-do-carrinho" style="padding:20px; flex-grow:1; overflow-y:auto;"></div>
        <div style="padding:20px; border-top:1px solid #333;">
            <button onclick="location.href='checkout.php'" style="width:100%; background:#8a2be2; color:white; border:none; padding:15px; border-radius:5px; cursor:pointer;">FINALIZAR COMPRA</button>
        </div>
    </aside>

    <script src="js/carrinho.js"></script>
</body>
</html>