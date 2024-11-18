<?php
include '../config.php'; // Inclui a configuração do banco de dados

header("Content-Type: application/json"); // Define o tipo de resposta como JSON

// Lê o corpo da requisição para capturar dados em métodos POST/PUT
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true); // Decodifica o JSON para um array associativo

if (isset($data['episode_id'])) {
    // Caso seja uma requisição para definir um favorito
    $ep = $data['episode_id']; // Obtém o ID do episódio
    $active = isset($data['active']) ? $data['active'] : 'N'; // Define o valor de 'active', padrão 'N'

    logRequest("setar filmes favorito de id = $ep"); // Registra a requisição no log

    echo setFavorite($ep, $active); // Define o favorito e retorna o resultado
} else if (isset($_GET['episode_id'])) {
    // Caso seja uma requisição GET para buscar o status do favorito
    $ep = $_GET['episode_id']; // Obtém o ID do episódio

    logRequest("buscar se filme id = $ep é favorito"); // Registra a requisição no log

    echo getFavorite($ep); // Retorna o status do favorito
}

/**
 * Função para definir ou atualizar o status de favorito de um filme
 * @param int $ep ID do filme
 * @param string $active Status ('S' ou 'N') para o favorito
 * Retorna um JSON indicando o sucesso da operação
 */
function setFavorite($ep, $active)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    // Verifica se já existe um registro para o `film_id`
    $stmt = $mysqli->prepare("SELECT favorite_id FROM favorite_film WHERE film_id = ?");
    $stmt->bind_param("i", $ep);
    $stmt->execute();
    $stmt->bind_result($favoriteId);
    $stmt->fetch();
    $stmt->close();

    if ($favoriteId) {
        // Atualiza o registro existente
        $stmt = $mysqli->prepare("UPDATE favorite_film SET active = ? WHERE favorite_id = ?");
        $stmt->bind_param("si", $active, $favoriteId);
    } else {
        // Insere um novo registro
        $stmt = $mysqli->prepare("INSERT INTO favorite_film (film_id, active) VALUES (?, ?)");
        $stmt->bind_param("is", $ep, $active);
    }

    $stmt->execute(); // Executa a consulta
    $stmt->close(); // Fecha o statement
    $mysqli->close(); // Fecha a conexão

    return json_encode(["status" => "success"]); // Retorna o status da operação
}

/**
 * Função para obter o status de favorito de um filme
 * @param int $ep ID do filme
 * Retorna o último status encontrado ('S' ou 'N') no formato JSON
 */
function getFavorite($ep)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    // Prepara a consulta para obter o status mais recente
    $stmt = $mysqli->prepare("SELECT active FROM favorite_film WHERE film_id = ? ORDER BY favorite_id DESC LIMIT 1");
    $stmt->bind_param("i", $ep);
    $stmt->execute();
    $stmt->bind_result($active);
    $stmt->fetch();

    $stmt->close(); // Fecha o statement
    $mysqli->close(); // Fecha a conexão

    return json_encode($active); // Retorna o status do favorito
}

/**
 * Função para registrar logs de requisições no banco de dados
 * @param string $endpoint Endpoint acessado
 */
function logRequest($endpoint)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    $stmt = $mysqli->prepare("INSERT INTO api_logs (endpoint) VALUES (?)"); // Prepara o log da requisição
    $stmt->bind_param("s", $endpoint);
    $stmt->execute();

    $stmt->close(); // Fecha o statement
    $mysqli->close(); // Fecha a conexão
}
?>
