// Definindo referências aos elementos da página
const mainDetail = document.getElementById("mainDetail");  // Para exibir os detalhes do filme
const body = document.querySelector("body");  // Referência ao corpo da página
const imgStar = document.getElementById("imgStar");  // Ícone de estrela de favorito
const skelet = document.getElementById("skelet");  // Elemento de esqueleto de carregamento
const btnAll = document.getElementById("btn-all");  // Botão para mostrar todos os filmes
const btnFavorite = document.getElementById("btn-favorite");  // Botão para mostrar apenas favoritos

// Se estamos na página inicial (listagem de filmes)
if (document.location.href == "http://localhost/starwars/") {
  window.onload = async () => {
    console.log(document.location.href);

    try {
      const spanAll = document.getElementById("spanAll");  // Contador de filmes totais
      const spanFavorite = document.getElementById("spanFavorite");  // Contador de filmes favoritos

      // Requisição para obter todos os filmes da API
      const response = await fetch('http://localhost/starwars/src/api/api.php');
      const data = await response.json();
      let i = 1;
      let c = 0;  // Contador de filmes favoritos

      // Adicionando os filmes à página
      for (const movie of data.results) {
        const divIndex = document.createElement("div");
        const div = document.createElement("div");
        const h2 = document.createElement("h2");
        const p = document.createElement("p");
        const img = document.createElement("img");

        divIndex.classList.add("catalog", "divIndex");
        divIndex.setAttribute("id", i);

        div.classList.add("movie-card");
        div.setAttribute("onclick", `window.location.href='./detalhes.php?episode_id=${i}'`);

        h2.textContent = `Star Wars: ${movie.title}`;

        // Formatação da data de lançamento
        const formattedDate = formatDate(movie.release_date);
        p.textContent = `Data de Lançamento: ${formattedDate}`;

        // Requisição para verificar se o filme está favoritado
        const isActive = await fetch(`http://localhost/starwars/src/api/img-api.php?episode_id=${i}`);
        const dataActive = await isActive.json();  // Obtendo a resposta da API

        if (dataActive === 'S') {  // Se o filme está favoritado
          img.setAttribute("src", "./assets/star-active.svg");
          c++;  // Incrementa o contador de favoritos
        } else {
          img.setAttribute("src", "./assets/star.svg");
        }

        // Ação de clique no ícone de estrela
        img.setAttribute("onclick", "imgClick(this);spanClick();");
        img.setAttribute("id", i);

        div.append(h2, p);
        divIndex.append(div, img);
        body.appendChild(divIndex);  // Adiciona o filme à página

        i++;  // Incrementa o contador de filmes
      }

      // Atualiza os contadores de filmes e favoritos
      spanAll.classList.remove("skeleton", "skeleton-span");
      spanAll.textContent = data.results.length;

      spanFavorite.classList.remove("skeleton", "skeleton-span");
      spanFavorite.textContent = c;

      skelet.remove();  // Remove o esqueleto de carregamento
    } catch (error) {
      console.error("Erro ao buscar filmes:", error);
    }
  };
}
// Se estamos na página de detalhes do filme
else if (document.location.pathname == "/starwars/detalhes.php") {
  window.onload = async () => {
    const id = document.location.search;
    const urlParams = new URLSearchParams(window.location.search);
    const ep = urlParams.get("episode_id");

    try {
      const response = await fetch(`http://localhost/starwars/src/api/detail-api.php${id}`);
      const data = await response.json();

      const divStar = document.createElement("div");
      const imgStar = document.createElement("img");
      const divEye = document.createElement("div");
      const imgEye = document.createElement("img");
      const pEye = document.createElement("p");
      const h2 = document.createElement("h2");
      const p1 = document.createElement("p");
      const strongP1 = document.createElement("strong");
      const p2 = document.createElement("p");
      const strongP2 = document.createElement("strong");
      const p3 = document.createElement("p");
      const strongP3 = document.createElement("strong");
      const p4 = document.createElement("p");
      const strongP4 = document.createElement("strong");
      const p5 = document.createElement("p");
      const strongP5 = document.createElement("strong");
      const h3 = document.createElement("h3");
      const ul = document.createElement("ul");

      // Verifica se o filme está favoritado
      const isActive = await fetch(`http://localhost/starwars/src/api/img-api.php${id}`);
      const dataActive = await isActive.json();  // Obtém o status de favoritado

      // Define o ícone de estrela de acordo com o status
      if (dataActive === 'S') {
        imgStar.setAttribute("src", "./assets/star-active.svg");
      } else {
        imgStar.setAttribute("src", "./assets/star.svg");
      }

      imgStar.setAttribute("onclick", "imgClick(this)");
      imgStar.setAttribute("id", ep);
      divStar.append(imgStar);
      divStar.classList.add("star");

      // Requisição para obter o número de visualizações
      const film = await fetch(`http://localhost/starwars/src/api/cont-api.php${id}`);
      const cont = await film.json();
      pEye.textContent = `${cont} visualizações`;
      imgEye.setAttribute("src", "./assets/eye.svg");
      divEye.classList.add("eye");
      divEye.append(imgEye, pEye);

      h2.textContent = `Star Wars: ${data.title}`;

      // Adiciona informações sobre o filme (episódio, sinopse, etc)
      strongP1.textContent = "Episódio: ";
      p1.append(strongP1, data.episode_id);

      strongP2.textContent = 'Sinopse: ';
      p2.append(strongP2, data.opening_crawl);

      // Formatação da data de lançamento
      const formattedDate = formatDate(data.release_date);
      strongP3.textContent = "Data de Lançamento: ";
      p3.append(strongP3, formattedDate);

      strongP4.textContent = "Diretor: ";
      p4.append(strongP4, data.director);

      strongP5.textContent = "Produtores: ";
      p5.append(strongP5, data.producer);

      h3.textContent = "Personagens: ";

      // Adiciona personagens à lista
      let i = 1;
      for (const person of data.characters) {
        const li = document.createElement("li");
        const response = await fetch(`http://localhost/starwars/src/api/person-api.php?person=${person}`);
        const personData = await response.json();
        li.textContent = personData.name + (i < data.characters.length ? " - " : "");
        ul.append(li);
        i++;
      }

      // Atualiza a página com os detalhes
      skelet.remove();
      skelet.classList.remove("movie-details");
      mainDetail.classList.add("movie-details");
      mainDetail.append(divStar, divEye, h2, p1, p2, p3, p4, p5, h3, ul);
    } catch (error) {
      console.error("Erro ao buscar filmes:", error);
    }
  };
}

// Função para formatar a data no formato dd/mm/yyyy
function formatDate(dateString) {
  const date = new Date(dateString)
  const day = String(date.getDate()).padStart(2, "0")  // Adiciona zero à esquerda do dia se necessário
  const month = String(date.getMonth() + 1).padStart(2, "0")  // Meses começam do 0, então somamos 1
  const year = date.getFullYear()  // Obtém o ano
  return `${day}/${month}/${year}`  // Retorna no formato dd/mm/yyyy
}

// Função que altera o ícone da estrela quando clicado e atualiza o status na API
function imgClick(e) {
  const targetSrc = '/assets/star-active.svg';  // URL da imagem de estrela ativa
  console.log(e.src)  // Exibe o src da imagem clicada no console para debug
  
  // Verifica se a estrela está ativa
  if (e.src.includes(targetSrc)) {
    // Se a estrela estiver ativa, desativa
    e.setAttribute("src", "./assets/star.svg")
    const isActive = 'N'  // Marca como inativo
    // Envia a alteração para a API
    fetch('http://localhost/starwars/src/api/img-api.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        episode_id: e.id,  // Envia o ID do episódio
        active: isActive
      })
    })
  } else {
    // Se a estrela não estiver ativa, ativa
    e.setAttribute("src", "./assets/star-active.svg")
    const isActive = 'S'  // Marca como ativo
    // Envia a alteração para a API
    fetch('http://localhost/starwars/src/api/img-api.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        episode_id: e.id,  // Envia o ID do episódio
        active: isActive
      })
    })
  }
}

// Event listener para atualizar a página ao clicar no botão "All"
btnAll.addEventListener("click", async () => {
  window.location.reload(true)  // Recarrega a página
  const span = document.getElementById("spanAll")
  span.classList.add("skeleton")  // Adiciona a classe de esqueleto para indicar carregamento
  span.classList.add("skeleton-span")
  span.textContent = ""  // Limpa o conteúdo enquanto carrega
})

// Event listener para filtrar filmes favoritos ao clicar no botão "Favorite"
btnFavorite.addEventListener("click", async () => {
  const span = document.getElementById("spanFavorite")
  span.classList.add("skeleton")  // Adiciona a classe de esqueleto para indicar carregamento
  span.classList.add("skeleton-span")
  span.textContent = ""  // Limpa o conteúdo enquanto carrega

  const response = await fetch('http://localhost/starwars/src/api/api.php')  // Faz requisição para obter todos os filmes
  const data = await response.json()
  let i = 1  // Inicializa o contador de filmes
  let c = 0  // Contador de filmes favoritos

  // Loop através dos filmes
  for (const movie of data.results) {
    const divIndex = document.getElementById(i)  // Obtém o elemento do filme pelo ID

    if (divIndex) {
      // Faz a requisição para verificar se o filme está ativo (favorito)
      const isActive = await fetch(
        `http://localhost/starwars/src/api/img-api.php?episode_id=${i}`
      )
      const dataActive = await isActive.json()  // Obtém o status de ativo da API

      if (dataActive === 'N') {  // Se o filme não for favorito
        divIndex.remove()  // Remove o filme da página
      } else {
        c++  // Incrementa o contador de favoritos
      }
    }

    i++;  // Incrementa o índice do filme
  }

  // Atualiza a contagem de filmes favoritos
  span.classList.remove("skeleton")
  span.classList.remove("skeleton-span")
  span.textContent = c  // Exibe o número de filmes favoritos
})

// Função chamada ao clicar no ícone da estrela, para atualizar a contagem de favoritos
async function spanClick() {
  const span = document.getElementById("spanFavorite")
  span.classList.add("skeleton")  // Adiciona o esqueleto para mostrar carregamento
  span.classList.add("skeleton-span")
  span.textContent = ""  // Limpa o conteúdo

  const response = await fetch('http://localhost/starwars/src/api/api.php')  // Requisição para todos os filmes
  const data = await response.json()
  let i = 1  // Inicializa o contador de filmes
  let c = 0  // Contador de filmes favoritos

  // Loop para verificar o status de cada filme
  for (const movie of data.results) {
    // Faz a requisição para verificar se o filme está ativo
    const isActive = await fetch(
      `http://localhost/starwars/src/api/img-api.php?episode_id=${i}`
    )
    const dataActive = await isActive.json()  // Obtém o status de ativo da API

    if (dataActive === 'N') {  // Se o filme não for favorito
      // Não faz nada
    } else {
      c++  // Incrementa o contador de favoritos
    }

    i++;  // Incrementa o índice do filme
  }

  // Atualiza a contagem de filmes favoritos
  span.classList.remove("skeleton")
  span.classList.remove("skeleton-span")
  span.textContent = c  // Exibe a contagem final de filmes favoritos
}
