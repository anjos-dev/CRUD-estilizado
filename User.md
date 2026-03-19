# Objetivo da classe `User`

A classe `User` será responsável por concentrar as operações ligadas aos usuários, como:

* listar todos os usuários;

* buscar um usuário por ID;

* cadastrar um usuário;

* atualizar um usuário;

* excluir um usuário.

Assim, em vez de escrever SQL diretamente em todos os arquivos, os arquivos da aplicação passam a delegar essas tarefas para a classe.

# Explicação didática para os alunos

## O que essa classe faz?

A classe `User` representa a ideia de que tudo o que estiver relacionado à tabela `users` pode ficar concentrado em um único lugar.

Em vez de fazer isso em vários arquivos:

```
$pdo = Connect::getInstance();
$stmt = $pdo->prepare(...);
$stmt->execute(...);
```

nós passamos a fazer algo assim:

```
$user = new User();
$user->create($name, $email, $document);
```

Isso deixa o código:

* mais limpo;

* mais organizado;

* mais reutilizável;

* mais próximo de projetos reais.

# Explicando a estrutura da classe

## 1. Inclusão do arquivo de conexão

```
require_once __DIR__ . "/connect.php";
```

A classe precisa da conexão com o banco para funcionar.

O `require_once` garante que o arquivo será incluído uma única vez.

## 2. Propriedade `$pdo`

```
private PDO $pdo;
```

Essa propriedade guarda a conexão com o banco.

Ela foi declarada como `private`, o que significa que só pode ser acessada dentro da própria classe.

## 3. Método `__construct()`

```
public function __construct()
{
    $this->pdo = Connect::getInstance();
}
```

O construtor é executado automaticamente quando criamos um objeto da classe.

Exemplo:

```
$user = new User();
```

Nesse momento, a conexão com o banco já fica disponível dentro do objeto.

## 4. Método `all()`

```
public function all(): array
```

Esse método retorna todos os usuários cadastrados.

Uso:

```
$userModel = new User();
$users = $userModel->all();
```

É o método que pode substituir a query do `index.php`.

## 5. Método `findById()`

```
public function findById(int $id): array|false
```

Esse método busca um único usuário pelo ID.

Se encontrar, retorna os dados.\
Se não encontrar, retorna `false`.

Uso:

```
$userModel = new User();
$user = $userModel->findById(3);
```

Esse método pode substituir a lógica do `edit.php`.

## 6. Método `create()`

```
public function create(string $name, string $email, string $document): bool
```

Esse método insere um novo usuário no banco.

Uso:

```
$userModel = new User();
$userModel->create("João", "joao@email.com", "GTI");
```

Ele pode substituir a lógica do `store.php`.

## 7. Método `update()`

```
public function update(int $id, string $name, string $email, string $document): bool
```

Atualiza um usuário existente com base no ID.

Uso:

```
$userModel = new User();
$userModel->update(1, "Maria", "maria@email.com", "Administração");
```

Esse método pode ser usado no `update.php`.

## 8. Método `delete()`

```
public function delete(int $id): bool
```

Exclui um usuário pelo ID.

Uso:

```
$userModel = new User();
$userModel->delete(5);
```

Esse método pode ser usado no `delete.php`.

# Conceitos que essa classe ensina

Essa classe é excelente para introduzir:

* classes em PHP;

* atributos/propriedades;

* encapsulamento com `private`;

* construtor `__construct`;

* tipagem de propriedades;

* tipagem de parâmetros;

* tipagem de retorno;

* uso de `$this`;

* organização por responsabilidade;

* reutilização de código;

* centralização da lógica de banco.

# Como usar essa classe no projeto

## Exemplo no `index.php`

Em vez de:

```
$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll();
```

ficaria:

```
require __DIR__ . "/User.php";

$userModel = new User();
$users = $userModel->all();
```

## Exemplo no `store.php`

Em vez de fazer o `INSERT` diretamente:

```
require __DIR__ . "/User.php";

$userModel = new User();
$userModel->create($name, $email, $document);
```

## Exemplo no `edit.php`

```
require __DIR__ . "/User.php";

$userModel = new User();
$user = $userModel->findById($id);
```

## Exemplo no `update.php`

```
require __DIR__ . "/User.php";

$userModel = new User();
$userModel->update($id, $name, $email, $document);
```

## Exemplo no `delete.php`

```
require __DIR__ . "/User.php";

$userModel = new User();
$userModel->delete($id);
```
