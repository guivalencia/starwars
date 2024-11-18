<?php
include '../config.php'; // Inclui a configuração do banco de dados

header("Content-Type: application/json"); // Define o tipo de resposta como JSON

// Verifica se o parâmetro 'episode_id' foi passado na URL
if (isset($_GET['episode_id'])) {
    $ep = $_GET['episode_id']; // Obtém o ID do episódio
    echo getDetalhesFilme($ep); // Retorna os detalhes do filme correspondente
}

/**
 * Função para obter detalhes de um filme específico
 * @param string $id ID do filme
 * Faz uma requisição à API, registra logs e incrementa o contador de visualizações
 */
function getDetalhesFilme($id)
{
    $url = "https://swapi.dev/api/films/$id/"; // Monta a URL para obter os detalhes do filme
    $response = makeCurlRequest($url); // Faz a requisição cURL para a API

    logRequest("buscar detalhes do filme de id = $id"); // Registra a requisição no log
    contVisual($id); // Incrementa o contador de visualizações do filme

    return json_encode($response); // Retorna a resposta da API como JSON
}

/**
 * Função genérica para fazer requisições HTTP usando cURL
 * @param string $url URL da API
 * Faz a requisição cURL e retorna os dados como um array associativo
 */
function makeCurlRequest($url)
{
    $ch = curl_init(); // Inicializa o recurso cURL
    curl_setopt($ch, CURLOPT_URL, $url); // Define a URL para a requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configura para retornar os dados como string
    $data = curl_exec($ch); // Executa a requisição
    curl_close($ch); // Fecha o recurso cURL

    return json_decode($data, true); // Decodifica o JSON da resposta em um array
}

/**
 * Função para registrar logs de requisições no banco de dados
 * @param string $endpoint Endpoint acessado
 * Salva o endpoint no banco de dados para fins de auditoria
 */
function logRequest($endpoint)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    $stmt = $mysqli->prepare("INSERT INTO api_logs (endpoint) VALUES (?)"); // Prepara a consulta
    $stmt->bind_param("s", $endpoint); // Associa o valor ao parâmetro
    $stmt->execute(); // Executa a consulta

    $stmt->close(); // Fecha o statement
    $mysqli->close(); // Fecha a conexão com o banco de dados
}

/**
 * Função para registrar visualizações de filmes no banco de dados
 * @param string $film ID do filme
 * Incrementa o contador de visualizações para o filme especificado
 */
function contVisual($film)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    $stmt = $mysqli->prepare("INSERT INTO cont_visual (film_id) VALUES (?)"); // Prepara a consulta
    $stmt->bind_param("s", $film); // Associa o valor ao parâmetro
    $stmt->execute(); // Executa a consulta

    $stmt->close(); // Fecha o statement
    $mysqli->close(); // Fecha a conexão com o banco de dados
}
?>
