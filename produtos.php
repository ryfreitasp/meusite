<?php
include "config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pegamos o identificador do jogo pela URL (slug)
$slug = isset($_GET['id']) ? $_GET['id'] : '';

// Buscamos os dados do jogo no banco
$stmt = $conn->prepare("SELECT * FROM produtos WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$resultado = $stmt->get_result();
$jogo = $resultado->fetch_assoc();

// Se o jogo não existir, redireciona para a home
if (!$jogo) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $jogo['nome']; ?> - Nito Play</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos específicos para a página de produto */
        .jogo-layout { display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; margin-top: 40px; }
        .jogo-media iframe { width: 100%; aspect-ratio: 16/9; border-radius: 10px; background: #000; }
        .galeria { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 15px; }
        .game-thumbnail { width: 100%; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .game-thumbnail:hover { opacity: 0.7; }
        .jogo-info h1 { color: #fff; font-size: 2.5rem; margin-bottom: 10px; }
        .preco-grande { color: #8a2be2; font-size: 2rem; font-weight: bold; margin-bottom: 20px; }
        .btn-comprar-lg { background: #8a2be2; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-weight: bold; width: 100%; cursor: pointer; font-size: 1.2rem; }
        .info-box { background: #1a1a1a; padding: 20px; border-radius: 10px; margin-top: 20px; border: 1px solid #333; }
        
        /* Sidebar Carrinho (igual index) */
        .carrinho-sidebar { position: fixed; top: 0; right: -400px; width: 350px; height: 100%; background: #111; transition: 0.3s; z-index: 1000; box-shadow: -5px 0 15px rgba(0,0,0,0.5); display: flex; flex-direction: column; }
        .carrinho-sidebar.active { right: 0; }
        #carrinho-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 999; }
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
                <span class="badge-carrinho" id="cart-count">0</span>
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
    <div id="itens-do-carrinho" style="padding:20px; flex-grow:1; overflow-y:auto;"></div>
    <div style="padding:20px; border-top:1px solid #333;">
        <button onclick="window.location.href='checkout.php'" style="width:100%; background:#8a2be2; color:#fff; border:none; padding:15px; border-radius:5px; cursor:pointer; font-weight:bold;">FINALIZAR COMPRA</button>
    </div>
</aside>

<main class="container jogo-page">
    <div class="jogo-layout">
        <section class="jogo-media">
            <iframe id="jogo-trailer" src="<?= $jogo['trailer']; ?>" frameborder="0" allowfullscreen></iframe>

           <div class="galeria">
    <?php if(!empty($jogo['imagem1'])): ?>
        <img src="img/<?= $jogo['imagem1']; ?>" class="game-thumbnail" onclick="mudarVideo('img/<?= $jogo['imagem1']; ?>', 'foto')">
    <?php endif; ?>
    <?php if(!empty($jogo['imagem2'])): ?>
        <img src="img/<?= $jogo['imagem2']; ?>" class="game-thumbnail" onclick="mudarVideo('img/<?= $jogo['imagem2']; ?>', 'foto')">
    <?php endif; ?>
    <?php if(!empty($jogo['imagem3'])): ?>
        <img src="img/<?= $jogo['imagem3']; ?>" class="game-thumbnail" onclick="mudarVideo('img/<?= $jogo['imagem3']; ?>', 'foto')">
    <?php endif; ?>
</div>

            <div class="descricao-jogo" style="margin-top: 30px; color: #ccc;">
                <h2>Descrição do jogo</h2>
                <p><?= $jogo['descricao']; ?></p>
            </div>
        </section>

        <aside class="jogo-info">
            <h1><?= $jogo['nome']; ?></h1>
            <p class="preco-grande">R$ <?= number_format($jogo['preco'], 2, ',', '.'); ?></p>

            <button onclick="adicionarAoCarrinho(<?= $jogo['id']; ?>)" class="btn-comprar-lg">
                <i class="fas fa-shopping-cart"></i> ADICIONAR AO CARRINHO
            </button>

            <div class="info-box">
                <h3 style="color: #fff; margin-bottom: 10px;">⚡ Entrega Automática</h3>
                <p style="color: #999; font-size: 0.9rem;">
                    Após a confirmação do pagamento, você recebe o código de 25 dígitos via e-mail e na sua área do cliente.
                </p>
                <ul style="color: #999; font-size: 0.9rem; margin-top: 10px; list-style: none;">
                    <li>✅ Região: Brasil</li>
                    <li>✅ Plataforma: Xbox</li>
                </ul>
            </div>
        </aside>
    </div>
</main>
<section class="jogos-relacionados container" style="margin-top: 60px; padding-bottom: 40px;">
    <h2 style="color: #fff; margin-bottom: 25px; font-size: 1.8rem;">Você também pode gostar</h2>

    <div class="jogos-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <?php
        // Busca 4 jogos aleatórios, ignorando o jogo atual para não repetir
        $id_atual = $jogo['id'];
        $query_relacionados = "SELECT * FROM produtos WHERE id != $id_atual ORDER BY RAND() LIMIT 4";
        $res_relacionados = $conn->query($query_relacionados);

        if ($res_relacionados && $res_relacionados->num_rows > 0):
            while($rel = $res_relacionados->fetch_assoc()): 
                $img_rel = !empty($rel['imagem']) ? "img/" . $rel['imagem'] : "img/placeholder.jpg";
        ?>
            <div class="game-card">
                <img src="<?= $img_rel; ?>" alt="<?= $rel['nome']; ?>" style="width: 100%; border-radius: 10px;">
                <p class="game-title" style="color: #fff; margin: 10px 0; font-weight: 600; font-size: 0.9rem;">
                    <?= $rel['nome']; ?>
                </p>
                <p class="game-price" style="color: #8a2be2; font-weight: bold;">
                    R$ <?= number_format($rel['preco'], 2, ',', '.'); ?>
                </p>
                <div class="card-buttons" style="display: flex; gap: 10px; margin-top: 10px;">
                    <button onclick="adicionarAoCarrinho(<?= $rel['id']; ?>)" class="btn-comprar" style="background: #8a2be2; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; flex: 1; font-size: 0.8rem;">Comprar</button>
                    <a href="produtos.php?id=<?= $rel['slug']; ?>" class="btn-detalhes" style="font-size: 0.8rem; padding: 5px 10px;">Detalhes</a>
                </div>
            </div>
        <?php 
            endwhile;
        endif; 
        ?>
    </div>
</section>
<footer class="main-footer">
    <div class="container">
        <p>&copy; 2025 Nito Play. Todos os direitos reservados.</p>
    </div>
</footer>

<script src="js/carrinho.js"></script>
<script>
// Funções idênticas à Index para funcionar tudo
function toggleUserMenu() {
    const menu = document.getElementById('dropdown-user');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

function toggleCarrinho() {
    const sidebar = document.getElementById('carrinho-lateral');
    const overlay = document.getElementById('carrinho-overlay');
    sidebar.classList.toggle('active');
    overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
    if(sidebar.classList.contains('active')) atualizarExibicaoCarrinho();
}

document.addEventListener("DOMContentLoaded", function() {
    if(typeof atualizarContador === "function") atualizarContador();
});
</script>
<?php include "carrinho-template.php"; ?>
</body>
</html>