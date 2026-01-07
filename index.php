<?php
include "config.php"; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nito Play - Jogos Digitais Xbox</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .carrinho-sidebar {
            position: fixed; top: 0; right: -400px; width: 350px; height: 100%;
            background: #111; transition: 0.3s; z-index: 1000;
            box-shadow: -5px 0 15px rgba(0,0,0,0.5); display: flex; flex-direction: column;
        }
        .carrinho-sidebar.active { right: 0; }
        #carrinho-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); z-index: 999;
        }
        .btn-detalhes {
            color: #fff; text-decoration: none; border: 1px solid #333; 
            padding: 8px 15px; border-radius: 5px; flex: 1; text-align: center; font-size: 14px;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="container header-content">
        <div class="logo">
            <a href="index.php"><img src="Fotos/Logo NIto Play.png" alt="Logo Nito Play" class="logo-img"></a>
        </div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="todos-os-jogos.php">Xbox One</a></li>
                <li><a href="todos-os-jogos.php">Xbox Series X|S</a></li>
            </ul>
        </nav>

        <div class="user-area" style="display: flex; align-items: center; gap: 20px;">
            <div class="cart-icon" onclick="toggleCarrinho()" style="cursor:pointer; position: relative;">
                <i class="fas fa-shopping-cart" style="color: #8a2be2; font-size: 24px;"></i>
                <span class="badge-carrinho" style="position: absolute; top: -10px; right: -10px; background: #8a2be2; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">0</span>
            </div>

            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <a href="login.php" class="account-btn">Entrar</a>
            <?php else: ?>
                <div class="user-dropdown" style="position: relative;">
                    <button class="user-btn" onclick="toggleUserMenu()">👤</button>
                    <div id="dropdown-user" class="dropdown-menu" style="display: none; position: absolute; right: 0; background: #1a1a1a; padding: 10px; border-radius: 5px; z-index: 100; min-width: 150px;">
                        <span style="color: #fff; display: block; margin-bottom: 5px;"><?= $_SESSION['usuario_nome']; ?></span>
                        <a href="conta.php" style="color: #fff; text-decoration: none; display: block; padding: 5px 0;">Minha Conta</a>
                        <hr style="border: 0.5px solid #333;">
                        <a href="logout.php" style="color: #ff4d4d; text-decoration: none; display: block; padding: 5px 0;">Sair</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<div id="carrinho-overlay" onclick="toggleCarrinho()"></div>
<aside id="carrinho-lateral" class="carrinho-sidebar">
    <div style="padding:20px; border-bottom:1px solid #333; display:flex; justify-content:space-between; align-items:center;">
        <h3 style="color:#fff; margin:0;">Meu Carrinho</h3>
        <button onclick="toggleCarrinho()" style="background:none; border:none; color:#8a2be2; font-size:20px; cursor:pointer;">Fechar</button>
    </div>
    <div id="itens-do-carrinho" style="padding:20px; flex-grow:1; overflow-y:auto;">
        </div>
    <div style="padding:20px; border-top:1px solid #333;">
        <button onclick="window.location.href='checkout.php'" style="width:100%; background:#8a2be2; color:#fff; border:none; padding:15px; border-radius:5px; cursor:pointer; font-weight:bold;">FINALIZAR COMPRA</button>
    </div>
</aside>

<section class="hero-section">
    <div class="container hero-content">
        <h2>O Melhor do Xbox Digital</h2>
        <p>Seu pedido entregue automaticamente e com segurança em minutos!</p>
        <a href="todos-os-jogos.php" class="btn-primary">Ver Lançamentos</a>
    </div>
</section>

<section class="games-section">
    <div class="container">
        <h3 style="color: #fff; margin-bottom: 20px;">🎮 Lançamentos</h3>
        <div class="game-list" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <?php
            $query = "SELECT id, slug, nome, preco, imagem FROM produtos ORDER BY id DESC LIMIT 8";
            $resultado = $conn->query($query);

            if ($resultado && $resultado->num_rows > 0):
                while($jogo = $resultado->fetch_assoc()): ?>
                <div class="game-card">
                    <img src="img/<?= $jogo['imagem']; ?>" alt="<?= $jogo['nome']; ?>" style="width: 100%; border-radius: 10px;">
                    <p class="game-title" style="color: #fff; margin: 10px 0; font-weight: 600;"><?= $jogo['nome']; ?></p>
                    <p class="game-price" style="color: #8a2be2; font-weight: bold;">R$ <?= number_format($jogo['preco'], 2, ',', '.'); ?></p>
                    <div class="card-buttons" style="display: flex; gap: 10px; margin-top: 10px;">
                        <button onclick="adicionarAoCarrinho(<?= $jogo['id']; ?>)" class="btn-comprar" style="background: #8a2be2; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; flex: 1;">Comprar</button>
                        <a href="produtos.php?id=<?= $jogo['slug']; ?>" class="btn-detalhes">Detalhes</a>
                    </div>
                </div>
            <?php endwhile; 
            else: ?>
                <p style="color: #fff;">Nenhum jogo encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<footer class="main-footer" style="padding: 40px 0; border-top: 1px solid #333; margin-top: 50px; text-align: center;">
    <p style="color: #888;">&copy; 2025 Nito Play. Todos os direitos reservados.</p>
</footer>

<script src="js/carrinho.js"></script>
<script>
function toggleUserMenu() {
    const menu = document.getElementById('dropdown-user');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

function toggleCarrinho() {
    const sidebar = document.getElementById('carrinho-lateral');
    const overlay = document.getElementById('carrinho-overlay');
    sidebar.classList.toggle('active');
    overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
    
    if(sidebar.classList.contains('active')) {
        atualizarExibicaoCarrinho();
    }
}

// Fecha menus ao clicar fora
window.onclick = function(event) {
    if (!event.target.matches('.user-btn')) {
        const dropdown = document.getElementById('dropdown-user');
        if (dropdown && dropdown.style.display === 'block') dropdown.style.display = 'none';
    }
}
</script>
</body>
</html>