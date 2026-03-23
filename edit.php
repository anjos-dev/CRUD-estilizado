<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura o parâmetro "id" enviado pela URL
 * e valida se ele é um número inteiro válido.
 *
 * Exemplo de URL:
 * edit.php?id=3
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * Se o ID não for válido, o script é interrompido.
 */
if (!$id) {
    die("ID inválido.");
}

/**
 * Obtém a conexão com o banco de dados.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a consulta SQL para buscar apenas um usuário
 * com o ID informado.
 *
 * LIMIT 1 reforça que apenas um registro será retornado.
 */
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

/**
 * Executa a consulta, passando o valor do ID.
 */
$stmt->execute([":id" => $id]);

/**
 * Busca o primeiro registro encontrado.
 * Como o ID é único, esperamos apenas um usuário.
 */
$user = $stmt->fetch();

/**
 * Se nenhum aluno for encontrado, interrompe a execução.
 */
if (!$user) {
    die("Aluno não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal GTI | Editar Aluno</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <header class="main-header">
        <div class="header-content">
            <h1>SGA <span>Sistema de Gestão Acadêmica</span></h1>
            <p>Edição de Registro Cadastral</p>
        </div>
    </header>

    <main class="container" style="grid-template-columns: 1fr; max-width: 600px;">
        <section class="card registration-card">
            <div class="card-header">
                <i class="fas fa-user-edit"></i>
                <h2>Atualizar Dados do Aluno</h2>
            </div>

    <!--
        Formulário responsável por enviar os dados atualizados
        para o arquivo update.php.
    -->
    <form action="update.php" method="post" class="styled-form">
        <!--
            Campo oculto que envia o ID do aluno.
            Ele é necessário para que o update.php saiba
            qual registro deve ser atualizado.
        -->
        <input type="hidden" name="id" value="<?= $user["id"] ?>">

        <div class="input-group">
                    <label>Nome Completo</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
                </div>

                <div class="input-group">
                    <label>E-mail Institucional</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                </div>

                <div class="input-group">
                    <label>Curso / Semestre</label>
                    <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required>
                </div>

                <div class="actions-edit" style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" class="btn-primary" style="flex: 2;">
                        <i class="fas fa-sync-alt"></i> Salvar Alterações
                    </button>
                    
                    <a href="index.php" class="btn-delete" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                        Cancelar
                    </a>
                </div>
            </form>
        </section>
    </main>

</body>
</html>