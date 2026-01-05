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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body data-pagina="1">
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
            <a href="todos-os-jogos.php" class="page-number active">1</a>
            <a href="todos-os-jogos-p2.php" class="page-number">2</a>
            <a href="todos-os-jogos-p3.php" class="page-number">3</a>
            <a href="todos-os-jogos-p2.php" class="page-arrow">&raquo;</a>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Nito Play. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="js/jogos.js"></script>
    <script>
        // Função para renderizar os jogos no container correto
        function renderizarCatalogo() {
            const container = document.getElementById('games-container');
            if (!container) return;

            // Limpa o "R$ 00,00" antigo caso exista
            container.innerHTML = ""; 

            container.innerHTML = jogos.map(jogo => `
                <div class="game-card">
                    ${jogo.novo ? '<span class="badge-novo">Novo</span>' : ''}
                    <img src="${jogo.imagem}" alt="${jogo.nome}">
                    <p class="game-title">${jogo.nome} - 25 Dígitos</p>
                    <p class="game-price">${jogo.preco}</p>
                    <div class="card-buttons">
                        <a href="comprar.php?id=${jogo.id}" class="btn-primary">Comprar</a>
                        <a href="jogo.html?id=${jogo.id}" class="btn-secondary">Detalhes</a>
                    </div>
                </div>
            `).join('');
        }

        // Executa assim que a página carrega
        document.addEventListener("DOMContentLoaded", renderizarCatalogo);
    </script>
</body>
</html>