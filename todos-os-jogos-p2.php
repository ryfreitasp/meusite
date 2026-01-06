<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Jogos - Nito Play</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/carrinho.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body data-pagina="2">
    <header class="main-header">
        <div class="container header-content">
            <div class="logo">
                <a href="index.php"> 
                    <img src="Fotos/Logo NIto Play.png" alt="Logo Nito Play" class="logo-img"> 
                </a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="todos-os-jogos.php">Xbox One</a></li>
                    <li><a href="todos-os-jogos.php">Xbox Series X|S</a></li>
                    <li><a href="#">Minha Conta</a></li>
                </ul>
            </nav>
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

    <main class="container">
        <section class="catalog-header">
            <h1>Explorar Todos os Jogos</h1>
            <div class="filter-bar">
                <select name="categoria">
                    <option value="">Todas as Categorias</option>
                    <option value="acao">Ação</option>
                    <option value="esporte">Esporte</option>
                    <option value="rpg">RPG</option>
                </select>
                <select name="ordem">
                    <option value="relevancia">Mais Relevantes</option>
                    <option value="menor-preco">Menor Preço</option>
                    <option value="maior-preco">Maior Preço</option>
                </select>
            </div>
        </section>
            <div class="catalog-grid" id="games-container"></div>

    </main>
    <div class="pagination-container">
    <div class="pagination">
        <a href="#" class="page-arrow disabled">&laquo;</a>
        
        <a href="todos-os-jogos.php" class="page-number">1</a>
        <a href="todos-os-jogos-p2.php" class="page-number active">2</a>
        <a href="todos-os-jogos-p3.php" class="page-number">3</a>
        
        <a href="todos-os-jogos-p2.html" class="page-arrow">&raquo;</a>
    </div>
</div>
    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Nito Play. Todos os direitos reservados.</p>
        </div>
    </footer>
<script src="js/jogos.js"></script>
<script src="js/catalogo.js"></script>
<?php include "carrinho-template.php"; ?> 
<script src="js/carrinho.js"></script>
</body>
</html>