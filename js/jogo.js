document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    const jogo = jogos.find(j => j.id === id);

    if (!jogo) {
        document.body.innerHTML = "<h2 style='text-align:center; color:white; margin-top:50px;'>Jogo não encontrado</h2>";
        return;
    }

    // Preenche os dados básicos
    document.getElementById("jogo-nome").textContent = jogo.nome + " - 25 Dígitos";
    document.getElementById("jogo-preco").textContent = jogo.preco;
    document.getElementById("jogo-trailer").src = jogo.trailer;

    // Preenche as imagens da galeria
    document.getElementById("img1").src = jogo.imagens[0];
    document.getElementById("img2").src = jogo.imagens[1];
    document.getElementById("img3").src = jogo.imagens[2];

    // --- AJUSTE DO BOTÃO DE COMPRA ---
    // Faz o botão "Comprar agora" enviar o ID para o comprar.php
    const btnComprar = document.querySelector(".btn-comprar");
    if (btnComprar) {
        btnComprar.href = `comprar.php?id=${jogo.id}`;
    }

    // Descrição
    const descricaoEl = document.getElementById("jogo-descricao");
    if (descricaoEl) {
        descricaoEl.textContent = jogo.descricao || "Descrição não disponível.";
    }

    // Lógica do Modal de Imagem
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const closeModal = document.querySelector(".close-modal");

    document.querySelectorAll(".game-thumbnail").forEach(img => {
        img.addEventListener("click", () => {
            modal.style.display = "flex";
            modalImg.src = img.src;
        });
    });

    if (closeModal) {
        closeModal.onclick = () => modal.style.display = "none";
    }
    
    if (modal) {
        modal.onclick = (e) => {
            if (e.target === modal) modal.style.display = "none";
        };
    }

    // Chama os relacionados
    carregarJogosAleatorios();
});

function carregarJogosAleatorios() {
    const gridRelacionados = document.getElementById('jogos-random');
    if (!gridRelacionados) return;
    
    // Embaralha a lista de jogos e pega 5
    const embaralhados = [...jogos].sort(() => 0.5 - Math.random()).slice(0, 5);

    gridRelacionados.innerHTML = embaralhados.map(jogo => `
        <div class="game-card">
            <img src="${jogo.imagem}" alt="${jogo.nome}">
            <p class="game-title">${jogo.nome}</p>
            <p class="game-price">${jogo.preco}</p>
            <a href="href="produto.php?id=<?php echo $jogo['slug']; ?>" class="btn-secondary">Ver detalhes</a>
        </div>
    `).join('');
}