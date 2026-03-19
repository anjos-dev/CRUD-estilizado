<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura o parâmetro "id" enviado pela URL
 * e valida se ele é um número inteiro válido.
 *
 * Exemplo:
 * delete.php?id=3
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * Se o ID não for válido, interrompe a execução.
 */
if (!$id) {
    die("ID inválido.");
}

/**
 * Obtém a conexão com o banco de dados.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a instrução SQL para excluir o usuário
 * com base no ID informado.
 */
$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");

/**
 * Executa a instrução preparada, enviando o valor do ID.
 */
$stmt->execute([
    ":id" => $id
]);

/**
 * Redireciona o usuário de volta para a página principal
 * após a exclusão.
 */
header("Location: index.php");

/**
 * Encerra a execução do script.
 */
exit;
