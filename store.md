# Explicação didática para os alunos

Esse arquivo é responsável por **salvar no banco de dados** as informações enviadas pelo formulário.

Ele representa a parte **Create** do CRUD, ou seja, a parte de **criação de registros**.

O fluxo dele é:

1. receber os dados do formulário;

2. validar os dados;

3. conectar ao banco;

4. executar o `INSERT`;

5. redirecionar para a página principal.

# Explicando por partes

## 1. Inclusão da conexão

```
require __DIR__ . "/connect.php";
```

Aqui o arquivo `connect.php` é carregado para que o script possa usar a classe `Connect`.

Sem isso, a conexão com o banco não existiria.

## 2. Recebimento dos dados com `$_POST`

```
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$document = trim($_POST["document"] ?? "");
```

Essas linhas capturam os valores enviados pelo formulário.

### `$_POST`

É uma variável superglobal do PHP usada para acessar dados enviados por formulários com `method="post"`.

### `?? ""`

Esse operador significa:

* use `$_POST["name"]` se ele existir;

* senão, use `""`.

### `trim()`

Remove espaços no começo e no fim da string.

Exemplo:

```
"   João   "
```

vira:

```
"João"
```

# Atenção: erro de compatibilidade com o formulário

No seu `index.php`, o campo foi definido assim:

```
<input type="text" name="nomecompleto" required>
```

Mas no `store.php`, o código lê:

```
$_POST["name"]
```

Isso significa que o valor digitado no formulário **não será capturado corretamente**.

## Como corrigir

Você tem duas opções.

### Opção 1 — corrigir o `store.php`

Se quiser manter o formulário como está:

```
$name = trim($_POST["nomecompleto"] ?? "");
```

### Opção 2 — corrigir o `index.php`

Trocar no formulário:

```
name="nomecompleto"
```

por:

```
name="name"
```

Didaticamente, eu recomendo manter tudo padronizado com o nome da coluna do banco, por exemplo:

* formulário: `name="name"`

* PHP: `$_POST["name"]`

* banco: coluna `name`

Isso ajuda o aluno a entender o fluxo com menos confusão.

## 3. Validação dos campos

```
if ($name === "" || $email === "" || $document === "") {
    die("Preencha todos os campos.");
}
```

Aqui o script verifica se algum campo ficou vazio.

Se isso acontecer, ele usa `die()` para:

* mostrar a mensagem;

* encerrar a execução imediatamente.

### O que `die()` faz?

O `die()` interrompe o script naquele ponto.

Exemplo:

```
die("Erro!");
```

O PHP exibe `"Erro!"` e para de executar.

## 4. Conexão com o banco

```
$pdo = Connect::getInstance();
```

Obtém a conexão com o banco por meio da classe `Connect`.

## 5. Preparação do SQL

```
$stmt = $pdo->prepare("
    INSERT INTO users (name, email, document)
    VALUES (:name, :email, :document)
");
```

Aqui o código cria uma instrução SQL preparada.

### Por que usar `prepare()`?

Porque os dados vêm do usuário.

Quando existem dados dinâmicos, usar `prepare()` é muito mais seguro do que montar SQL diretamente com concatenação de strings.

Isso ajuda a evitar **SQL Injection**.

## 6. Placeholders nomeados

Na query aparecem estes marcadores:

```
:name
:email
:document
```

Eles são chamados de **placeholders nomeados**.

Depois, no `execute()`, cada placeholder recebe seu valor correspondente.

## 7. Execução da query

```
$stmt->execute([
    ":name" => $name,
    ":email" => $email,
    ":document" => $document
]);
```

Essa linha envia os dados para a instrução preparada e executa o `INSERT`.

Se tudo der certo, um novo registro será salvo na tabela `users`.

## 8. Redirecionamento

```
header("Location: index.php");
exit;
```

Depois de salvar o aluno, o sistema redireciona o navegador para a página principal.

### Por que isso é importante?

Porque evita que o usuário fique em uma página “solta” após o envio.

Também melhora a experiência:

* cadastra;

* volta para a listagem.

### E por que usar `exit`?

Porque após enviar o cabeçalho de redirecionamento, o ideal é encerrar o script imediatamente.

# Conceitos de PHP ensinados nesse arquivo

Esse arquivo é excelente para ensinar:

* `require`

* `$_POST`

* operador de coalescência nula `??`

* `trim()`

* validação básica

* `if`

* `die()`

* PDO

* `prepare()`

* `execute()`

* placeholders nomeados

* `header()`

* `exit`
