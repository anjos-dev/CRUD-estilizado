<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura os dados enviados pelo formulário via método POST.
 *
 * O operador ?? "" garante que, se o índice não existir,
 * seja usado uma string vazia como valor padrão.
 *
 * trim() remove espaços em branco no início e no fim.
 */
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$document = trim($_POST["document"] ?? "");

/**
 * Validação básica:
 * se qualquer campo estiver vazio, a execução é interrompida.
 */
if ($name === "" || $email === "" || $document === "") {
    die("Preencha todos os campos.");
}

/**
 * Obtém a conexão com o banco.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a instrução SQL de inserção.
 *
 * prepare() é a forma recomendada quando existem dados dinâmicos,
 * pois ajuda a evitar SQL Injection.
 */
$stmt = $pdo->prepare("
    INSERT INTO users (name, email, document)
    VALUES (:name, :email, :document)
");

/**
 * Executa a instrução preparada, enviando os valores
 * para os placeholders nomeados.
 */
$stmt->execute([
    ":name" => $name,
    ":email" => $email,
    ":document" => $document
]);

/**
 * Redireciona o usuário para a página principal após o cadastro.
 */
header("Location: index.php");

/**
 * Encerra a execução do script após o redirecionamento.
 */
exit;
