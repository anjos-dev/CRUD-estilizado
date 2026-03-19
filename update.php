<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura e valida o ID enviado pelo formulário via POST.
 * O ID deve ser um número inteiro válido.
 */
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

/**
 * Captura os demais dados enviados pelo formulário.
 *
 * trim() remove espaços em branco no início e no fim.
 * O operador ?? "" garante valor padrão caso o índice não exista.
 */
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$document = trim($_POST["document"] ?? "");

/**
 * Validação básica:
 * - o ID precisa ser válido
 * - nome, e-mail e curso não podem estar vazios
 */
if (!$id || $name === "" || $email === "" || $document === "") {
    die("Dados inválidos.");
}

/**
 * Obtém a conexão com o banco de dados.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a instrução SQL de atualização.
 *
 * O registro será atualizado com base no ID recebido.
 */
$stmt = $pdo->prepare("
    UPDATE users
    SET name = :name, email = :email, document = :document
    WHERE id = :id
");

/**
 * Executa a instrução preparada, enviando os valores
 * para os respectivos placeholders.
 */
$stmt->execute([
    ":id" => $id,
    ":name" => $name,
    ":email" => $email,
    ":document" => $document
]);

/**
 * Redireciona o usuário para a página principal
 * após a atualização.
 */
header("Location: index.php");

/**
 * Encerra a execução do script.
 */
exit;
