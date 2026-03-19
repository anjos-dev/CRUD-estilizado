# Explicação didática para os alunos

Esse arquivo é responsável por excluir um aluno do banco de dados.

O fluxo dele é simples:

1. receber o `id` pela URL;

2. validar esse `id`;

3. executar o `DELETE` no banco;

4. redirecionar para a listagem.

Esse é o **D** do CRUD:

* **Create**

* **Read**

* **Update**

* **Delete**

# Explicando por partes

## 1. Inclusão da conexão

```
require __DIR__ . "/connect.php";
```

Esse comando carrega o arquivo responsável pela conexão com o banco.

Sem isso, não seria possível usar a classe `Connect`.

## 2. Captura e validação do ID

```
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
```

Aqui o script lê o valor da URL e verifica se ele é um número inteiro válido.

Exemplo de URL:

```
delete.php?id=5
```

Nesse caso, o valor capturado será `5`.

## 3. Verificação do ID

```
if (!$id) {
    die("ID inválido.");
}
```

Se o parâmetro:

* não existir,

* estiver vazio,

* ou não for um número inteiro válido,

o script é encerrado.

Isso evita que o sistema tente executar uma exclusão com valor inválido.

## 4. Conexão com o banco

```
$pdo = Connect::getInstance();
```

Obtém a conexão com o banco de dados.

## 5. Preparação da query `DELETE`

```
$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
```

Aqui o sistema prepara a instrução SQL que vai excluir o registro.

### O que significa essa query?

* `DELETE FROM users` → exclui da tabela `users`;

* `WHERE id = :id` → apenas o registro cujo `id` for igual ao valor informado.

Esse `WHERE` é extremamente importante.

Sem ele, o comando poderia apagar **todos os registros da tabela**.

Esse é um ótimo ponto para alertar os alunos.

## 6. Execução da exclusão

```
$stmt->execute([
    ":id" => $id
]);
```

Aqui o valor do ID é enviado para o placeholder `:id`, e a instrução é executada.

Se existir um aluno com esse ID, ele será removido do banco.

## 7. Redirecionamento

```
header("Location: index.php");
exit;
```

Depois da exclusão, o usuário é levado de volta para a página principal.

Isso melhora a navegação e permite que ele veja imediatamente a lista atualizada.

# Conceitos que esse arquivo ensina

Esse arquivo permite trabalhar com os alunos:

* `require`

* `filter_input()`

* `INPUT_GET`

* `FILTER_VALIDATE_INT`

* validação de entrada

* `if`

* `die()`

* PDO

* `prepare()`

* `execute()`

* comando SQL `DELETE`

* importância do `WHERE`

* `header()`

* `exit`

# Ponto didático muito importante: o `WHERE` no `DELETE`

Vale muito enfatizar isso em aula.

## Com `WHERE`

```
DELETE FROM users WHERE id = 3
```

Exclui apenas o registro com ID 3.

## Sem `WHERE`

```
DELETE FROM users
```

Exclui **todos os registros da tabela**.

Esse é um dos erros mais perigosos em SQL, então esse arquivo é uma boa oportunidade para reforçar essa atenção.
