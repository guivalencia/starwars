<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Filmes - Star Wars</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <div class="saber blue-saber"></div>
    <div class=" saber red-saber"></div>
    <h1 id="id">STAR WARS</h1>
  </header>

  <div class="div-btn">
    <div class="btn-star" id="btn-all">
      <img src="./assets/todos.svg" alt="">
      <p>Filmes</p>
      <span class="skeleton skeleton-span" id="spanAll"></span>
    </div>
    <div class="btn-star" id="btn-favorite">
      <img src="./assets/star-active.svg" alt="">
      <p>Favoritos</p>
      <span class="skeleton skeleton-span" id="spanFavorite"></span>
    </div>
  </div>

  <div id="skelet" class="catalog">
    <div class="movie-card">
      <div class="skeleton skeleton-text"></div>
      <div class="skeleton skeleton-text"></div>
      <div class="skeleton skeleton-text"></div>
    </div>
  </div>

  <!-- <div id="divIndex" class="catalog">
    <div class="movie-card" onclick="window.location.href='detalhes.php?filme_id=1'">
      <h2>Star Wars: A New Hope</h2>
      <p>Data de Lançamento: 1977-05-25</p>
    </div>
    <img src="./assets/star-active.svg" alt="" onclick="imgClick(this)">
  </div> -->

</body>
<script src="main.js"></script>

</html>