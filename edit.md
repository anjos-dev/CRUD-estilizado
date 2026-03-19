# Explicação didática para os alunos

Esse arquivo exibe um formulário de edição com os dados já preenchidos a partir do banco.

O objetivo dele é:

1. receber o `id` do aluno pela URL;

2. buscar esse aluno no banco;

3. preencher o formulário com os dados existentes;

4. enviar os dados atualizados para o arquivo `update.php`.

Esse arquivo não atualiza o banco diretamente.\
Ele apenas **prepara a edição**.

# Fluxo do arquivo

## 1. Receber o ID pela URL

Exemplo de acesso:

```
edit.php?id=5
```

O número `5` representa o aluno que será editado.

## 2. Validar o ID

```
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
```

Aqui o PHP lê o valor enviado via `GET` e verifica se ele é um inteiro válido.

Esse ponto é muito importante, porque o sistema não deve confiar cegamente no valor que chega pela URL.

## 3. Verificar se o ID é válido

```
if (!$id) {
    die("ID inválido.");
}
```

Se o valor for inválido, o sistema interrompe a execução.

Exemplos de casos inválidos:

* `edit.php?id=abc`

* `edit.php?id=`

* `edit.php` sem parâmetro

## 4. Buscar o aluno no banco

```
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$user = $stmt->fetch();
```

Aqui o sistema busca no banco o aluno com o ID informado.

Como o campo `id` normalmente é único, o esperado é que exista no máximo um registro.

## 5. Verificar se o aluno existe

```
if (!$user) {
    die("Aluno não encontrado.");
}
```

Mesmo que o ID seja válido numericamente, ele pode não existir no banco.

Por exemplo:

* `edit.php?id=9999`

Se esse ID não estiver cadastrado, o sistema mostra a mensagem correspondente.

## 6. Preencher o formulário com os dados existentes

Exemplo:

```
<input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
```

O valor que veio do banco é colocado no atributo `value` do input.

Assim, o usuário vê os dados atuais e pode alterá-los.

# Conceitos importantes ensinados nesse arquivo

## `filter_input()`

```
filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
```

Essa função captura e valida dados de entrada.

Nesse caso:

* `INPUT_GET` indica que o dado vem da URL;

* `"id"` é o nome do parâmetro;

* `FILTER_VALIDATE_INT` verifica se é um inteiro válido.

É uma forma mais segura e organizada do que acessar diretamente `$_GET["id"]`.

## `prepare()` e `execute()`

Mesmo sendo apenas uma consulta `SELECT`, o uso de `prepare()` continua sendo o ideal quando há valores dinâmicos.

Isso evita problemas de segurança e mantém a consistência com boas práticas de PDO.

## `fetch()`

```
$user = $stmt->fetch();
```

Diferente de `fetchAll()`, que retorna vários registros, `fetch()` retorna apenas um.

Como estamos buscando um único aluno pelo ID, essa é a escolha correta.

## Campo oculto (`hidden`)

```
<input type="hidden" name="id" value="<?= $user["id"] ?>">
```

Esse campo não aparece na tela, mas envia o ID junto com o formulário.

Ele é essencial para o próximo passo do CRUD, pois o `update.php` vai precisar saber qual registro deve ser alterado.

## `htmlspecialchars()`

Exemplo:

```
<?= htmlspecialchars($user["name"]) ?>
```

Essa função converte caracteres especiais em entidades HTML.

Isso evita que conteúdos salvos no banco que contenham HTML ou JavaScript sejam interpretados pelo navegador.

Exemplo:

* `<script>alert('x')</script>`

sem `htmlspecialchars()`, poderia gerar comportamento perigoso;\
com `htmlspecialchars()`, será exibido apenas como texto.

Esse é um ótimo momento para introduzir o tema **XSS (Cross-Site Scripting)** de forma simples.

# O que esse arquivo ensina dentro do CRUD

No CRUD:

* `index.php` faz o **Read** e mostra o formulário de **Create**;

* `store.php` faz o **Create**;

* `edit.php` carrega os dados para o **Update**;

* `update.php` efetivamente salva a alteração;

* `delete.php` faz o **Delete**.

Então o `edit.php` é a ponte entre:

* visualizar um registro;

* editar um registro.

# Pontos didáticos muito bons nesse arquivo

## 1. Uso correto de `htmlspecialchars()`

Esse ponto está muito bom e vale a pena destacar em aula.

No `index.php`, os dados estavam sendo exibidos sem essa proteção.\
Aqui, no `edit.php`, ela já foi usada corretamente.

Você pode até aproveitar para mostrar aos alunos a diferença entre:

* saída sem tratamento;

* saída tratada.

## 2. Uso de `filter_input()` em vez de `$_GET` direto

Isso também é uma boa prática para introduzir validação de entrada.

## 3. Busca de um único registro com `fetch()`

Excelente para mostrar a diferença entre:

* `fetch()`

* `fetchAll()`
