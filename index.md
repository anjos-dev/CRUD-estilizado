## Explicação didática para os alunos

Esse arquivo é a **página principal** do sistema.\
Ele tem duas funções principais:

1. **mostrar o formulário de cadastro**;

2. **listar os alunos já cadastrados no banco**.

Ou seja, ele faz parte da interface inicial de um CRUD.

CRUD significa:

* **Create** → criar

* **Read** → ler

* **Update** → atualizar

* **Delete** → excluir

Nesse arquivo, aparecem claramente:

* o **Create**, por meio do formulário;

* o **Read**, por meio da listagem na tabela.

## O que acontece nesse arquivo, em ordem

### 1. Inclusão do arquivo de conexão

```
require __DIR__ . "/connect.php";
```

Esse comando carrega o arquivo `connect.php`, que contém a classe de conexão com o banco.

Sem isso, o sistema não conseguiria usar:

```
Connect::getInstance();
```

O uso de `__DIR__` é importante porque garante que o PHP procure o arquivo no diretório correto.

### 2. Conexão com o banco

```
$pdo = Connect::getInstance();
```

Aqui o sistema cria ou recupera a conexão com o banco de dados.

A variável `$pdo` passa a representar essa conexão.

### 3. Consulta SQL

```
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
```

Esse comando faz uma consulta SQL na tabela `users`.

A consulta significa:

* `SELECT *` → selecione todas as colunas;

* `FROM users` → da tabela `users`;

* `ORDER BY id ASC` → ordene pelo campo `id` em ordem crescente.

O resultado dessa consulta fica armazenado em `$stmt`.

### 4. Buscar os resultados

```
$users = $stmt->fetchAll();
```

Aqui os dados do banco são transformados em um array PHP.

Cada item desse array representa um aluno.

Exemplo simplificado:

```
[
    [
        "id" => 1,
        "name" => "João",
        "email" => "joao@email.com"
    ],
    [
        "id" => 2,
        "name" => "Maria",
        "email" => "maria@email.com"
    ]
]
```

## Parte HTML + PHP

Depois da lógica inicial, o arquivo passa a montar a interface da página.

Essa mistura de PHP com HTML é muito comum em projetos PHP mais simples e também é didaticamente importante para o aluno entender como o backend gera páginas dinâmicas.

## Formulário de cadastro

```
<form action="store.php" method="post">
```

Esse formulário envia os dados para o arquivo `store.php`.

Provavelmente é esse arquivo que vai:

* receber os dados;

* validar;

* inserir no banco.

### Campos do formulário

#### Nome

```
<input type="text" name="nomecompleto" required>
```

Cria um campo de texto para o nome do aluno.

#### E-mail

```
<input type="email" name="email" required>
```

Cria um campo de e-mail.

O navegador já faz uma validação básica de formato.

#### Curso

```
<input type="text" name="document" required>
```

Apesar de o campo estar sendo exibido como **Curso**, o nome enviado no formulário é `document`.

Isso funciona tecnicamente, mas didaticamente é um ponto importante: o ideal seria um nome mais semântico, como:

```
name="curso"
```

Porque `document` não deixa claro para o aluno o que está sendo armazenado.

## Tabela de listagem

A tabela exibe os dados de todos os alunos retornados do banco.

### Cabeçalho

O `<thead>` define o nome das colunas:

* ID

* Nome

* E-mail

* Curso

* Cadastrado em

* Ações

## Laço `foreach`

```
<?php foreach ($users as $user) : ?>
```

Esse trecho percorre o array `$users`.

A cada volta:

* `$users` é o conjunto completo;

* `$user` é um único aluno.

Esse tipo de laço é muito usado para exibir dados vindos do banco.

## Exibição de valores com `<?= ... ?>`

Exemplo:

```
<?= $user["name"] ?>
```

Essa é a forma curta de escrever:

```
<?php echo $user["name"]; ?>
```

Ela serve para imprimir valores diretamente no HTML.

## Formatação da data

```
<?= date("d/m/Y H:i", strtotime($user["created_at"])) ?>
```

Aqui temos duas funções importantes:

### `strtotime()`

Converte a data do banco para timestamp.

### `date()`

Formata a data para o padrão desejado.

Nesse caso:

* `d/m/Y` → dia/mês/ano

* `H:i` → hora:minuto

Exemplo:

* no banco: `2026-03-19 14:30:00`

* na tela: `19/03/2026 14:30`

## Links de ação

### Editar

```
<a href="edit.php?id=<?= $user["id"] ?>">Editar</a>
```

Envia o ID do aluno pela URL para a página de edição.

Exemplo:

```
edit.php?id=3
```

### Excluir

```
<a href="delete.php?id=<?= $user["id"] ?>" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</a>
```

Esse link também envia o ID pela URL, mas antes disso mostra uma confirmação em JavaScript.

Se o usuário clicar em **Cancelar**, o link não será aberto.

## Rodapé da tabela

```
<td colspan="6">Total de alunos: <?= count($users) ?></td>
```

Aqui o sistema mostra quantos alunos existem na listagem.

A função `count()` conta a quantidade de elementos no array `$users`.

# Conceitos de PHP que esse arquivo ensina

Esse arquivo é muito rico para aula. Ele permite explicar:

* `require`

* `__DIR__`

* uso de classe estática

* PDO

* `query()`

* `fetchAll()`

* arrays associativos

* PHP embutido no HTML

* `foreach`

* `echo` abreviado com `<?= ?>`

* envio de parâmetros pela URL

* formulário com `POST`

* formatação de data com `date()` e `strtotime()`
