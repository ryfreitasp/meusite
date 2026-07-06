<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nito Play - Jogos Digitais Xbox</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #111; }
        .carrinho-sidebar { position: fixed; top: 0; right: -400px; width: 350px; height: 100%; background: #111; transition: 0.3s; z-index: 1000; box-shadow: -5px 0 15px rgba(0,0,0,0.5); display: flex; flex-direction: column; }
        .carrinho-sidebar.active { right: 0; }
        #carrinho-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 999; }
        
        .section-games { max-width: 1200px; margin: 40px auto; padding: 20px; }
        
        /* Cards Padronizados */
        .swiper-slide.game-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 450px;
            background: #8a2be2; 
            padding: 15px; 
            border-radius: 15px; 
            text-align: center;
        }
        .swiper-slide img {
            width: 100%;
            height: 250px; 
            object-fit: cover; 
            border-radius: 10px;
        }
        .game-title {
            color: #fff;
            font-weight: bold;
            margin: 10px 0;
            height: 40px; 
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="container header-content">
        <div class="logo"><a href="index.php"><img src="img/Logo NIto Play.png" alt="Logo Nito Play" class="logo-img"></a></div>
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
                        <span style="color: #fff; display: block; margin-bottom: 5px; font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 5px;"><?= htmlspecialchars($_SESSION['usuario_nome'] ?? ''); ?></span>
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
    <div id="itens-do-carrinho" style="padding:20px; flex-grow:1; overflow-y:auto;"></div>
    <div style="padding:20px; border-top:1px solid #333;">
        <button onclick="window.location.href='checkout.php'" style="width:100%; background:#8a2be2; color:#fff; border:none; padding:15px; border-radius:5px; cursor:pointer; font-weight:bold;">FINALIZAR COMPRA</button>
    </div>
</aside>

<section class="hero-section" style="position: relative; width: 100%; height: 500px; background-image: url('img/fundo.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; display: flex; align-items: center; justify-content: center; color: #fff;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 1;"></div>
    <div class="container hero-content" style="position: relative; z-index: 2; text-align: center;">
        <h2>O Melhor do Xbox Digital</h2>
        <p>Seu pedido entregue automaticamente e com segurança em minutos!</p>
        <a href="todos-os-jogos.php" style="display:inline-block; padding: 15px 30px; background:#8a2be2; color:#fff; text-decoration:none; border-radius:5px; margin-top:20px;">Ver Lançamentos</a>
    </div>
</section>

<section class="section-games">
    <h3 style="color: #fff; margin-bottom: 20px;">🎮 Lançamentos</h3>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            $query = "SELECT id, slug, nome, preco, imagem FROM produtos ORDER BY id DESC LIMIT 8";
            $resultado = $conn->query($query);
            while ($jogo = $resultado->fetch_assoc()):
            ?>
                <div class="swiper-slide game-card">
                    <img src="img/<?= htmlspecialchars($jogo['imagem']); ?>" alt="<?= htmlspecialchars($jogo['nome']); ?>">
                    <p class="game-title"><?= htmlspecialchars($jogo['nome']); ?></p>
                    <p style="color: #fff; font-weight: bold;">R$ <?= number_format($jogo['preco'], 2, ',', '.'); ?></p>
                    <a href="produtos.php?id=<?= $jogo['slug']; ?>" style="display:block; background:#000; color:#fff; padding:10px; border-radius:5px; text-decoration:none;">Ver Jogo</a>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="swiper-button-next" style="color: #fff;"></div>
        <div class="swiper-button-prev" style="color: #fff;"></div>
    </div>
</section>

<footer class="main-footer">
    <div class="container"><p>&copy; 2025 Nito Play. Todos os direitos reservados.</p></div>
</footer>

<a href="https://wa.me/5511973554567" target="_blank" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; background-color: #25d366; color: white; padding: 15px 20px; border-radius: 50px; font-size: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); text-decoration: none; display: flex; align-items: center; justify-content: center;">
    <i class="fab fa-whatsapp"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="js/carrinho.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        breakpoints: { 300: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 4 } }
    });
    function toggleUserMenu() { const menu = document.getElementById('dropdown-user'); menu.style.display = (menu.style.display === 'block') ? 'none' : 'block'; }
    function toggleCarrinho() { const sidebar = document.getElementById('carrinho-lateral'); const overlay = document.getElementById('carrinho-overlay'); sidebar.classList.toggle('active'); overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none'; }
    window.onclick = function(event) { if (!event.target.matches('.user-btn')) { const dropdown = document.getElementById('dropdown-user'); if (dropdown && dropdown.style.display === 'block') { dropdown.style.display = 'none'; } } }
</script>
</body>
</html>