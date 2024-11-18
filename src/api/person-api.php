<?php
include '../config.php'; // Inclui a configuração do banco de dados

header("Content-Type: application/json"); // Define o tipo de resposta como JSON

// Verifica se o parâmetro 'person' foi enviado via GET
if (isset($_GET['person'])) {
    $url = $_GET['person']; // Obtém o URL do personagem fornecido na URL
    echo getPerson($url); // Chama a função para buscar os detalhes do personagem e retorna os dados
}

/**
 * Função para obter detalhes de um personagem específico
 * @param string $url URL para buscar o personagem
 * Faz uma requisição à API e retorna os dados do personagem
 */
function getPerson($url)
{
    $response = makeCurlRequest($url); // Faz a requisição cURL para buscar os dados

    logRequest("buscar personagem em $url"); // Registra a requisição no log

    return json_encode($response); // Retorna os dados do personagem em formato JSON
}

/**
 * Função genérica para fazer requisição HTTP usando cURL
 * @param string $url URL da API
 * Retorna a resposta decodificada como um array associativo
 */
function makeCurlRequest($url)
{
    $ch = curl_init(); // Inicializa o recurso cURL
    curl_setopt($ch, CURLOPT_URL, $url); // Define a URL para a requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configura para retornar os dados como string
    $data = curl_exec($ch); // Executa a requisição
    curl_close($ch); // Fecha o recurso cURL

    return json_decode($data, true); // Decodifica a resposta JSON em um array associativo
}

/**
 * Função para registrar logs de requisições no banco de dados
 * @param string $endpoint Endpoint acessado
 * Registra o endpoint da requisição no banco de dados
 */
function logRequest($endpoint)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    $stmt = $mysqli->prepare("INSERT INTO api_logs (endpoint) VALUES (?)"); // Prepara a consulta
    $stmt->bind_param("s", $endpoint); // Associa o valor do endpoint
    $stmt->execute(); // Executa a consulta

    $stmt->close(); // Fecha o statement
    $mysqli->close(); // Fecha a conexão com o banco de dados
}
?>
