<?php
include "config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- LÓGICA DE PAGINAÇÃO ---
$itens_por_pagina = 20;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_atual < 1) $pagina_atual = 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

$total_jogos_query = $conn->query("SELECT COUNT(*) as total FROM produtos");
$total_jogos = $total_jogos_query->fetch_assoc()['total'];
$total_paginas = ceil($total_jogos / $itens_por_pagina);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Jogos - Nito Play</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos base do Carrinho (copiados da sua index) */
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
        .dropdown-menu a:hover { background: #8a2be2; }
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
                <span class="badge-carrinho" id="cart-count" style="position: absolute; top: -10px; right: -10px; background: #8a2be2; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">0</span>
            </div>

            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <a href="login.php" class="account-btn">Entrar</a>
            <?php else: ?>
                <div class="user-dropdown" style="position: relative;">
                    <button class="user-btn" onclick="toggleUserMenu()" style="background:none; border:none; color:white; font-size:20px; cursor:pointer;">👤</button>
                    <div id="dropdown-user" class="dropdown-menu" style="display: none; position: absolute; right: 0; background: #1a1a1a; padding: 10px; border-radius: 5px; z-index: 100; min-width: 180px; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                        <span style="color: #fff; display: block; margin-bottom: 5px; font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 5px;"><?= $_SESSION['usuario_nome']; ?></span>
                        <a href="conta.php" style="color: #fff; text-decoration: none; display: block; padding: 8px 0;">Minha Conta</a>
                        <a href="logout.php" style="color: #ff4d4d; text-decoration: none; display: block; padding: 8px 0;">Sair</a>
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

<main class="container" style="margin-top: 50px;">
    <section class="catalog-header">
        <h1 style="color: #fff; margin-bottom: 30px;">Explorar Todos os Jogos</h1>
    </section>

    <div class="catalog-grid" id="games-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
        <?php
        $res = $conn->query("SELECT * FROM produtos ORDER BY nome ASC LIMIT $itens_por_pagina OFFSET $offset");
        if ($res->num_rows > 0):
            while($jogo = $res->fetch_assoc()): 
                $imagem = !empty($jogo['imagem']) ? "img/" . $jogo['imagem'] : "img/placeholder.jpg"; ?>
                <div class="game-card">
                    <img src="<?= $imagem; ?>" alt="<?= $jogo['nome']; ?>" style="width: 100%; border-radius: 10px;">
                    <p class="game-title" style="color: #fff; margin: 10px 0; font-weight: 600;"><?= $jogo['nome']; ?> - 25 Dígitos</p>
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
</main>



<div class="pagination-container" style="text-align: center; margin: 40px 0;">
    <div class="pagination">
        <?php if($pagina_atual > 1): ?>
            <a href="todos-os-jogos.php?pagina=<?= $pagina_atual - 1 ?>" class="page-arrow" style="color:#8a2be2; padding:10px;">&laquo;</a>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="todos-os-jogos.php?pagina=<?= $i ?>" class="page-number <?= ($i == $pagina_atual) ? 'active' : '' ?>" style="color:#fff; padding:10px; text-decoration:none; <?= ($i == $pagina_atual) ? 'background:#8a2be2; border-radius:5px;' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if($pagina_atual < $total_paginas): ?>
            <a href="todos-os-jogos.php?pagina=<?= $pagina_atual + 1 ?>" class="page-arrow" style="color:#8a2be2; padding:10px;">&raquo;</a>
        <?php endif; ?>
    </div>
</div>

<footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Nito Play. Todos os direitos reservados.</p>
        </div>
    </footer>

<script src="js/carrinho.js"></script>
<script>
// Funções de controle (Copiadas da sua Index para garantir paridade)
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
        if(typeof atualizarExibicaoCarrinho === "function") atualizarExibicaoCarrinho();
    }
}

window.onclick = function(event) {
    if (!event.target.matches('.user-btn')) {
        const dropdown = document.getElementById('dropdown-user');
        if (dropdown && dropdown.style.display === 'block') dropdown.style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", function() {
    if(typeof atualizarContador === "function") atualizarContador();
});
</script>

<?php include "carrinho-template.php"; ?> 
</body>
</html>