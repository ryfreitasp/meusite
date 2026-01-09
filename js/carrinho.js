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
    const formData = new FormData();
    formData.append('acao', 'adicionar');
    formData.append('produto_id', produtoId);

    fetch('ajax_carrinho.php', {
        method: 'POST', 
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.sucesso) {
            toggleCarrinho(); // Abre a aba lateral
        } else {
            alert(data.mensagem);
        }
    })
    .catch(error => console.error('Erro:', error));
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

function atualizarContador() {
    fetch('ajax_carrinho.php?acao=contar')
    .then(response => response.json())
    .then(data => {
        const badge = document.querySelector('.badge-carrinho');
        if(badge) badge.innerText = data.total;
    });
}

function removerDoCarrinho(produtoId) {
    if(!produtoId) return;

    const formData = new FormData();
    formData.append('acao', 'remover');
    formData.append('produto_id', produtoId);

    fetch('ajax_carrinho.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.sucesso) {
            // O segredo está aqui: chamamos as funções que VOCÊ já criou acima
            atualizarExibicaoCarrinho(); 
            atualizarContador(); // Nome corrigido (você tinha escrito atualizarContagemCarrinho)
        } else {
            console.error('Erro ao remover:', data.mensagem);
        }
    })
    .catch(error => console.error('Erro na requisição:', error));
}