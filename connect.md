## Explicação didática para os alunos

Esse arquivo cria uma **classe de conexão com o banco de dados** usando **PDO**.

### O que é PDO?

PDO significa **PHP Data Objects**.\
É uma forma mais moderna e segura de conectar o PHP ao banco de dados.

Com PDO, o programador consegue:

* conectar ao banco;

* executar consultas;

* inserir, atualizar e excluir dados;

* tratar erros de forma mais organizada.

## O que essa classe faz?

A classe `Connect` tem a função de centralizar a conexão com o banco de dados.

Em vez de criar uma nova conexão toda vez que precisar acessar o banco, ela cria **uma única instância** e reaproveita essa conexão durante a execução.

Isso segue a ideia do padrão conhecido como **Singleton**, mesmo que aqui esteja sendo aplicado de forma simples.

## Explicando por partes

### 1. Constantes da conexão

```
private const HOST = "localhost";
private const DBNAME = "aula01";
private const USER = "root";
private const PASS = "";
```

Aqui estão os dados necessários para conectar ao banco:

* `HOST`: servidor do banco;

* `DBNAME`: nome do banco de dados;

* `USER`: usuário do banco;

* `PASS`: senha.

O uso de `const` significa que esses valores não mudam durante a execução.

### 2. Método estático `getInstance()`

```
public static function getInstance(): PDO
```

Esse método:

* é `public`, então pode ser chamado fora da classe;

* é `static`, então não precisa criar um objeto `new Connect()` para usá-lo;

* retorna um objeto do tipo `PDO`.

Exemplo de uso:

```
$conn = Connect::getInstance();
```

### 3. Variável estática interna

```
static $instance = null;
```

Essa variável guarda a conexão criada.

Como ela é `static`, o valor permanece salvo entre as chamadas do método.\
Então:

* na primeira vez, a conexão é criada;

* nas próximas, a conexão já existente é reutilizada.

### 4. Verificação da conexão

```
if ($instance === null)
```

Esse `if` verifica se ainda não existe uma conexão.

Se não existir, ele cria uma nova.\
Se já existir, apenas retorna a que já foi criada.

### 5. DSN

```
$dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=utf8mb4";
```

A DSN é a string de configuração da conexão.

Nesse caso:

* `mysql`: tipo do banco;

* `host=localhost`: servidor;

* `dbname=aula01`: nome do banco;

* `charset=utf8mb4`: conjunto de caracteres.

O `utf8mb4` é importante porque suporta corretamente acentos, símbolos e emojis.

### 6. Criação do objeto PDO

```
$instance = new PDO($dsn, self::USER, self::PASS, [
```

Aqui a conexão é realmente criada.

O `new PDO(...)` recebe:

* a string de conexão;

* o usuário;

* a senha;

* as opções adicionais.

### 7. Opções da conexão

#### Tratamento de erros

```
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
```

Isso faz com que o PDO lance exceções quando ocorrer algum erro.

Sem isso, muitos erros podem passar despercebidos.

#### Modo padrão de retorno

```
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
```

Isso define que as consultas vão retornar arrays associativos.

Exemplo:

```
[
    "id" => 1,
    "nome" => "Maria"
]
```

Em contexto didático, isso facilita bastante a leitura dos resultados.

## Exemplo de uso em outro arquivo

```
<?php

require_once "connect.php";

$conn = Connect::getInstance();

$stmt = $conn->query("SELECT * FROM usuarios");
$users = $stmt->fetchAll();

echo "<pre>";
print_r($users);
echo "</pre>";
```

## Conceitos importantes que esse arquivo ensina

Esse arquivo é ótimo para ensinar aos alunos:

* classes em PHP;

* constantes de classe;

* método estático;

* tipagem de retorno;

* PDO;

* conexão com banco de dados;

* reaproveitamento de instância;

* organização de código.
