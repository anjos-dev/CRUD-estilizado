<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 *
 * __DIR__ retorna o diretório atual do arquivo,
 * o que evita problemas de caminho relativo.
 */
require __DIR__ . "/connect.php";

/**
 * Obtém a instância da conexão com o banco.
 * Esse método foi definido na classe Connect.
 */
$pdo = Connect::getInstance();

/**
 * Executa uma consulta SQL para buscar todos os usuários
 * da tabela "users", ordenando pelo campo "id" em ordem crescente.
 *
 * query() é usado quando não há parâmetros dinâmicos.
 */
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");

/**
 * fetchAll() busca todos os registros retornados pela consulta
 * e os armazena em um array.
 */
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal GTI | Gestão de Alunos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<header class="main-header">
        <div class="header-content">
            <h1>SGA <span>Sistema de Gestão Acadêmica</span></h1>
            <p>Monitoramento e Registro de Discentes - GTI 2026</p>
        </div>
    </header>

    <main class="container">
        <section class="card registration-card">
            <div class="card-header">
                <i class="fas fa-user-plus"></i>
                <h2>Novo Cadastro</h2>
            </div>

    <!--
        Formulário responsável por enviar os dados
        para o arquivo store.php, que fará o cadastro no banco.
        
        method="post" é usado para envio de dados de formulário
        de forma mais apropriada e segura do que GET.
    -->
            <form action="store.php" method="post" class="styled-form">
                <div class="input-group">
                    <label>Nome Completo:</label><br>
                    <input type="text" name="name" required>
                </div>

                <div class="input-group">
                    <label>E-mail Institucional:</label><br>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Curso / Semestre:</label><br>
                    <input type="text" name="document" required>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Finalizar Registro
                </button>
            </form>
        </section>

        <section class="card list-card">
            <div class="card-header">
                <i class="fas fa-users"></i>
                <h2>Alunos Matriculados</h2>
            </div>

    <!--
        Tabela que exibe os alunos cadastrados no banco de dados.
        O atributo cellpadding adiciona espaçamento interno nas células.
    -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Aluno</th>
                            <th>E-mail</th>
                            <th>Curso</th>
                            <th>Data de Registro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
            <!--
                foreach percorre todos os usuários retornados do banco.
                A cada repetição, a variável $user representa um aluno.
            -->
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><span class="badge-id">#<?= $user["id"] ?></span></td>
                                <td class="font-bold"><?= $user["name"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["document"] ?></td>
                                <td>
                                    <div class="date-wrapper">
                                        <span class="main-date"><?= date("d/m/Y", strtotime($user["created_at"])) ?></span>
                                        <span class="time-label"><?= date("H:i", strtotime($user["created_at"])) ?>h</span>
                                    </div>
                                </td>
                                <td class="actions">
                        <!--
                            Link para editar o aluno.
                            O ID é enviado pela URL para que o arquivo edit.php
                            saiba qual registro deve ser alterado.
                        -->
                                    <a href="edit.php?id=<?= $user["id"] ?>" class="btn-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                        <!--
                            Link para excluir o aluno.
                            O onclick chama uma confirmação em JavaScript
                            antes de seguir para a exclusão.
                        -->
                                    <a href="delete.php?id=<?= $user["id"] ?>" 
                                       onclick="return confirm('Confirmar exclusão?')" 
                                       class="btn-delete" title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <!--
                    colspan="6" faz a célula ocupar as 6 colunas da tabela.
                    count($users) conta quantos alunos existem no array.
                -->
                <p>Total de registros: <strong><?= count($users) ?></strong></p>
            </div>
        </section>
    </main>

</body>
</html>