# Explicação didática para os alunos

Esse arquivo é o responsável por **atualizar no banco de dados** as informações editadas de um aluno.

O fluxo dele é:

1. receber os dados enviados pelo formulário de edição;

2. validar o ID e os campos;

3. executar o `UPDATE` no banco;

4. redirecionar para a página principal.

Esse é o **U** do CRUD:

* **Create**

* **Read**

* **Update**

* **Delete**

# Como esse arquivo se conecta ao `edit.php`

No `edit.php`, o formulário envia os dados para:

```
<form action="update.php" method="post">
```

Então o `update.php` recebe:

* o `id` do aluno;

* o nome atualizado;

* o e-mail atualizado;

* o curso atualizado.

Ou seja:

* `edit.php` mostra o formulário preenchido;

* `update.php` salva as alterações.

# Explicando por partes

## 1. Inclusão do arquivo de conexão

```
require __DIR__ . "/connect.php";
```

Esse comando permite usar a classe `Connect` para acessar o banco de dados.

## 2. Captura do ID com validação

```
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
```

Aqui o sistema lê o `id` enviado via `POST` e verifica se ele é um número inteiro válido.

Isso é importante porque o ID define **qual registro será atualizado**.

## 3. Captura dos demais campos

```
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$document = trim($_POST["document"] ?? "");
```

Essas linhas capturam os valores enviados pelo formulário.

### `trim()`

Remove espaços desnecessários no início e no fim.

### `?? ""`

Se o campo não existir, o valor padrão será uma string vazia.

## 4. Validação dos dados

```
if (!$id || $name === "" || $email === "" || $document === "") {
    die("Dados inválidos.");
}
```

Aqui o sistema verifica:

* se o ID é válido;

* se todos os campos obrigatórios foram preenchidos.

Se algo estiver incorreto, a execução é interrompida.

## 5. Conexão com o banco

```
$pdo = Connect::getInstance();
```

Recupera a conexão com o banco de dados.

## 6. Preparação do `UPDATE`

```
$stmt = $pdo->prepare("
    UPDATE users
    SET name = :name, email = :email, document = :document
    WHERE id = :id
");
```

Esse comando prepara a instrução SQL responsável pela atualização.

### O que esse SQL faz?

* `UPDATE users` → atualiza a tabela `users`;

* `SET ...` → define os novos valores;

* `WHERE id = :id` → atualiza apenas o registro com aquele ID.

## 7. Importância do `WHERE`

Esse ponto merece bastante destaque em aula.

### Com `WHERE`

```
UPDATE users
SET name = 'João'
WHERE id = 3
```

Atualiza apenas o aluno de ID 3.

### Sem `WHERE`

```
UPDATE users
SET name = 'João'
```

Atualiza **todos os registros da tabela**.

Esse é um erro clássico e muito perigoso em SQL.

## 8. Execução da query

```
$stmt->execute([
    ":id" => $id,
    ":name" => $name,
    ":email" => $email,
    ":document" => $document
]);
```

Aqui os placeholders recebem os valores enviados pelo formulário, e o banco executa a atualização.

## 9. Redirecionamento

```
header("Location: index.php");
exit;
```

Depois de atualizar, o sistema redireciona o usuário para a página principal.

Isso ajuda a:

* evitar reenvio do formulário ao atualizar a página;

* voltar automaticamente para a listagem;

* melhorar a navegação.

# Conceitos ensinados nesse arquivo

Esse arquivo permite ensinar muito bem:

* `require`

* `filter_input()`

* `INPUT_POST`

* `FILTER_VALIDATE_INT`

* `$_POST`

* `trim()`

* operador `??`

* validação com `if`

* `die()`

* PDO

* `prepare()`

* `execute()`

* comando SQL `UPDATE`

* importância do `WHERE`

* `header()`

* `exit`

# Pontos didáticos importantes

## 1. O `id` vem por campo oculto

No `edit.php`, existia:

```
<input type="hidden" name="id" value="...">
```

É esse campo que permite ao `update.php` saber qual aluno deve ser atualizado.

Sem o ID, o sistema não saberia qual registro alterar.

## 2. O método correto aqui é `POST`

Diferente do `delete.php`, aqui o uso de `POST` está apropriado, porque estamos enviando dados para alterar o estado do sistema.

Esse é um bom momento para reforçar a diferença entre:

* `GET` → normalmente usado para buscar ou visualizar;

* `POST` → normalmente usado para enviar dados e alterar algo.

## 3. Uso de `prepare()` é essencial

Como os valores vêm do usuário, usar `prepare()` é a forma adequada de evitar SQL Injection.
