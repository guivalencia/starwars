<?php
include '../config.php'; // Inclui a configuração necessária para o banco de dados

header("Content-Type: application/json"); // Define o cabeçalho da resposta como JSON

// Verifica se o parâmetro 'episode_id' foi passado na URL
if (isset($_GET['episode_id'])) {
    $ep = $_GET['episode_id']; // Obtém o ID do episódio a partir da URL

    logRequest("buscar qtd de visualizações do episodio = $ep"); // Registra a requisição no log

    echo getContVisual($ep); // Retorna a contagem de visualizações do episódio
}

/**
 * Função para obter a contagem de visualizações de um episódio
 * @param string $ep ID do episódio
 * Conecta ao banco de dados, executa a consulta e retorna o total de visualizações
 */
function getContVisual($ep)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    // Prepara a consulta para contar as visualizações do filme
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM cont_visual WHERE film_id = ?");
    $stmt->bind_param("s", $ep); // Vincula o ID do filme como parâmetro

    $stmt->execute(); // Executa a consulta

    $stmt->bind_result($count); // Liga o resultado à variável $count

    $stmt->fetch(); // Obtém o valor retornado pela consulta

    // Fecha os recursos de banco de dados
    $stmt->close();
    $mysqli->close();

    return json_encode($count); // Retorna a contagem como JSON
}

/**
 * Função para registrar logs de requisições no banco de dados
 * @param string $endpoint Endpoint acessado, usado para auditoria
 */
function logRequest($endpoint)
{
    $mysqli = connectDatabase(); // Conecta ao banco de dados

    // Insere o endpoint acessado na tabela de logs
    $stmt = $mysqli->prepare("INSERT INTO api_logs (endpoint) VALUES (?)");
    $stmt->bind_param("s", $endpoint);
    $stmt->execute();

    // Fecha os recursos de banco de dados
    $stmt->close();
    $mysqli->close();
}
?>
