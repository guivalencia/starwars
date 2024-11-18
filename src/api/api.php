<?php
include '../config.php'; // Inclui a configuração do banco de dados e outros recursos necessários

header("Content-Type: application/json"); // Define o tipo de conteúdo da resposta como JSON

// Retorna a lista de filmes da API Star Wars
echo getListaFilmes();

/**
 * Função para obter a lista de filmes da API Star Wars
 * Faz uma requisição à API e retorna os dados no formato JSON
 */
function getListaFilmes() {
    $url = "https://swapi.dev/api/films/"; // URL para buscar todos os filmes
    $response = makeCurlRequest($url); // Faz a requisição via cURL

    logRequest('buscar filmes'); // Registra a requisição no banco de dados

    return json_encode($response); // Retorna a resposta da API no formato JSON
}

/**
 * Função para obter os detalhes de um filme específico
 * @param int $id Identificador do filme
 * Faz uma requisição à API com o ID do filme e retorna os dados no formato JSON
 */
function getDetalhesFilme($id) {
    $url = "https://swapi.dev/api/films/$id/"; // URL para buscar detalhes de um filme específico
    $response = makeCurlRequest($url); // Faz a requisição via cURL

    logRequest("buscar detalhes do filme de id = $id"); // Registra a requisição no banco de dados

    return json_encode($response); // Retorna a resposta da API no formato JSON
}

/**
 * Função genérica para fazer requisições HTTP usando cURL
 * @param string $url URL para a requisição
 * Configura e executa a requisição cURL, retornando os dados em formato de array associativo
 */
function makeCurlRequest($url) {
    $ch = curl_init(); // Inicializa o cURL
    curl_setopt($ch, CURLOPT_URL, $url); // Define a URL da requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como string
    $data = curl_exec($ch); // Executa a requisição
    curl_close($ch); // Fecha o recurso cURL

    return json_decode($data, true); // Decodifica o JSON da resposta em um array
}

/**
 * Função para registrar logs de requisições no banco de dados
 * @param string $endpoint Identifica o endpoint que foi acessado
 * Registra a requisição no banco de dados para fins de auditoria
 */
function logRequest($endpoint) {
    $mysqli = connectDatabase(); // Conecta ao banco de dados
    $stmt = $mysqli->prepare("INSERT INTO api_logs (endpoint) VALUES (?)"); // Prepara o comando SQL
    $stmt->bind_param("s", $endpoint); // Associa o parâmetro do endpoint
    $stmt->execute(); // Executa o comando
    $stmt->close(); // Fecha o comando
    $mysqli->close(); // Fecha a conexão com o banco
}
?>
