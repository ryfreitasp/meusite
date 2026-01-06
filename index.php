<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nito Play - Jogos Digitais Xbox</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/carrinho.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="main-header">
    <div class="container header-content"> <div class="logo">
            <a href="index.php"> 
                <img src="Fotos/Logo NIto Play.png" alt="Logo Nito Play - Home" class="logo-img"> 
            </a>
        </div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="todos-os-jogos.php">Xbox One</a></li>
                <li><a href="todos-os-jogos.php">Xbox Series X|S</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </nav>

        <div class="user-area">
<?php if (!isset($_SESSION['usuario_id'])): ?>

    <a href="login.php" class="account-btn">Entrar</a>

<?php else: ?>

    <div class="user-dropdown">
        <button class="user-btn">👤</button>

        <div class="dropdown-menu">
            <span class="user-name"><?= $_SESSION['usuario_nome']; ?></span>
            <a href="conta.php">Minha Conta</a>
            <a href="logout.php" class="logout">Sair</a>
        </div>
    </div>

<?php endif; ?>
</div>
<script>
document.addEventListener("click", function (e) {
    const dropdown = document.querySelector(".dropdown-menu");
    const button = document.querySelector(".user-btn");

    if (button && button.contains(e.target)) {
        dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
    } else if (dropdown) {
        dropdown.style.display = "none";
    }
});
</script>

</div>
    </div>
<div id="carrinho-overlay" onclick="toggleCarrinho()"></div>

<aside id="carrinho-lateral" class="carrinho-sidebar">
    <div class="carrinho-header">
        <h2 style="color: #fff; margin: 0;"><i class="fas fa-shopping-cart"></i> Meu Carrinho</h2>
        <button onclick="toggleCarrinho()" class="btn-fechar-carrinho">&times;</button>
    </div>

    <div id="itens-do-carrinho" class="carrinho-itens">
        <p style="color: #888; text-align: center;">O seu carrinho está vazio.</p>
    </div>

    <div class="carrinho-footer">
        <div class="carrinho-total">
            <span>Total:</span>
            <span id="valor-total-carrinho">R$ 0,00</span>
        </div>
        <button onclick="irParaCheckout()" class="btn-finalizar">FINALIZAR COMPRA</button>
    </div>
</aside>
</header>

    <section class="hero-section">
        <div class="container hero-content">
            <h2>O Melhor do Xbox Digital</h2>
            <p>Seu pedido entregue automaticamente e com segurança em minutos!</p>
            <a href="todos-os-jogos.php" class="btn-primary">Ver Lançamentos</a>
        </div>
    </section>

    <section class="benefits-section">
        <div class="container benefits-grid">
            <div class="benefit-item">
                <span class="icon">🚀</span>
                <p><strong>Entrega Automática</strong></p> 
                <p>Receba seu código em instantes após a confirmação.</p>
            </div>
            <div class="benefit-item">
                <span class="icon">💳</span>
                <p><strong>Parcele em até 12x</strong></p>
                <p>No cartão de crédito, com as menores taxas.</p>
            </div>
            <div class="benefit-item">
                <span class="icon">🔒</span>
                <p><strong>Compra 100% Segura</strong></p>
                <p>Transações protegidas por SSL e criptografia.</p>
            </div>
        </div>
    </section>

    <section class="games-section">
    <div class="container">
        <div class="section-header">
            <h3>🎮 Lançamentos</h3>
            <a href="todos-os-jogos.php" class="btn-view-more">Ver mais</a>
        </div>

        <div class="carousel-container">
            <div class="game-list-carousel">
    
    <div class="game-card">
        <img src="Fotos/Jogos/fc 26.jpg" alt="Capa FC 26">
        <p class="game-title">FC 26 Xbox One/Series</p>
        <p class="game-price">R$ 199,90</p>
        <a href="jogo.html?id=fc-26" class="btn-secondary">Comprar</a>
    </div>

    <div class="game-card">
        <img src="Fotos/Jogos/forza horizon 5.jpg" alt="Capa Forza 5">
        <p class="game-title">Forza Horizon 5 - 25 Dígitos</p>
        <p class="game-price">R$ 159,90</p>
        <a href="jogo.html?id=forza-horizon-5" class="btn-secondary">Comprar</a>
    </div>

    <div class="game-card">
        <img src="Fotos/Jogos/battlefield 6.jpg" alt="Capa Battlefield 6">
        <p class="game-title">Battlefield 6 - 25 Dígitos</p>
        <p class="game-price">R$ 99,90</p>
        <a href="jogo.html?id=battlefield-6" class="btn-secondary">Comprar</a>
    </div>

    <div class="game-card">
        <img src="Fotos/Jogos/call of duty black ops 7.jpg" alt="Capa COD">
        <p class="game-title">COD Black Ops 7 - 25 Dígitos</p>
        <p class="game-price">R$ 79,90</p>
        <a href="jogo.html?id=call-of-duty-black-ops-7" class="btn-secondary">Comprar</a>
    </div>

    <div class="game-card">
        <img src="Fotos/Jogos/cyberpunck-2077.jpg" alt="Jogo 5">
        <p class="game-title">NOME DO JOGO 5</p>
        <p class="game-price">R$ 00,00</p>
        <a href="jogo.html?id=cyberpunk-2077" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/mortal-1.jpg" alt="Jogo 6">
        <p class="game-title">NOME DO JOGO 6</p>
        <p class="game-price">R$ 00,00</p>
        <a href="jogo.html?id=mortal-kombat-11" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/resident evil 4 remake.jpg" alt="Jogo 7">
        <p class="game-title">NOME DO JOGO 7</p>
        <p class="game-price">R$ 00,00</p>
        <a href="jogo.html?id=resident-evil-4-remake" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/starfield.jpg" alt="Jogo 8">
        <p class="game-title">NOME DO JOGO 8</p>
        <p class="game-price">R$ 00,00</p>
        <a href="jogo.html?id=starfield" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/assassins-valhalla.jpg" alt="Jogo 9">
        <p class="game-title">NOME DO JOGO 9</p>
        <p class="game-price">R$ 00,00</p>
        <a href="jogo.html?id=assassins-valhalla" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/elden-ring.jpg" alt="Jogo 10">
        <p class="game-title">NOME DO JOGO 10</p>
        <p class="game-price">R$ 00,00</p>
        <a href="jogo.html?id=elden-ring" class="btn-secondary">Comprar</a>
    </div>

    <div class="game-card">
        <img src="Fotos/Jogos/fc 26.jpg" alt="Capa FC 26">
        <p class="game-title">FC 26 Xbox One/Series</p>
        <p class="game-price">R$ 199,90</p>
        <a href="jogo.html?id=fc-26" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/forza horizon 5.jpg" alt="Capa Forza 5">
        <p class="game-title">Forza Horizon 5 - 25 Dígitos</p>
        <p class="game-price">R$ 159,90</p>
        <a href="jogo.html?id=forza-horizon-5" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/battlefield 6.jpg 6.jpg" alt="Capa Battlefield 6">
        <p class="game-title">Battlefield 6 - 25 Dígitos</p>
        <p class="game-price">R$ 99,90</p>
        <a href="jogo.html?id=battlefield-6" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card">
        <img src="Fotos/Jogos/call of duty black ops 7.jpg Of Duty Black Ops 7.jpg" alt="Capa COD">
        <p class="game-title">COD Black Ops 7 - 25 Dígitos</p>
        <p class="game-price">R$ 79,90</p>
        <a href="jogo.html?id=call-of-duty-black-ops-7" class="btn-secondary">Comprar</a>
    </div>
    <div class="game-card"> <img src="Fotos/Jogos/CAPA_PADRAO.jpg" alt="Jogo 5"> <p class="game-title">NOME DO JOGO 5</p> <p class="game-price">R$ 00,00</p> <a href="#" class="btn-secondary">Comprar</a> </div>
    <div class="game-card"> <img src="Fotos/Jogos/CAPA_PADRAO.jpg" alt="Jogo 6"> <p class="game-title">NOME DO JOGO 6</p> <p class="game-price">R$ 00,00</p> <a href="#" class="btn-secondary">Comprar</a> </div>
    <div class="game-card"> <img src="Fotos/Jogos/CAPA_PADRAO.jpg" alt="Jogo 7"> <p class="game-title">NOME DO JOGO 7</p> <p class="game-price">R$ 00,00</p> <a href="#" class="btn-secondary">Comprar</a> </div>
    <div class="game-card"> <img src="Fotos/Jogos/CAPA_PADRAO.jpg" alt="Jogo 8"> <p class="game-title">NOME DO JOGO 8</p> <p class="game-price">R$ 00,00</p> <a href="#" class="btn-secondary">Comprar</a> </div>
    <div class="game-card"> <img src="Fotos/Jogos/CAPA_PADRAO.jpg" alt="Jogo 9"> <p class="game-title">NOME DO JOGO 9</p> <p class="game-price">R$ 00,00</p> <a href="#" class="btn-secondary">Comprar</a> </div>
    <div class="game-card"> <img src="Fotos/Jogos/CAPA_PADRAO.jpg" alt="Jogo 10"> <p class="game-title">NOME DO JOGO 10</p> <p class="game-price">R$ 00,00</p> <a href="#" class="btn-secondary">Comprar</a> </div>

</div>
    </div>
</section>

    <section class="games-section best-sellers-section">
        <div class="container">
            <h3>⭐ Mais Vendidos</h3>
            <div class="game-list">
                <div class="game-card">
                    <img src="Fotos/Jogos/gta-v.jpg" alt="Capa do Jogo 5">
                    <p class="game-title">GTA v Xbox One/Series - 25 Dígitos</p>
                    <p class="game-price">R$ 49,90</p>
                    <a href="jogo.html?id=gta-v" class="btn-secondary">Comprar</a>
                </div>
                 <div class="game-card">
                    <img src="Fotos/Jogos/hogwarts legacy.jpg" alt="Capa do Jogo 6">
                    <p class="game-title">Hogwarts Legacy Xbox One/Series - 25 Dígitos</p>
                    <p class="game-price">R$ 39,90</p>
                    <a href="jogo.html?id=hogwarts-legacy" class="btn-secondary">Comprar</a>
                </div>
                 <div class="game-card">
                    <img src="Fotos/Jogos/resident evil 4 remake.jpg" alt="Capa do Jogo 7">
                    <p class="game-title">Resident Evil 4 Remake Xbox One/Series - 25 Dígitos</p>
                    <p class="game-price">R$ 29,90</p>
                    <a href="jogo.html?id=resident-evil-4-remake" class="btn-secondary">Comprar</a>
                </div>
                 <div class="game-card">
                    <img src="Fotos/Jogos/red dead 2.jpg" alt="Capa do Jogo 8">
                    <p class="game-title">Red Dead 2 Xbox One/Series - 25 Dígitos</p>
                    <p class="game-price">R$ 19,90</p>
                    <a href="jogo.html?id=red-dead-2" class="btn-secondary">Comprar</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Nito Play. Todos os direitos reservados.</p>
        </div>
    </footer>
    
</body>
</html>