document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");
  const jogo = jogos.find(j => j.id === id);

  if (!jogo) {
    document.body.innerHTML = "<h2 style='text-align:center'>Jogo não encontrado</h2>";
    return;
  }

  document.getElementById("jogo-nome").textContent = jogo.nome + " - 25 Dígitos";
  document.getElementById("jogo-preco").textContent = jogo.preco;
  document.getElementById("jogo-trailer").src = jogo.trailer;

  document.getElementById("img1").src = jogo.imagens[0];
  document.getElementById("img2").src = jogo.imagens[1];
  document.getElementById("img3").src = jogo.imagens[2];

  // DESCRIÇÃO (ETAPA 2)
  const descricaoEl = document.getElementById("jogo-descricao");
  if (descricaoEl) {
    descricaoEl.textContent = jogo.descricao || "Descrição não disponível.";
  }

  // MODAL DE IMAGEM
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeModal = document.querySelector(".close-modal");

  document.querySelectorAll(".game-thumbnail").forEach(img => {
    img.addEventListener("click", () => {
      modal.style.display = "flex";
      modalImg.src = img.src;
    });
  });

  closeModal.onclick = () => modal.style.display = "none";
  modal.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
  };
});

function carregarJogosAleatorios() {
    const gridRelacionados = document.getElementById('jogos-random');
    
    // Embaralha a lista de jogos e pega os primeiros 4
    const embaralhados = [...jogos].sort(() => 0.5 - Math.random()).slice(0, 5);

    gridRelacionados.innerHTML = embaralhados.map(jogo => `
        <div class="game-card">
            <img src="${jogo.imagem}" alt="${jogo.nome}">
            <p class="game-title">${jogo.nome}</p>
            <p class="game-price">${jogo.preco}</p>
            <a href="jogo.html?id=${jogo.id}" class="btn-secondary">Ver detalhes</a>
        </div>
    `).join('');
}

// Chama a função assim que a página carregar
window.addEventListener('DOMContentLoaded', carregarJogosAleatorios);