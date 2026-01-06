// Abrir e fechar o carrinho
function toggleCarrinho() {
    const carrinho = document.getElementById('carrinho-lateral');
    const overlay = document.getElementById('carrinho-overlay');
    
    carrinho.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Sempre que abrir, atualiza a lista de itens
    if (carrinho.classList.contains('active')) {
        atualizarExibicaoCarrinho();
    }
}

// Função para adicionar jogo ao carrinho via AJAX
function adicionarAoCarrinho(produtoId) {
    // Usamos fetch para falar com o PHP sem dar refresh
    fetch('ajax_carrinho.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'acao=adicionar&produto_id=' + produtoId
    })
    .then(response => response.json())
    .then(data => {
        if (data.sucesso) {
            toggleCarrinho(); // Abre a aba para mostrar o jogo adicionado
        } else {
            alert('Erro: ' + data.mensagem);
        }
    });
}

// Função para buscar os itens do banco e colocar no HTML da aba
function atualizarExibicaoCarrinho() {
    const container = document.getElementById('itens-do-carrinho');
    
    fetch('ajax_carrinho.php?acao=listar')
    .then(response => response.text())
    .then(html => {
        container.innerHTML = html;
        // Aqui também atualizaríamos o valor total se necessário
    });
}