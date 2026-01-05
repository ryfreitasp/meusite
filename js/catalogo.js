document.addEventListener("DOMContentLoaded", () => {

  if (typeof jogos === "undefined") {
    console.error("Array jogos não encontrado");
    return;
  }

  const jogosPorPagina = 20;
  const paginaAtual = Number(document.body.dataset.pagina || 1);

  const inicio = (paginaAtual - 1) * jogosPorPagina;
  const fim = inicio + jogosPorPagina;

  const jogosPagina = jogos.slice(inicio, fim);
  const container = document.getElementById("games-container");

  jogosPagina.forEach(jogo => {
    const card = document.createElement("div");
    card.className = "game-card";

    card.innerHTML = `
  ${jogo.novo ? '<div class="badge">Novo</div>' : ''}
  <img src="${jogo.imagem}" alt="${jogo.nome}">
  <p class="game-title">${jogo.nome} - 25 Dígitos</p>
  <p class="game-price">${jogo.preco}</p>
  <a href="jogo.html?id=${jogo.id}" class="btn-secondary">Comprar</a>
`;

    container.appendChild(card);
  });

});


